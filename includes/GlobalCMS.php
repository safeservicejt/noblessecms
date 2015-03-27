<?php

class GlobalCMS
{
	public static $load=array();

	public static $setting=array();

	public static $theme=array();

	public static $content_top=array();

	public static $content_left=array();

	public static $content_right=array();

	public static $content_bottom=array();

	public static $variable=array();

	public static $layouts=array();

	public static $usergroups=array();

	public function start()
	{
		self::$load['start_time']=$_SESSION['start_time'];

		self::$setting=Server::getSetting();

		// self::$load['currency']=

		self::defaultPage();
				
		Lang::loadLang(self::$setting['system_lang']);

		self::$setting['currency']=isset($_SESSION['currency'])?$_SESSION['currency']:self::$setting['currency'];

		// print_r(self::$setting['currency']);die();

		Currency::loadCache(self::$setting['currency']);

		self::$load['currency']=self::$setting['currency'];

		// print_r(self::$setting['currency']);die();

		// Check if is send from affiliate url
		Affiliate::loadCache();

		self::loadLayout();

		Plugins::loadZoneCaches();

		Plugins::load('global_function');

		UserGroups::loadCaches();

	}

	public function defaultPage()
	{
		if(isset($_SESSION['default_page']))
		{
			return false;
		}

		if(self::$setting['default_page']!='home')
		{
			$id=self::$setting['default_page_id'];

			switch (self::$setting['default_page']) {

				case 'custompost':

					$getData=Post::get(array(
						'where'=>"where postid='$id'"
						));

					if(!isset($getData[0]['postid']))
					{
						Redirect::to('404page');
					}

					$_SESSION['default_page']='yes';

					Redirect::to(Url::post($getData[0]));

					break;

				case 'custompage':

					$getData=Page::get(array(
						'where'=>"where pageid='$id'"
						));

					if(!isset($getData[0]['pageid']))
					{
						Redirect::to('404page');
					}
					
					$_SESSION['default_page']='yes';

					Redirect::to(Url::page($getData[0]));

					break;
				
			}
		}
	}


	public function startCP()
	{

		Plugins::loadadminZoneCaches();
	}
	public function startUserCP()
	{

		Plugins::loadusercpZoneCaches();
	}

	public function mainStatus()
	{
		switch (self::$setting['system_status']) {
			case 'underconstruction':
				Alert::make('System Under Construction...');
				break;
				case 'comingsoon':
				Alert::make('We will coming soon...');
				break;
			
		}
	}

	public function loadLayout()
	{
		if(!$loadData=Cache::loadKey('listLayouts',-1))
		{
			return false;
		}

		self::$layouts=json_decode($loadData,true);
	}

	public function enable($keyName)
	{
		switch ($keyName) {
			case 'ecommerce':
				$keyName='enable_ecommerce';
				break;
			case 'comment':
				$keyName='enable_comment';
				break;
			

		}

		$resultData=true;

		switch ($keyName) {
			case 'enable_ecommerce':
				if(!isset(self::$setting['enable_ecommerce']))
				{
					$resultData=false;
				}
				if((int)self::$setting['enable_ecommerce']==1)
				{
					$resultData=true;
				}				
				break;
			case 'enable_comment':
				if(!isset(self::$setting['enable_comment']))
				{
					$resultData=false;

					break;
				}
				if((int)self::$setting['enable_comment']==1)
				{
					$resultData=true;
				}				
				break;
		

		}


		return $resultData;
	}



	public function ecommerce()
	{
		if(!isset(self::$setting['enable_ecommerce']))
		{
			return false;
		}

		if((int)self::$setting['enable_ecommerce']==1)
		{
			return true;
		}

		return false;
	}

	
}
?>