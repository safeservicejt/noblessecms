<?php

/*

Theme install & uninstall: Create file functions.php in root dir of theme then call to below functions

Theme::install(function(){
	
// Do you need

});

Theme::uninstall(function(){
	
// Do you need

});

Add shortcode use in theme: Create file shortcode.php in theme folder

// Shortcode::templateAdd('testv','simple_youtube_parse');


// function simple_youtube_parse($inputData=array())
// {
// 	$value=$inputData['value'];

// 	return '<a href="http://youtube.com?v='.$value.'">Click tosss watch video</a>';
// }



Theme::settingUri(array(
	''=>'home@index',
	'search'=>'search@index',
	'contactus'=>'contactus@index',
	'page'=>'page@index',
	'rss'=>'rss@index',
	'404page'=>'404page@index',
	'tag'=>'tag@index',
	'category'=>'category@index'
	));

Theme::settingUri(array(
	''=>'home@index',
	'search'=>'search@index',
	'manga'=>array(
		''=>'manga@index',
		'[a-zA-Z0-9\_\-]+\/\d+\.html$'=>'manga@chapter'
		),
	'author'=>'author@index',
	'contactus'=>'contactus@index',
	'page'=>'page@index',
	'rss'=>'rss@index',
	'404page'=>'404page@index',
	'tag'=>'tag@index',
	'category'=>'category@index'
	));
	
Theme::settingUri(array(
	''=>'home@index',
	'search'=>'search@index',
	'contactus'=>'contactus@index',
	'page'=>array(
		'tset-page'=>'page@test',
		'tset-[a-zA-Z]+'=>'page@testsub',
		),
	'rss'=>'rss@index',
	'404page'=>'404page@index',
	'tag'=>'tag@index',
	'category'=>'category@index'
	));

Theme::render();

*/
class Theme
{
	public static $can_install='no';

	public static $can_uninstall='no';

	private static $data=array();

	public static $layoutPath='';

	public static function install($func)
	{
		if(self::$can_install=='no')
		{
			return false;
		}


        if (is_object($func)) {

            (object)$varObject = $func;

            $func = '';

            $varObject();

        } 
	}



	public function settingUri($inputData=array())
	{
		self::$data['path']=System::getThemePath().self::$layoutPath;

		self::$data['site_url']=System::getUrl();

		self::$data['theme_url']=System::getThemeUrl();

		/*
		self::$settingUri(array(
		'/'=>'home@index',
		'post'=>'post@index'
		));

		*/

		self::$data['list_uri']=$inputData;
	}

	public static function render()
	{
		$curUri=System::getUri();

		$controllerName='home';

		$funcName='index';

		$pageName='';

		// 'baiviet'=>'post@index'
		if(preg_match('/^\/?(\w+)/i', $curUri,$match))
		{
			$pageName=$match[1];

			if(!isset(self::$data['list_uri'][$pageName]))
			{
				$controllerName=$pageName;
			}
			else
			{
				$cName=self::$data['list_uri'][$pageName];

				if(!is_array($cName) && preg_match_all('/(\w+)/i', $cName,$matchName))
				{
					$controllerName=$matchName[1][0];

					$funcName=isset($matchName[1][1])?$matchName[1][1]:'index';
				}
				else
				{
					$controllerName=isset($cName[''])?$cName['']:$pageName;

					$funcName='index';

					$total=count($cName);

					$listKey=array_keys($cName);

					$listVal=array_values($cName);


					for ($i=0; $i < $total; $i++) { 

						$matchUri=$pageName.'\/'.$listKey[$i];

						$matchVal=$listVal[$i];

						if(preg_match('/^\/?'.$matchUri.'/i', $curUri,$matchName))
						{
							preg_match_all('/(\w+)/i', $matchVal,$matchSub);

							$controllerName=$matchSub[1][0];

							$funcName=isset($matchSub[1][1])?$matchSub[1][1]:'index';

						}
					}
				}
			}
		}

		if(!isset(self::$data['list_uri'][$pageName]))
		{
			Alert::make('Page not found');
		}

		self::controller($controllerName,$funcName);

		
	}

	public static function controller($viewName,$funcName='index')
	{
		Model::loadWithPath($viewName,self::$data['path'].'models/');

		Controller::loadWithPath('theme'.ucfirst($viewName),$funcName,self::$data['path'].'controllers/');
	}

	public static function model($viewName)
	{
		Model::loadWithPath($viewName,self::$data['path'].'models/');
	}

	public static function view($viewName,$inputData=array())
	{
		if(!isset(self::$data['render_header']))
		{
			$codeHead=Plugins::load('site_header');

			$codeHead=is_array($codeHead)?'':$codeHead;

			$codeFooter=Plugins::load('site_footer');

			$codeFooter=is_array($codeFooter)?'':$codeFooter;

			System::defineGlobalVar('site_header',$codeHead);

			System::defineGlobalVar('site_footer',$codeFooter);	
					
			self::$data['render_header']='yes';
		}	

		View::makeWithPath($viewName,$inputData,self::$data['path'].'views/');
	}


    public static function checkThemeDomain()
    {   
    	$themeName=System::getThemeName();

    	// domain.com

        $filePath=THEMES_PATH.$themeName.'/domain.txt';

        if(!file_exists($filePath))
        {
        	return false;
        }

        $loadData='http://'.trim(file_get_contents($filePath)).'/';

        if($loadData!=System::getUrl())
        {
        	Redirect::to($loadData.System::getUri());
        }
    }

    public static function checkThemePrefix()
    {   
    	$themeName=System::getThemeName();

        $filePath=THEMES_PATH.$themeName.'/prefix.txt';

        if(!file_exists($filePath))
        {
        	return false;
        }

        $loadData=unserialize(file_get_contents($filePath));

        if(is_array($loadData))
        {
        	$prefix=isset($loadData['prefix'])?$loadData['prefix']:'';

        	Database::setPrefix($prefix);
        	
    		$prefixAll=isset($loadData['prefixall'])?$loadData['prefixall']:'no';

        	Database::setPrefixAll($prefix);       	
        }
    }


	public static function uninstall($func)
	{
		if(self::$can_uninstall=='no')
		{
			return false;
		}

        if (is_object($func)) {

            (object)$varObject = $func;

            $func = '';

            $varObject();

        } 
	}

	public static function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:1000;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$listDir=Dir::listDir(THEMES_PATH);

		$total=count($listDir);

		$result=array();

		for($i=$limitPage;$i<$limitShow;$i++)
		{
			if(!isset($listDir[$i]))
			{
				continue;
			}

			if($listDir[$i]==THEME_NAME)
			{
				continue;
			}
			
			$path=THEMES_PATH.$listDir[$i].'/';
			$url=THEMES_URL.$listDir[$i].'/';

			if(!file_exists($path.'info.txt'))
			{
				continue;
			}

			$result[$listDir[$i]]=file($path.'info.txt');

			$result[$listDir[$i]]['thumbnail']=$url.'thumb.jpg';
			
			if(!file_exists($path.'thumb.jpg'))
			{
				$result[$listDir[$i]]['thumbnail']=System::getUrl().'bootstrap/images/thumb.jpg';
			}
			

		}
		return $result;
		
	}


	public static function setActivate($themeName)
	{
		// if(Domain::isOtherDomain())
		// {
		// 	DomainManager::activateTheme();

		// 	return false;
		// }

		$path=ROOT_PATH.'contents/themes/'.$themeName.'/';

		if(!is_dir($path))
		{
			throw new Exception("This theme not exists");
		}

		$info=$path.'info.txt';

		if(!file_exists($info))
		{
			throw new Exception("This theme not valid.");
		}

		$oldthemeName=System::getThemeName();
		
		if(class_exists('CustomPlugins'))
		{
			CustomPlugins::removeByPath($oldthemeName);
		}

		// Make uninstall old theme
		if(isset($oldthemeName[1]))
		{
			$oldPath=ROOT_PATH.'contents/themes/'.$oldthemeName.'/';



			if(file_exists($oldPath.'deactivate.php'))
			{
				self::$can_uninstall='yes';

				self::$can_install='no';

				Plugins::$canInstall='no';

				Plugins::$canUninstall='yes';
								
				include($oldPath.'deactivate.php');

				Plugins::makeUninstall($oldthemeName,'yes');				


			}
		}


		$configPath=ROOT_PATH.'config.php';

		$data=file_get_contents($configPath);

		$data=preg_replace('/"THEME_NAME", \'\w+\'/i', '"THEME_NAME", \''.$themeName.'\'', $data);

		File::create($configPath,$data);

		if(file_exists($path.'activate.php'))
		{
			self::$can_install='yes';

			self::$can_uninstall='no';
			
			Plugins::$canInstall='yes';
			
			Plugins::$canUninstall='no';

			include($path.'activate.php');

		}	
		
		if(file_exists($path.'functions.php'))
		{
			include($path.'functions.php');
		}	


	}



	public static function getDefault()
	{
		$path=ROOT_PATH.'contents/themes/'.System::getThemeName().'/';

		$resultData=array();

		$resultData=file($path.'info.txt');

		$resultData['image']=System::getThemeUrl().'thumb.jpg';

		if(!file_exists($path.'thumb.jpg'))
		{
			$resultData['image']=System::getUrl().'bootstrap/images/thumb.jpg';
		}		

		$resultData['name']=System::getThemeName();

		return $resultData;		
	}

	public static function getThemeHeader()
	{
		$data=Plugins::load('site_header');

		return $data;
	}

	public static function getThemeFooter()
	{
		$data=Plugins::load('site_footer');

		return $data;
	}

	public static function getAdmincpHeader()
	{
		$data=Plugins::load('admincp_header');

		return $data;
	}

	public static function getAdmincpFooter()
	{
		$data=Plugins::load('admincp_footer');

		return $data;
	}

	public static function getUsercpHeader()
	{
		$data=Plugins::load('usercp_header');

		return $data;
	}

	public static function getUsercpFooter()
	{
		$data=Plugins::load('usercp_footer');

		return $data;
	}

    public static function loadShortCode()
    {
        $path=System::getThemePath().'shortcode.php';

        if(!file_exists($path))
        {
            return false;
        }

        require($path);

        // try {

        //     require($path);

        // } catch (Exception $e) {

        //     throw new Exception("Error while require functions of theme ".THEME_NAME);

        // }

    }

	public static function remove($themeName)
	{

	}

	public static function makeSetting($themeName='',$inputData=array())
	{
		$themeName=!isset($themeName[1])?THEME_NAME:$themeName;

		$total=count($inputData);

		if((int)$total > 0)
		{	
			$loadData=array();

			if($loadData=Cache::loadKey('dbcache/'.Database::getPrefix().$themeName,-1))
			{
				$loadData=unserialize($loadData);
			}

			$listKeys=array_keys($inputData);

			for ($i=0; $i < $total; $i++) { 
				$theKey=$listKeys[$i];

				$loadData[$theKey]=$inputData[$theKey];
			}

			$loadData=serialize($loadData);

			Cache::saveKey('dbcache/'.Database::getPrefix().$themeName,$loadData);
		}

	}

	public static function loadSetting($themeName='')
	{
		$themeName=!isset($themeName[1])?THEME_NAME:$themeName;

		if(!$loadData=Cache::loadKey('dbcache/'.Database::getPrefix().$themeName,-1))
		{
			return false;
		}

		$loadData=unserialize($loadData);

		$loadData['facebook_app_id']=isset($loadData['facebook_app_id'])?$loadData['facebook_app_id']:'675779382554952';

		$loadData['site_top_content']=isset($loadData['site_top_content'])?$loadData['site_top_content']:'';

		$loadData['site_bottom_content']=isset($loadData['site_bottom_content'])?$loadData['site_bottom_content']:'';

		$loadData['site_top_left_content']=isset($loadData['site_top_left_content'])?$loadData['site_top_left_content']:'';

		$loadData['site_bottom_left_content']=isset($loadData['site_bottom_left_content'])?$loadData['site_bottom_left_content']:'';

		$loadData['site_top_right_content']=isset($loadData['site_top_right_content'])?$loadData['site_top_right_content']:'';

		$loadData['site_bottom_right_content']=isset($loadData['site_bottom_right_content'])?$loadData['site_bottom_right_content']:'';

		$loadData['site_right_content']=isset($loadData['site_right_content'])?$loadData['site_right_content']:'';

		$loadData['site_left_content']=isset($loadData['site_left_content'])?$loadData['site_left_content']:'';

		$loadData['post_top_content']=isset($loadData['post_top_content'])?$loadData['post_top_content']:'';

		$loadData['post_bottom_content']=isset($loadData['post_bottom_content'])?$loadData['post_bottom_content']:'';

		$loadData['theme_color']=isset($loadData['theme_color'])?$loadData['theme_color']:'black';

		$loadData['layout_name']=isset($loadData['layout_name'])?$loadData['layout_name']:'';

		$loadData['site_logo']=isset($loadData['site_logo'])?$loadData['site_logo']:System::getUrl().'contents/themes/'.$themeName.'/images/logo.png';


		return $loadData;		
	}

}