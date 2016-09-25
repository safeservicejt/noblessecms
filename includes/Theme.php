<?php

/*

Theme struct

- controllers

- models

- views

- shortcodes.php

- install.php

- uninstall.php

------------------------------------------------------------------------

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



*/
class Theme
{

	public static $can_install='no';

	public static $can_uninstall='no';

	private static $data=array();

	public static $setting=array();

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



	public static function activate($themeName='')
	{

		$oldTheme=System::getThemeName();

		$oldThemePath=THEMES_PATH.$oldTheme.'/';

		$newThemePath=THEMES_PATH.$themeName.'/';

		if(file_exists($oldThemePath.'uninstall.php'))
		{
			include($oldThemePath.'uninstall.php');
		}

		if(file_exists($newThemePath.'install.php'))
		{
			include($newThemePath.'install.php');
		}

		System::saveSetting(array(
			'theme_name'=>$themeName
			));
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
				$result[$listDir[$i]]['thumbnail']=System::getUrl().'bootstraps/images/thumb.jpg';
			}
			

		}
		return $result;
		
	}

	public static function settingUrl($controlName,$methodName='index')
	{
		$url=System::getAdminUrl().'theme/setting/'.$controlName.'/'.$methodName;

		return $url;
	}

	public static function getDefault()
	{
		$path=ROOT_PATH.'contents/themes/'.System::getThemeName().'/';

		$resultData=array();

		$resultData=file($path.'info.txt');

		$resultData['image']=System::getThemeUrl().'thumb.jpg';

		if(!file_exists($path.'thumb.jpg'))
		{
			$resultData['image']=System::getUrl().'bootstraps/images/thumb.jpg';
		}		

		$resultData['name']=System::getThemeName();

		return $resultData;		
	}

	public static function loadSetting($themeName='')
	{
		$savePath=ROOT_PATH.'caches/theme/'.$themeName.'.cache';

		$result=false;

		if(file_exists($savePath))
		{
			// $result=String::decrypt(base64_decode(unserialize(file_get_contents($savePath))));

			$result=unserialize(base64_decode(String::decrypt(file_get_contents($savePath))));
		}

		self::$setting=$result;



		System::defineVar('themeSetting',$result);

		return $result;

	}

	public static function makeSetting($themeName='',$inputData=array())
	{
		$savePath=ROOT_PATH.'caches/theme/'.$themeName.'.cache';

		$saveData=array();

		if(file_exists($savePath))
		{
			$saveData=String::decrypt(base64_decode(unserialize(file_get_contents($savePath))));
		}

		$total=count($inputData);

		$keyNames=array_keys($inputData);

		for ($i=0; $i < $total; $i++) { 
			$theKey=$keyNames[$i];

			$saveData[$theKey]=$inputData[$theKey];
		}


		$saveData['facebook_app_id']=isset($saveData['facebook_app_id'])?$saveData['facebook_app_id']:'675779382554952';

		$saveData['site_top_content']=isset($saveData['site_top_content'])?$saveData['site_top_content']:'';

		$saveData['site_bottom_content']=isset($saveData['site_bottom_content'])?$saveData['site_bottom_content']:'';

		$saveData['site_top_left_content']=isset($saveData['site_top_left_content'])?$saveData['site_top_left_content']:'';

		$saveData['site_bottom_left_content']=isset($saveData['site_bottom_left_content'])?$saveData['site_bottom_left_content']:'';

		$saveData['site_top_right_content']=isset($saveData['site_top_right_content'])?$saveData['site_top_right_content']:'';

		$saveData['site_bottom_right_content']=isset($saveData['site_bottom_right_content'])?$saveData['site_bottom_right_content']:'';

		$saveData['site_right_content']=isset($saveData['site_right_content'])?$saveData['site_right_content']:'';

		$saveData['site_left_content']=isset($saveData['site_left_content'])?$saveData['site_left_content']:'';

		$saveData['post_top_content']=isset($saveData['post_top_content'])?$saveData['post_top_content']:'';

		$saveData['post_bottom_content']=isset($saveData['post_bottom_content'])?$saveData['post_bottom_content']:'';

		$saveData['theme_color']=isset($saveData['theme_color'])?$saveData['theme_color']:'black';

		$saveData['layout_name']=isset($saveData['layout_name'])?$saveData['layout_name']:'';

		$saveData['site_logo']=isset($saveData['site_logo'])?$saveData['site_logo']:System::getUrl().'contents/themes/'.$themeName.'/images/logo.png';	

		File::create($savePath,String::encrypt(base64_encode(serialize($saveData))));
	}
}