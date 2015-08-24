<?php

class App
{

	private static $config=array(

		'locale'=>LANGUAGE

		);

	function __construct()
	{
		$locale=LANGUAGE;

		if(isset($_COOKIE['locale']))
		{
			$locale=$_COOKIE['locale'];
		}

		self::$config['locale']=$locale;
	}

	public function get($keyName)
	{
		if(!isset(self::$config[$keyName]))
		{
			return false;
		}

		return self::$config[$keyName];
	}

	public function set($keyName,$keyValue)
	{
		if($keyName=='')
		{
			return false;
		}

		self::$config[$keyName]=$keyValue;
	}

	public function setLocale($keyValue)
	{
		if($keyValue=='')
		{
			return false;
		}

		self::$config['locale']=$keyValue;

		Cookie::make('locale',$keyValue,1440*7);
	}


}

?>