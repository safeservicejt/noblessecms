<?php

/*

	Config cho domain:

	Datapath root_path/contents/domains/domain_name/config.cache

	Tại đây lưu các thông tin về config như: database,prefix,theme,plugin

	All config about theme/plugin is in array.

	$config['theme']='theme_name';

	$config['themeallow']=array(); //list allow theme name

	$config['themedisallow']=array(); //list disallow theme name

	$config['plugin']='plugin_name';

	$config['pluginallow']=array(); //list allow plugin name

	$config['plugindisallow']=array(); //list disallow plugin name


*/

class Domain
{
	public static $config=array();

	public static function checkAdminCP()
	{
		if(System::$setting['system_mode']=='basic' || isset($_SESSION['other_domain']))
		{
			return false;
		}

		$theDomain=$_SERVER['HTTP_HOST'];

		$parse=parse_url(ROOT_URL);

		if($theDomain!=$parse['host'])
		{
			$_SESSION['other_domain']='yes';
		}

	}

	public static function isOtherDomain()
	{
		if(isset($_SESSION['is_otherdomain']))
		{
			return true;
		}

		$theDomain=$_SERVER['HTTP_HOST'];

		$oldDomain=parse_url(ROOT_URL);

		$oldHost=$oldDomain['host'];

		if($oldHost!=$theDomain)
		{
			$_SESSION['is_otherdomain']='yes';
			
			return true;
		}

		return false;
	}

	public static function configPath($domainName='')
	{
		$result=ROOT_PATH.'contents/domains/';

		$result=isset($domainName[2])?$result.$domainName.'/':$result;

		// if(!is_dir($result))
		// {
		// 	Dir::create($result);
		// }

		return $result;
	}


	public static function isAllowTheme($pluginName='',$domainName='',$attr='')
	{
		if(!self::isOtherDomain())
		{
			return true;
		}

		$theDomain=$_SERVER['HTTP_HOST'];

		$theDomain=!isset($domainName[1])?$theDomain:$domainName;

		$attr=isset($attr[1])?'/'.$attr:'';

		$allowPath=self::configPath($theDomain).'allow/theme/'.$pluginName.$attr;

		$lockPath=self::configPath($theDomain).'lock/theme/'.$pluginName.$attr;

		if(!is_dir($allowPath) && !is_dir($lockPath))
		{
			return false;
		}
		
		if(!is_dir($allowPath) || is_dir($lockPath))
		{
			return false;
		}


		return true;

	}

	public static function isAllowPlugin($pluginName='',$domainName='',$attr='')
	{
		if(!self::isOtherDomain())
		{
			return true;
		}

		$theDomain=$_SERVER['HTTP_HOST'];

		$theDomain=!isset($domainName[1])?$theDomain:$domainName;

		$attr=isset($attr[1])?'/'.$attr:'';

		$allowPath=self::configPath($theDomain).'allow/plugin/'.$pluginName.$attr;

		$lockPath=self::configPath($theDomain).'lock/plugin/'.$pluginName.$attr;

		if(!is_dir($allowPath) && !is_dir($lockPath))
		{
			return false;
		}

		if(!is_dir($allowPath) || is_dir($lockPath))
		{
			return false;
		}


		return true;

	}

	public static function saveDomainConfig($domainName,$inputData=array())
	{
		$filePath=self::configPath().'config.cache';

		File::create($filePath,serialize($inputData));
	}


	public static function loadDomainConfig($domainName='')
	{
		$configPath=self::configPath($domainName).'config.cache';

		if(!file_exists($configPath))
		{
			return false;
		}

		$loadData=unserialize(file_get_contents($configPath));

		return $loadData;
	}

	public static function checkConfig()
	{
		$theDomain=$_SERVER['HTTP_HOST'];

		$parse=parse_url(ROOT_URL);

		$masterUrl=$parse['host'];

		if($masterUrl==$theDomain)
		{
			return false;
		}

		$loadPath=self::configPath().$theDomain.'/config.cache';

		if(!file_exists($loadPath))
		{
			Alert::make('This domain not activated in our server.');
		}

		$loadData=unserialize(file_get_contents($loadPath));

		$status=isset($loadData['status'])?$loadData['status']:1;

		if((int)$status==0)
		{
			Alert::make('This domain not activated in our server.');
			
			// return false;
		}

		// if(isset($loadData['time_expires']))
		// {
		// 	$thistime=time();

		// 	if((int)$thistime > (int)$loadData['time_expires'])
		// 	{
		// 		Alert::make('Your domain have been expired!');
		// 	}
		// }

		$loadData['domain']=$theDomain;

		self::$config=$loadData;


		System::setUrl('http://'.$theDomain.'/');


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

		System::setTheme($theme,'no');


	}

	public static function setTheme($themeName='')
	{
		if(!isset($themeName[1]))
		{
			return false;
		}

		$theDomain=$_SERVER['HTTP_HOST'];

		$loadPath=self::configPath().$theDomain.'/config.cache';

		if(class_exists('DomainManager'))
		{
			DomainManager::saveSetting($theDomain,array(
				'theme'=>$themeName
				));

			System::setTheme($themeName,'no');

		}

	}

	public static function checkConnectDB()
	{
        // global $db;


		$connect_type=isset(self::$config['connect_type'])?self::$config['connect_type']:'prefix';

		$prefix=isset(self::$config['prefix'])?self::$config['prefix']:'';

		Database::setPrefix($prefix);

		Database::setPrefixAll();

		if($connect_type=='database')
		{
			$dbtype=isset(self::$config['dbtype'])?self::$config['dbtype']:'mysqli';

			$dbport=isset(self::$config['dbport'])?self::$config['dbport']:$GLOBALS['db']['default']['dbport'];

			$dbuser=isset(self::$config['dbuser'])?self::$config['dbuser']:$GLOBALS['db']['default']['dbuser'];

			$dbpassword=isset(self::$config['dbpassword'])?self::$config['dbpassword']:$GLOBALS['db']['default']['dbpassword'];

			$dbname=isset(self::$config['dbname'])?self::$config['dbname']:$GLOBALS['db']['default']['dbname'];

			$GLOBALS['db']['default']['dbhost']=$dbhost;

			$GLOBALS['db']['default']['dbtype']=$dbtype;

			$GLOBALS['db']['default']['dbport']=$dbport;

			$GLOBALS['db']['default']['dbuser']=$dbuser;

			$GLOBALS['db']['default']['dbpassword']=$dbpassword;

			$GLOBALS['db']['default']['dbname']=$dbname;			
		}

		DomainManager::installDomainSettings();

		if(!isset($_COOKIE['root_url']))
		{
			header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

			die();
		}



	}

}

?>