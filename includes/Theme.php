<?php

/*

Theme install & uninstall: Create file functions.php in root dir of theme then call to below functions

Theme::install(function(){
	
// Do you need

});

Theme::uninstall(function(){
	
// Do you need

});


*/
class Theme
{
	public static $can_install='no';

	public static $can_uninstall='no';

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

	public static function checkThemeConfig()
	{
		$themePath=System::getThemePath();

		if(!file_exists($themePath.'config.php'))
		{
			return false;
		}

		include($themePath.'config.php');

		if(!class_exists('ThemeConfig'))
		{
			return false;
		}

		System::$themeConfig=ThemeConfig::index();

	}

	public static function loadThemeConfig($method='before_load_database')
	{
		if(!isset(System::$themeConfig[$method]))
		{
			return false;
		}

		$func=System::$themeConfig[$method];

		if(!isset($func[2]))
		{
			return false;
		}

		if(!method_exists('ThemeConfig', $func))
		{
			return false;
		}

		ThemeConfig::$func();
	}

    public static function checkThemePrefix()
    {   
    	$themeName=System::getThemeName();

        $filePath=ROOT_PATH.'application/caches/theme/'.$themeName.'.cache';

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

    		Cookie::make('prefixall',$prefixAll,1440*7);         	
        }
    }

    public static function checkDomain()
    {   

        $theDomain=$_SERVER['HTTP_HOST'];

        if(isset($_COOKIE['changed_domain']))
        {
        	$oldDomain=$_COOKIE['changed_domain'];

        	if($oldDomain==$theDomain)
        	{
        		return false;
        	}
        }

        $filePath=ROOT_PATH.'application/caches/domain/'.$theDomain.'.cache';

        if(!file_exists($filePath))
        {
        	return false;
        }

        $loadData=unserialize(file_get_contents($filePath));

        if(is_array($loadData))
        {
        	if(isset($loadData['prefix']))
        	{
        		Database::setPrefix($loadData['prefix']);

        		$prefixAll=isset($loadData['prefixall'])?$loadData['prefixall']:'no';

        		Cookie::make('prefixall',$prefixAll,1440*7);  
        	}

        	if(isset($loadData['theme']))
        	{
	        	$theme=$loadData['theme'];

	        	if(!file_exists(THEMES_PATH.$theme.'/index.php'))
	        	{
	        		return false;
	        	}

	        	System::setTheme($theme,'yes');

	        	Cookie::make('changed_domain',$theDomain,1440*7);        		
        	}



        }
    }

	public static function addToDomain($inputData='')
	{
		$data=debug_backtrace();

		/*

		Theme::addToDomain('client.dev');

	    [0] => Array
	        (
	            [file] => D:\wamp\htdocs\project\2015\noblessecmsv2\routes.php
	            [line] => 8
	            [function] => api
	            [class] => Plugins
	            [type] => ::
	            [args] => Array
	                (
	                )

	        )



		*/		

		$pluginPath=dirname($data[0]['file']).'/';

		$foldername=basename($pluginPath);

		$themePath=THEMES_PATH.$foldername.'/';

		if(!file_exists($themePath.'domain.php'))
		{
			return false;
		}

		include($themePath.'domain.php');

		$theDomain=ThemeDomain::getDomain();

		if($theDomain!=$inputData)
		{
			return false;
		}

		$saveData=array(
			'domain'=>$theDomain,
			'theme'=>$foldername
			);

		$savePath=ROOT_PATH.'application/caches/domain/'.$theDomain.'.cache';

		File::create($savePath,serialize($saveData));

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

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:10;

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

			if(!file_exists($path.'info.txt') || !file_exists($path.'thumb.jpg'))
			{
				continue;
			}

			$result[$listDir[$i]]=file($path.'info.txt');

			$result[$listDir[$i]]['thumbnail']=$url.'thumb.jpg';

		}
		return $result;
		
	}

	public static function setActivate($themeName)
	{
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

		$oldthemeName=THEME_NAME;

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

			}
		}

		Domain::setTheme($themeName);

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

    public static function controller($pageName,$func='index',$otherPath='')
    {
    	$themePath=System::getThemePath().'controller/';

    	if(isset($otherPath[1]))
    	{
    		$themePath=$otherPath;
    	}

    	Controller::loadWithPath('theme'.ucfirst($pageName),$func,$themePath);
    }

    public static function model($pageName,$otherPath='')
    {
    	$themePath=System::getThemePath().'model/';

    	if(isset($otherPath[1]))
    	{
    		$themePath=$otherPath;
    	}

    	Model::loadWithPath($pageName,$themePath);
    }

    public static function view($pageName,$inputData=array(),$otherPath='')
    {
    	$themePath=System::getThemePath().'view/';
    	
    	if(isset($otherPath[1]))
    	{
    		$themePath=$otherPath;
    	}

    	View::makeWithPath($pageName,$inputData,$themePath);
    }

	public static function remove($themeName)
	{

	}


}
?>