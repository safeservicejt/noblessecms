<?php

class controlSetting
{
	public function index()
	{
		CustomPlugins::load('admincp_before_manage_setting');

		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_setting_system');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}		
		
		$post=array('alert'=>'');

		// Model::load('admincp/setting');

		if($match=Uri::match('\/setting\/(\w+)'))
		{
			if(method_exists("controlSetting", $match[1]))
			{	
				$method=$match[1];

				$this->$method();

				die();
			}
			
		}

		if(Request::has('btnSave'))
		{
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_setting_system');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}			

			$saveData=Request::get('general');


			System::saveSetting($saveData);
		}


		$post=System::getSetting();

		if($post==false || !isset($post['default_adminpage_method']))
		{
			System::makeSetting();

			$post=System::getSetting();
		}

		// $post['title']=base64_decode($post['title']);

		// print_r($post);die();

		$post['usergroups']=UserGroups::get();
		
		System::setTitle('Setting System - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('settingGeneral',$post);

		View::make('admincp/footer');

	}

	public function clearcache()
	{
		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_clear_cache');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}

		$listDir=Dir::listDir(CACHES_PATH);

		$total=count($listDir);

		for ($i=0; $i < $total; $i++) { 
			Dir::remove(CACHES_PATH.$listDir[$i]);
		}

		View::make('admincp/head');
		
		self::makeContents('clearCacheView',array());

		View::make('admincp/footer');
	
	}

	public function update()
	{
		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_update_system');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}

		$post=array('alert'=>'','alertManual'=>'');

		if(Request::has('btnStart'))
		{
			// System::saveMailSetting(Request::get('mail'));
			Update::make();
			
			$post['alert']='<div class="alert alert-success">Update system success.</div>';
		}

		if(Request::has('btnUpload'))
		{
			// System::saveMailSetting(Request::get('mail'));
			Update::fromUpload();
			
			$post['alertManual']='<div class="alert alert-success">Update system success.</div>';
		}


		$post['data']=Update::get();

		// print_r($post);die();

		View::make('admincp/head',array('title'=>'Update System - '.ADMINCP_TITLE));

		self::makeContents('updateVersion',$post);

		View::make('admincp/footer');		
	}
	public function mailsystem()
	{
		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_setting_mail');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}

		$post=array('alert'=>'');

		$post=System::getSetting();

		if(Request::has('btnSave'))
		{
			$saveData=Request::get('mail');

			System::saveMailSetting($saveData);

			$post=System::getSetting();

		}


		View::make('admincp/head',array('title'=>'Mail Setting - '.ADMINCP_TITLE));

		self::makeContents('settingMail',$post);

		View::make('admincp/footer');		
	}


    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}
