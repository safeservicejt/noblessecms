<?php

class controlSetting
{
	public static function index()
	{

		$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_setting_system');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}		
		
		$pageData=array('alert'=>'');

		if(Request::has('btnSave'))
		{
			$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_setting_system');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}			

			$saveData=Request::get('general');

			System::saveSetting($saveData);

			$enable_sitemap=isset($saveData['enable_sitemap'])?$saveData['enable_sitemap']:'no';

			Render::makeSiteMap();	
		}

		if(Request::has('btnRefreshSiteMap'))
		{
			Render::makeSiteMap();
		}


		$pageData=System::loadSetting();

		$pageData['usergroups']=Usergroups::get(array(
			'cache'=>'no',
			'orderby'=>'order by title asc'
			));

		// print_r($pageData['usergroups']);die();

		System::setTitle('Setting System - nPanel');
	
		Views::make('head');

		Views::make('left');

		Views::make('settingGeneral',$pageData);

		Views::make('footer');		
	}	

	public function mailsystem()
	{
		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_setting_mail');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}

		$pageData=array('alert'=>'');

		$pageData=System::getSetting();

		if(Request::has('btnSave'))
		{
			$saveData=Request::get('mail');

			System::$setting['mail']=$saveData;

			System::saveSetting(System::$setting);

			

		}

		$pageData=System::loadSetting();

		System::setTitle('Mail Setting - nPanel');
	
		Views::make('head');

		Views::make('left');

		Views::make('settingMail',$pageData);

		Views::make('footer');		
	}

}