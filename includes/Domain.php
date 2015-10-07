<?php

/*

	Config cho domain:

	Datapath root_path/contents/domains/domain_name/config.cache

	Tại đây lưu các thông tin về config như: database,prefix,theme,plugin

*/

class Domain
{
	public static $config=array();

	public static function configPath()
	{
		$result=ROOT_PATH.'contents/domains/';

		if(!is_dir($result))
		{
			Dir::create($result);
		}

		return $result;
	}

	public static function checkConfig()
	{
		$theDomain=$_SERVER['HTTP_HOST'];

		$loadPath=self::configPath().$theDomain.'/config.cache';

		if(!file_exists($loadPath))
		{
			return false;
		}

		$loadData=unserialize(file_get_contents($loadPath));

		self::$config=$loadData;

	}

	public static function loadConfig($method='before_load_database')
	{
		if(!isset(self::$config[$method]))
		{
			return false;
		}

		$value=self::$config[$method];

		return $value;
	}

	public static function checkTheme()
	{
		if(!isset(self::$config['theme']))
		{
			return false;
		}		

		$theme=self::$config['theme'];

		System::setTheme($theme,'yes');
	}

	public static function checkConnectDB()
	{
        // global $db;

		if(!isset(self::$config['dbhost']))
		{
			return false;
		}

		$dbhost=self::$config['dbhost'];

		if(!isset($dbhost[2]))
		{
			return false;
		}

		$prefix=isset(self::$config['prefix'])?self::$config['prefix']:'';

		Database::setPrefix($prefix);

		Database::setPrefixAll();

		$dbtype=self::$config['dbtype'];

		$dbport=self::$config['dbport'];

		$dbuser=self::$config['dbuser'];

		$dbpassword=self::$config['dbpassword'];

		$dbname=self::$config['dbname'];

		$GLOBALS['db']['default']['dbhost']=$dbhost;

		$GLOBALS['db']['default']['dbtype']=$dbtype;

		$GLOBALS['db']['default']['dbport']=$dbport;

		$GLOBALS['db']['default']['dbuser']=$dbuser;

		$GLOBALS['db']['default']['dbpassword']=$dbpassword;

		$GLOBALS['db']['default']['dbname']=$dbname;

	}

}

?>