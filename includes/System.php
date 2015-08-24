<?php

class System
{
	public static $newUri='';

	public static $changeUri='no';

	public static $setting=array();

	public static $adminTitle='Cpanel Noblesse CMS';

	public static $listVar=array('global'=>array());

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

		self::checkTheme();

		self::checkCurrency();

		self::checkLang();

		self::$setting=self::getSetting();

		self::setTimeZone();

		PluginsZone::loadCache();
		// self::systemStatus();

		self::defaultPageUri();

		Database::connect();

		self::visitorStatus();

		self::userStatus();
		
	}

	public static function setTimeZone()
	{
		$zone=self::$setting['default_timezone'];

		date_default_timezone_set($zone);
	}

	public static function checkLang()
	{
		if($match=Uri::match('^lang\/(\w+)'))
		{
			$curName=$match[1];
			Lang::set($curName);

			header("Location: ".self::getUrl());

			exit();

		}

	}
	
	public static function checkTheme()
	{
		if($match=Uri::match('^theme\/(\w+)'))
		{
			$curName=$match[1];

			$path=THEMES_PATH.$curName;

			if(is_dir($path))
			{
				// $_COOKIE['theme_name']=$curName;

				Cookie::make('theme_name',$curName,1440*7);

				self::setUri('/');

				// header("Location: ".self::getUrl());

				// exit();

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
	
	public static function checkCurrency()
	{
		if($match=Uri::match('^currency\/(\w+)'))
		{
			$curName=$match[1];
			Currency::set($curName);

			header("Location: ".self::getUrl());

			exit();

		}

	}

	public static function systemStatus()
	{
		$status=self::getStatus();

		switch ($status) {
			case 'underconstruction':
				Alert::make('Website under construction. We will comeback soon...');
				break;
			case 'comingsoon':
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
	
	public static function getAffiliateCommission()
	{
		return self::$setting['default_affiliate_commission'];
	}

	public static function getVatPercent()
	{
		return self::$setting['default_vat_commission'];
	}

	public static function getOrderStatus()
	{
		return self::$setting['default_order_status'];
	}

	public static function getCurrency()
	{
		$current=self::$setting['currency'];

		$data=isset($_COOKIE['currency'])?$_COOKIE['currency']:$current;
		
		return $data;
	}

	public static function getUrl()
	{
		$url=isset($_COOKIE['root_url'])?$_COOKIE['root_url']:ROOT_URL;

		return $url;
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
			if(!$data=Cache::loadKey('systemSetting',-1))
			{
				$data=self::makeSetting();
			}
			else
			{
				$data=unserialize($data);
			}
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
			'system_status'=>'working', 'system_lang'=>'en', 'register_user_status'=>'enable',
			'default_member_groupid'=>'1', 'default_member_banned_groupid'=>'2', 'default_dateformat'=>'M d, Y',
			'rss_status'=>'enable','comment_status'=>'enable', 'title'=>'Noblesse CMS Website', 'keywords'=>'noblessecms, blog, website',
			'descriptions'=>'Noblesse CMS Website Description','default_page_method'=>'none','default_page_url'=>'',
			'mail'=>array(
				'send_method'=>'local',
				'fromName'=>'Admin','fromEmail'=>'Admin@gmail.com','smtpAddress'=>'smtp.gmail.com',
				'smtpUser'=>'youremail@gmail.com','smtpPass'=>'yourpass','smtpPort'=>'497',
				'registerSubject'=>'Signup completed - NoblesseCMS','registerContent'=>'Content here','forgotSubject'=>'Subject here',
				'forgotContent'=>'Content here'
				),
			'default_affiliate_commission'=>'50','default_vat_commission'=>'10','default_order_status'=>'pending','default_currency'=>'usd','default_min_withdraw'=>'10'
			);	

		Cache::saveKey('systemSetting',serialize($settingData));

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

		}
		
		Cache::saveKey('systemSetting',serialize($data));
	}

	

	public static function saveMailSetting($inputData=array())
	{
		$data=self::getSetting();

		$keyNames=array_keys($inputData);

		$total=count($inputData);

		for ($i=0; $i < $total; $i++) { 
			$keyName=$keyNames[$i];

			$data['mail'][$keyName]=$inputData[$keyName];

		}
		
		Cache::saveKey('systemSetting',serialize($data));
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