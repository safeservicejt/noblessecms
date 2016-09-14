<?php

class System
{
	public static $newUri='';

	public static $changeUri='no';

	public static $setting=array();

	public static $tmpData=array();

	public static $themeConfig=array();

	public static $adminTitle='Cpanel Noblesse CMS';

	public static $listVar=array('global'=>array());

	public static $listObject=array();

	public static $db=array();

	public static function before_system_start()
	{
        global $db;

		/*

		Load all setting, site info, site status

		*/

		self::$db=$db;

		// Load plugins before system start
		// Plugins::load('before_system_start');

		// Check redirect
		Redirects::checkRedirect();

		// Load system setting
		self::loadSetting();

		// Check system status
		self::systemStatus();

		// Check change theme
		self::checkTheme();

		// Connect to database
		if(!isset(self::$setting['database_off']))
		{
			Database::connect();
		}

		// Load plugins
		PluginMetas::loadCacheAll();

		// Load plugins before connect to database
		Plugins::load('before_system_start');

		// Load user data
		Users::load();

		// Load dynamic route from plugins

	}

	public static function after_system_start()
	{

	}

	public static function defineVar($keyName,$keyVal,$layout='global')
	{
		self::$listVar[$layout][$keyName]=$keyVal;
	}

	public static function define($keyName,$keyVal,$layout='global')
	{
		self::defineVar($keyName,$keyVal,$layout);
	}

	public static function pushVar($keyName,$keyVal,$layout='global')
	{
		self::$listVar[$layout][$keyName][]=$keyVal;
	}

	public static function issetVar($keyName,$zoneName='global')
	{
		if(!isset(self::$listVar[$zoneName][$keyName]))
		{
			return false;
		}

		return true;		
	}

	public static function getVar($keyName,$layout='global',$implode=false)
	{
		$result='';

		if(isset(self::$listVar[$layout][$keyName]))
		{
			$result=self::$listVar[$layout][$keyName];
		}

		if($implode!=false && is_array($result))
		{
			$result=implode("\r\n", $result);
		}

		return $result;
	}

	public static function isMobile()
	{
		$detect = new Mobile_Detect;

		$deviceType = $detect->isMobile()?true:false;

		return $deviceType;
	}

	public static function deviceType()
	{
		$detect = new Mobile_Detect;

		$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
		
		return $deviceType;
	}

	public static function deviceVersion()
	{
		$detect = new Mobile_Detect;

		$scriptVersion = $detect->getScriptVersion();

		return $scriptVersion;
	}
	


	public static function systemStatus()
	{
		$status=self::getStatus();

		$uri=self::getUri();

		switch ($status) {
			case 'underconstruction':

				if(!preg_match('/^\/?npanel\/?/i', $uri))
				Alert::make('Website under construction. We will comeback soon...');

				break;

			case 'comingsoon':

				if(!preg_match('/^\/?npanel\/?/i', $uri))			
				Alert::make('We will comming soon...');
			
				break;
			
		}
	}


	public static function setTheme($themeName='',$redirect='no')
	{
		if(!isset($themeName[1]))
		{
			return false;
		}

		$path=THEMES_PATH.$themeName;



		if(is_dir($path))
		{
			// $_COOKIE['theme_name']=$themeName;

			self::$setting['theme_name']=$themeName;

			Cookie::make('theme_name',$themeName,1440*7);

			self::setUri('/');

			if($redirect!='no')
			{
				$siteUrl='http://'.$_SERVER['HTTP_HOST'];
				
				header("Location: ".$siteUrl);

				exit();
			}

		}		
	}
	
	public static function getDB()
	{
		return self::$db;
	}
	
	public static function addDB($inputData=array())
	{
		/*
		System::addDB(array(
			'newdb'=>array(
				    "dbtype" => "mysqli",

				    "dbhost" => "localhost",

				    "dbport" => "3306",

				    "dbuser" => "root",

				    "dbpassword" => "",

				    "dbname" => "2015_project_noblessev2"
				)
			));
		*/

		self::$db=array_merge(self::$db,$inputData);
	}

	public static function checkTheme()
	{
		if($match=Uri::match('^\/?theme\/(\w+)'))
		{
			$curName=$match[1];

			$path=THEMES_PATH.$curName;

			if(is_dir($path))
			{
				// $_COOKIE['theme_name']=$curName;

				self::$setting['theme_name']=$curName;

				Cookie::make('theme_name',$curName,1440*7);

				self::setUri('/');

				if(!isset($_COOKIE['theme_name']))
				{
					$siteUrl='http://'.$_SERVER['HTTP_HOST'];

					header("Location: ".$siteUrl);

					exit();
				}

			}
			else
			{
				Alert::make('This theme not exist on our system.');
			}


		}

	}

	
	public static function defaultPageUri()
	{
		$method=self::$setting['default_page_method'];

		if($method=='url' && (!isset($_GET['load']) || !isset($_GET['load'][1])))
		{
			self::setUri(self::$setting['default_page_url']);
		}
	}

	public static function getUri()
	{
        global $cmsUri;

        if(self::$changeUri=='yes')
        {
        	$cmsUri=self::$newUri;
        }

        return $cmsUri;		
	}



	public static function setUri($uri)
	{
        self::$changeUri='yes';

        self::$newUri=$uri;	
	}
			
	public static function getTimeZone()
	{
		return self::$setting['default_timezone'];
	}

	public static function setTitle($title)
	{
		self::$setting['title']=$title;
	}
	
	public static function setDescriptions($title)
	{
		self::$setting['descriptions']=$title;
	}

	public static function setKeywords($title)
	{
		self::$setting['keywords']=$title;
	}

	public static function getTitle()
	{
		return self::$setting['title'];
	}

	public static function getDescriptions()
	{
		return self::$setting['descriptions'];
	}

	public static function getKeywords()
	{
		return self::$setting['keywords'];
	}

	public static function getStatus()
	{
		return self::$setting['system_status'];
	}

	public static function getLang()
	{
		$sysLang=self::$setting['system_lang'];

		$sysLang=isset($_COOKIE['locale'])?$_COOKIE['locale']:$sysLang;

		return $sysLang;
	}

	public static function getRegisterStatus()
	{
		return self::$setting['register_user_status'];
	}

	public static function getMemberGroupId()
	{
		return self::$setting['default_member_groupid'];
	}

	public static function getMemberBannedGroupId()
	{
		return self::$setting['default_member_banned_groupid'];
	}
	
	public static function getUrl()
	{
		$url=isset($_COOKIE['root_url'])?$_COOKIE['root_url']:ROOT_URL;

		return $url;
	}

	public static function getAdminUrl()
	{
		$url=self::getUrl().'npanel/';

		return $url;
	}
	
	public static function getCurrentUrl()
	{
		$isHttp=isset($_SERVER['HTTPS'])?$_SERVER['HTTPS']:'';

		$beforeUrl=($isHttp=='on')?'https://':'http://';

		$url=$beforeUrl.$_SERVER['HTTP_HOST'].'/'.System::getUri();

		return $url;
	}

	public static function getThemeUrl()
	{
		$url=self::getUrl().'contents/themes/'.self::getThemeName().'/';

		return $url;
	}


	public static function getThemeName()
	{
		$url=isset(self::$setting['theme_name'])?self::$setting['theme_name']:THEME_NAME;

		$url=isset($_COOKIE['theme_name'])?$_COOKIE['theme_name']:$url;

		return $url;
	}

	public static function getThemePath()
	{
		$url=ROOT_PATH.'contents/themes/'.self::getThemeName().'/';

		return $url;
	}	

	public static function makeSetting()
	{
		$settingData=array(
			'system_status'=>'working','system_prefix'=>PREFIX,'system_mode'=>'basic','theme_name'=>'cleanwp','system_version'=>'3.0','system_captcha'=>'disable', 'system_lang'=>'en', 'register_user_status'=>'disable', 'register_verify_email'=>'disable',
			'default_member_groupid'=>'2', 'default_member_banned_groupid'=>'3', 'default_dateformat'=>'M d, Y',
			'rss_status'=>'enable','comment_status'=>'enable', 'title'=>'Noblesse CMS Website', 'keywords'=>'noblessecms, blog, website',
			'descriptions'=>'Noblesse CMS Website Description','default_page_method'=>'none','default_page_url'=>'','default_timezone'=>'US/Arizona',
			'mail'=>array(
				'send_method'=>'local',
				'fromName'=>'Admin','fromEmail'=>'Admin@gmail.com','smtpAddress'=>'smtp.gmail.com',
				'smtpUser'=>'youremail@gmail.com','smtpPass'=>'yourpass','smtpPort'=>'497',
				'registerSubject'=>'Your account information',
				'registerContent'=>'<p>Hi {fullname},</p>'."\r\n".'

				<p>You have been completed account with information:</p>'."\r\n".'

				<p>Email: {email}</p>'."\r\n".'

				<p>Username: {username}</p>'."\r\n".'

				<p>Password: {password}</p>',
				'forgotSubject'=>'Confirm your forgot password action ',
				'forgotContent'=>'<p>Hi {fullname},</p>'."\r\n".'

				<p>You have been request new password and you need confirm your action now. Click to below link to confirm your action:</p>'."\r\n".'

				<p>{verify_url}</p>'."\r\n".'

				Thanks for using our service!',
				'forgotNewPasswordSubject'=>'Your new password',
				'forgotNewPasswordContent'=>'<p>Hi {fullname},</p>'."\r\n".'

				<p>So, you can login with below information:</p>'."\r\n".'

				<p>Website: {siteurl}</p>'."\r\n".'

				<p>Email: {email}</p>'."\r\n".'

				<p>Username: {username}</p>'."\r\n".'

				<p>Password: {password}</p>'."\r\n".'

				<p>Thanks for using our service!</p>',

				'registerConfirmSubject'=>'Verify your account',

				'registerConfirmContent'=>'<p>Hi {fullname},</p>'."\r\n".'
				
				<p>Click or paste below url into address bar for verify your account:</p>'."\r\n".'

				<p>{verify_code}</p>'."\r\n".'

				<p>You have been completed account with information:</p>'."\r\n".'

				<p>Email: {email}</p>'."\r\n".'

				<p>Username: {username}</p>'."\r\n".'

				<p>Password: {password}</p>'."\r\n"
				)
			);	

		self::saveSetting($settingData);

		return $settingData;
	}

	public static function setSetting($keyName='',$defaultVal='')
	{
		if(!is_array(self::$setting) || !isset(self::$setting[$keyName]))
		{
			self::$setting=self::loadSetting();
		}

		self::$setting[$keyName]=$defaultVal;
	}

	public static function getSetting($keyName='',$defaultVal=false)
	{
		$result=$defaultVal;

		if(!isset(self::$setting['system_status']))
		{
			self::$setting=self::loadSetting();
		}

		$result=isset(self::$setting[$keyName])?self::$setting[$keyName]:$defaultVal;

		return $result;
	}

	public static function loadSetting()
	{
		$filePath=ROOT_PATH.'caches/systemSetting.cache';

		$result=false;

		if(!file_exists($filePath))
		{
			$result=self::makeSetting();	

			Usergroups::saveCacheAll();
		}

		$result=unserialize(base64_decode(String::decrypt(file_get_contents($filePath))));

		if(!is_array($result) || !isset($result['system_status']))
		{
			$result=self::makeSetting();	
		}

		self::$setting=$result;

		return $result;
	}

	public static function removeSetting($inputData=array())
	{
		$data=self::getSetting();

		$total=count($inputData);

		for ($i=0; $i < $total; $i++) { 
			$keyName=$inputData[$i];

			unset($data[$keyName]);

		}

		self::saveSetting($data);
		
	}

	public static function saveSetting($inputData=array())
	{
		$filePath=ROOT_PATH.'caches/systemSetting.cache';

		$loadData=array();

		if(file_exists($filePath))
		{
			$loadData=unserialize(base64_decode(String::decrypt(file_get_contents($filePath))));

			if(!is_array($loadData))
			{
				$loadData=array();
			}
		}

		$total=count($inputData);

		$keyList=array_keys($inputData);

		for ($i=0; $i < $total; $i++) { 
			$theKey=$keyList[$i];

			$loadData[$theKey]=$inputData[$theKey];
		}


		File::create($filePath,String::encrypt(base64_encode(serialize($loadData))));
	}

}