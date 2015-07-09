<?php

class Url
{
	public function themeController($controlName,$themeName)
	{
		$url=ADMINCP_URL.'theme/setting/'.$themeName.'/controller/'.$controlName.'/';

		return $url;
	}

	public function makeFriendly($text)
	{
		$text=String::makeFriendlyUrl($text);

		return $text;
	}
	
	public function category($inputData)
	{
		$url=System::getUrl().'category/'.trim($inputData['friendly_url']);

		return $url;		
	}

	public function tag($inputData)
	{
		$url=System::getUrl().'tag/'.trim($inputData['title']);

		return $url;
	}
	
	public function post($inputData)
	{
		$url=System::getUrl().'post/'.trim($inputData['friendly_url']).'.html';

		return $url;
	}
	public function page($inputData)
	{
		$url=System::getUrl().'page/'.trim($inputData['friendly_url']).'.html';

		return $url;
	}

}

?>