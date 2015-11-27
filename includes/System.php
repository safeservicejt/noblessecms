<?php

/*

Hide admincp author on footer: Add System::$setting['admincp_hide_author']='yes';

Change admincp dashboard logo : Add System::$setting['admincp_change_logo']='/uploads/images/newlogo.png';

Change admincp favicon : Add System::$setting['admincp_change_favicon']='/uploads/images/favicon.ico';

Hide admincp navbar: Create folder with path: contents/security/admincp/hide/navbar

Hide admincp left bar menu: Create folder with path: contents/security/admincp/hide/left-all

Redirect uri to url: Create folder with path: contents/redirects/hash_file.cache | This file store url which will redirect to.


*/

class System
{
	public static $newUri='';

	public static $changeUri='no';

	public static $setting=array();

	public static $themeConfig=array();

	public static $adminTitle='Cpanel Noblesse CMS';

	public static $listVar=array('global'=>array());

	public static function define($keyName,$keyVal,$layout='global')
	{
		self::$listVar[$layout][$keyName]=$keyVal;
	}
	
	public static function defineVar($keyName,$keyVal,$layout='global')
	{
		self::$listVar[$layout][$keyName]=$keyVal;
	}

	public static function defineGlobalVar($keyName,$keyVal)
	{
		self::defineVar($keyName,$keyVal);
	}

	public static function getVar($keyName,$zoneName='global')
	{
		if(!isset(self::$listVar[$zoneName][$keyName]))
		{
			return false;
		}

		return self::$listVar[$zoneName][$keyName];
	}

	public static function before_system_start()
	{
		/*
		Load all setting, site info, site status

		if Uri=admincp : Load plugin caches in admincp

		if Uri=usercp : Load plugin caches in usercp

		if Uri='' : Load plugin caches in frontend


		*/
		
		Redirect::detectRedirect();

		self::checkTheme();

		Theme::checkThemeConfig();

		Theme::loadThemeConfig('before_load_database');

		// self::checkCurrency();

		self::checkLang();

		self::$setting=self::getSetting();

		$systemMode=isset(self::$setting['system_mode'])?self::$setting['system_mode']:'basic';

		self::systemStatus();

		self::setTimeZone();

		if(!Domain::isOtherDomain() && isset($_COOKIE['prefixall']))
		{
			Database::resetPrefix();
		}		

		if($systemMode!='basic')
		{
			
			if(Domain::isOtherDomain())
			{
				Domain::checkConfig();

				Domain::checkTheme();

				Users::checkConfig();

				Users::checkUseTheme();
			}

		}

		PluginsZone::loadCache();

		CustomPlugins::loadCache();

		self::defaultPageUri();
		
		Database::connect();
		
		if($systemMode!='basic')
		{
			if(Domain::isOtherDomain())
			{
				Domain::checkConnectDB();
				
				Users::checkConnectDB();				
			}

		}

		Plugins::load('before_system_start');

		Shortcode::loadInSystem();

		Route::loadFromPlugin();

		self::visitorStatus();

		self::userStatus();

		Theme::loadThemeConfig('after_load_database');
		
	}

	public static function setTimeZone()
	{
		$zone=self::$setting['default_timezone'];

		date_default_timezone_set($zone);
	}

	public static function checkLang()
	{
		if($match=Uri::match('^\/?lang\/(\w+)'))
		{
			$curName=$match[1];
			Lang::set($curName);

			$siteUrl='http://'.$_SERVER['HTTP_HOST'];


			header("Location: ".$siteUrl);

			exit();

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
	
	public static function checkTheme()
	{
		if($match=Uri::match('^\/?theme\/(\w+)'))
		{
			$curName=$match[1];

			$path=THEMES_PATH.$curName;

			if(is_dir($path))
			{
				// $_COOKIE['theme_name']=$curName;

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

		switch ($status) {
			case 'underconstruction':

				$uri=self::getUri();

				if(!preg_match('/^\/?admincp\/?/i', $uri))
				Alert::make('Website under construction. We will comeback soon...');

				break;

			case 'comingsoon':

				$uri=self::getUri();

				if(!preg_match('/^\/?admincp\/?/i', $uri))			
				Alert::make('We will comming soon...');
			
				break;
			
		}
	}

	public static function userStatus()
	{
		if(isset($_COOKIE['groupid']))
		{

			UserGroups::loadGroup(Users::getCookieUserId());
		}
		
	}
	
	public static function visitorStatus()
	{

	}
	public static function defaultPageUri()
	{
		$method=self::$setting['default_page_method'];

		if($method=='url' && (!isset($_GET['load']) || !isset($_GET['load'][1])))
		{
			self::setUri(self::$setting['default_page_url']);
		}
	}

	public static function after_system_start()
	{

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

	public static function getDateFormat()
	{
		return self::$setting['default_dateformat'];
	}

	public static function getCommentStatus()
	{
		return self::$setting['comment_status'];
	}

	public static function getRssStatus()
	{
		return self::$setting['rss_status'];
	}

	public static function getAdminUrl()
	{
		$result=self::getUrl().'admincp/';

		return $result;
	}
	
	public static function getUrl()
	{
		$url=isset($_COOKIE['root_url'])?$_COOKIE['root_url']:ROOT_URL;

		return $url;
	}

	public static function getHost()
	{
		$theDomain=$_SERVER['HTTP_HOST'];

		return $theDomain;
	}

	public static function setUrl($url)
	{
		Cookie::make('root_url',$url,1440*7);
	}

	public static function getThemeUrl()
	{
		$url=self::getUrl().'contents/themes/'.self::getThemeName().'/';

		return $url;
	}

	public static function getThemeName()
	{
		$url=isset($_COOKIE['theme_name'])?$_COOKIE['theme_name']:THEME_NAME;


		return $url;
	}

	public static function getThemePath()
	{
		$url=ROOT_PATH.'contents/themes/'.self::getThemeName().'/';

		return $url;
	}

	public static function getCurrentPage()
	{
		$pageName=self::getUri();

		if(preg_match('/^\/(\w+)/i', $pageName,$match))
		{
			$pageName=$match[1];
		}

		if($pageName=='/')
		{
			$pageName='';
		}

		return $pageName;
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

	public static function getMailSetting($keyName='')
	{
		$data=self::$setting;

		if(!isset($keyName[2]))
		{
			return $data['mail'];
		}

		if(!isset($data['mail'][$keyName]))
		{
			return false;
		}

		return $data['mail'][$keyName];
	}

	public static function getSetting($keyName='',$keyValue='')
	{	

		$data=array();

		if(!isset(self::$setting['register_user_status']))
		{
			$prefix=Database::getPrefix();

			$fileName=ROOT_PATH.'application/caches/systemSetting'.$prefix.'.cache';

			if(!file_exists($fileName))
			{
				$data=self::makeSetting();

			}
			else
			{
				$data=unserialize(base64_decode(String::decrypt(file_get_contents($fileName))));

			}


			self::$setting=$data;
		}
		else
		{
			$data=self::$setting;
		}

		if(!isset($keyName[1]))
		{
			return $data;
		}
		else
		{
			$keyValue=false;

			$keyValue=isset($data[$keyName])?$data[$keyName]:$keyValue;

			return $keyValue;

		}



	}
	
	public static function setSetting($keyName='',$keyValue='')
	{	

		$data=array();

		if(!isset(self::$setting['register_user_status']))
		{
			return false;
		}
		else
		{
			$data=self::$setting;

			if(!isset($keyName[1]))
			{
				return false;
			}

			$data[$keyName]=$keyValue;			
		}


	}

	public static function makeSetting()
	{
		$settingData=array(
			'system_status'=>'working','system_mode'=>'basic', 'system_lang'=>'en', 'register_user_status'=>'enable',
			'default_member_groupid'=>'1', 'default_member_banned_groupid'=>'2', 'default_dateformat'=>'M d, Y',
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

				<p>Thanks for using our service!</p>'

				)
			);	

		self::saveSettingData($settingData);

		return $settingData;
	}

	public static function saveSetting($inputData=array())
	{
		$data=self::getSetting();

		$keyNames=array_keys($inputData);

		$total=count($inputData);

		for ($i=0; $i < $total; $i++) { 
			$keyName=$keyNames[$i];

			$data[$keyName]=$inputData[$keyName];
			
			self::$setting[$keyName]=$inputData[$keyName];

		}
		
		self::saveSettingData($data);

	}

	public static function removeSetting($inputData=array())
	{
		$data=self::getSetting();

		$total=count($inputData);

		for ($i=0; $i < $total; $i++) { 
			$keyName=$inputData[$i];

			unset($data[$keyName]);

		}

		self::saveSettingData($data);
		
	}

	public static function saveSettingData($inputData=array())
	{
		$prefix=Database::getPrefix();

		$fileName='systemSetting'.$prefix.'.cache';

		File::create(ROOT_PATH.'application/caches/'.$fileName,String::encrypt(base64_encode(serialize($inputData))));

	}

	

	public static function saveMailSetting($inputData=array())
	{
		$prefix=Database::getPrefix();

		$data=self::getSetting();

		$keyNames=array_keys($inputData);

		$total=count($inputData);

		for ($i=0; $i < $total; $i++) { 
			$keyName=$keyNames[$i];

			$data['mail'][$keyName]=$inputData[$keyName];

		}

		self::$setting['mail']=$data['mail'];
		
		// Cache::saveKey('systemSetting',serialize($data));
		File::create(ROOT_PATH.'application/caches/systemSetting'.$prefix.'.cache',String::encrypt(base64_encode(serialize($data))));

	}

	public static function makeFileManagePath($str)
	{
		Cookie::make('add_path',$str,1440*7);
	}

	public static function dateTime($str='',$thisTime=0)
	{
		$str=isset($str[1])?$str:'Y-m-d H:i:s';

		if((int)$thisTime > 0)
		{
			$result=date($str,$thisTime);
		}
		else
		{
			$result=date($str);
		}

		return $result;
	}



}

?>