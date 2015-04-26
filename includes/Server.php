<?php

class Server
{

	public function getTitle()
	{
		return GlobalCMS::$setting['title'];
	}

	public function getDescription()
	{
		return GlobalCMS::$setting['description'];
	}

	public function getKeywords()
	{
		return GlobalCMS::$setting['keywords'];
	}

	public function getUrl()
	{
		$url=isset($_SESSION['root_url'])?$_SESSION['root_url']:ROOT_URL;

		return $url;
	}

	public function getThemeName()
	{
		$url=isset($_SESSION['themeName'])?$_SESSION['themeName']:THEME_NAME;

		return $url;
	}

	public function getThemeUrl()
	{
		$themeName=self::getThemeName();

		$url=self::getUrl().self::getThemeName().'/';

		return $url;
	}

	public function getThemePath()
	{
		$themeName=self::getThemeName();

		$url=ROOT_PATH.'contents/themes/'.self::getThemeName().'/';

		return $url;
	}

	public function domainDetect()
	{
		$domain=Http::get('host');

		if(!preg_match('/'.$domain.'/i', self::getUrl(),$match))
		{
			$_SESSION['root_url']='http://'.$domain.$_SERVER['REQUEST_URI'];
		}
	}


	public function getStartTime()
	{
		$data=GlobalCMS::$load['start_time'];
		
		return $data;
	}
	
	public function releaseTTL()
	{
		$_SESSION['start_time']=time();
		
		return $data;
	}

	public function getTTL()
	{
		$start_time=GlobalCMS::$load['start_time'];

		$this_time=time();

		$ttl=(int)$this_time-(int)$start_time;

		return $ttl;
	}

	public function getSetting()
	{
		$path=ROOT_PATH.'uploads/setting.data';

		$dataLoad=file_get_contents($path);

		$dataLoad=json_decode($dataLoad,true);

		return $dataLoad;
	}

	public function getDate($str="Y-m-d h:i:s")
	{
		$data=date($str);

		return $data;
	}

	public function formatDate($time,$str="M d, Y")
	{
		$data=date($str,$time);		

		return $data;
	}



}

?>