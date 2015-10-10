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
		$status=isset($_SESSION['other_domain'])?true:false;

		return $status;
	}

	public static function configPath($domainName='')
	{
		$result=ROOT_PATH.'contents/domains/';

		$result=isset($domainName[2])?$result.$domainName.'/':$result;

		if(!is_dir($result))
		{
			Dir::create($result);
		}

		return $result;
	}

	public static function isAllowTheme($pluginName='',$domainName='')
	{
		if(System::$setting['system_mode']=='basic')
		{
			return true;
		}

		$theDomain=$_SERVER['HTTP_HOST'];

		$theDomain=!isset($domainName[1])?$theDomain:$domainName;

		if(!is_array(self::$config['themedisallow']))
		{
			return true;
		}

		if(!isset(self::$config['themedisallow']))
		{
			return true;
		}

		if(in_array($pluginName, self::$config['themedisallow']))
		{
			return false;
		}

		return true;

	}

	public static function isAllowPlugin($pluginName='',$domainName='')
	{
		if(System::$setting['system_mode']=='basic')
		{
			return true;
		}

		$theDomain=$_SERVER['HTTP_HOST'];

		$theDomain=!isset($domainName[1])?$theDomain:$domainName;

		if(!is_array(self::$config['plugindisallow']))
		{
			return true;
		}

		if(!isset(self::$config['plugindisallow']))
		{
			return true;
		}

		if(in_array($pluginName, self::$config['plugindisallow']))
		{
			return false;
		}

		return true;

	}

	public static function setThemeStatus($domainName,$inputData=array(),$allow=1)
	{
		$loadData=self::loadDomainConfig();

		if(!$loadData)
		{
			return false;
		}

		if(is_array($inputData))
		{
			$total=count($inputData);

			$keyList=array_keys($inputData);

			if(!is_array($loadData['themeallow']))
			{
				$loadData['themeallow']=array();
			}

			if(!is_array($loadData['themedisallow']))
			{
				$loadData['themedisallow']=array();
			}

			for ($i=0; $i < $total; $i++) { 
				$theKey=$keyList[$i];

				if(!in_array($theKey, $loadData['themeallow']))
				{
					if((int)$allow==1)
					$loadData['themeallow'][]=$theKey;
				}
				else
				{
					if((int)$allow==0)
					{
						$pos=array_search($theKey, $loadData['themeallow']);

						unset($loadData['themeallow'][$pos]);
					}

				}

				if(in_array($theKey, $loadData['themedisallow']))
				{
					if((int)$allow==1)
					{
						$pos=array_search($theKey, $loadData['themedisallow']);

						unset($loadData['themedisallow'][$pos]);
					}

				}
				else
				{
					if((int)$allow==0)
					{
						$loadData['themedisallow'][]=$theKey;
					}
				}

			}

			sort($loadData['themeallow']);

			sort($loadData['themedisallow']);

			if(self::isOtherDomain())
			{
				self::$config=$loadData;
			}

			self::saveDomainConfig($domainName,$loadData);
		}
	}

	public static function setPluginStatus($domainName,$inputData=array(),$allow=1)
	{
		$loadData=self::loadDomainConfig();

		if(!$loadData)
		{
			return false;
		}

		if(is_array($inputData))
		{
			$total=count($inputData);

			$keyList=array_keys($inputData);

			if(!is_array($loadData['pluginallow']))
			{
				$loadData['pluginallow']=array();
			}

			if(!is_array($loadData['plugindisallow']))
			{
				$loadData['plugindisallow']=array();
			}

			for ($i=0; $i < $total; $i++) { 
				$theKey=$keyList[$i];

				if(!in_array($theKey, $loadData['pluginallow']))
				{
					if((int)$allow==1)
					$loadData['pluginallow'][]=$theKey;
				}
				else
				{
					if((int)$allow==0)
					{
						$pos=array_search($theKey, $loadData['pluginallow']);

						unset($loadData['pluginallow'][$pos]);
					}

				}

				if(in_array($theKey, $loadData['plugindisallow']))
				{
					if((int)$allow==1)
					{
						$pos=array_search($theKey, $loadData['plugindisallow']);

						unset($loadData['plugindisallow'][$pos]);
					}

				}
				else
				{
					if((int)$allow==0)
					{
						$loadData['plugindisallow'][]=$theKey;
					}
				}

			}

			sort($loadData['pluginallow']);

			sort($loadData['plugindisallow']);

			if(self::isOtherDomain())
			{
				self::$config=$loadData;
			}

			self::saveDomainConfig($domainName,$loadData);
		}
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
			return false;
		}

		if(isset($loadData['date_expires']))
		{
			$thistime=time();

			$date_expires=strtotime($loadData['date_expires']);

			if((int)$thistime > $date_expires)
			{
				Alert::make('Your domain have been expired!');
			}
		}

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
		}

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

		if(!isset($_COOKIE['root_url']))
		{
			header("Location: http://".self::$config['domain'].$_SERVER['REQUEST_URI']);
		}

	}

}

?>