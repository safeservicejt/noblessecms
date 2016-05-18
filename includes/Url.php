<?php

class Url
{
	public static function themeController($controlName,$themeName)
	{
		$url=ADMINCP_URL.'theme/setting/'.$themeName.'/controller/'.$controlName.'/';

		return $url;
	}

	public static function makeFriendly($text)
	{
		$text=String::makeFriendlyUrl($text);

		return $text;
	}
	
	public static function category($inputData)
	{
		$url=System::getUrl().'category/'.trim($inputData['friendly_url']);

		return $url;		
	}

	public static function tag($inputData)
	{
		$url=System::getUrl().'tag/'.$inputData['friendly_url'];

		return $url;
	}
	
	public static function post($inputData)
	{
		$url=System::getUrl().'post/'.trim($inputData['friendly_url']).'.html';

		return $url;
	}
	public static function page($inputData)
	{
		$url=System::getUrl().'page/'.trim($inputData['friendly_url']).'.html';

		return $url;
	}

	public static function theme($inputData='')
	{
		$inputData=isset($inputData[1])?$inputData:THEME_NAME;

		$url=System::getUrl().'contents/themes/'.$inputData.'/';

		return $url;
	}

	public static function plugin($inputData='')
	{
		$inputData=isset($inputData[1])?$inputData:THEME_NAME;

		$url=System::getUrl().'contents/plugins/'.$inputData.'/';

		return $url;
	}

}
