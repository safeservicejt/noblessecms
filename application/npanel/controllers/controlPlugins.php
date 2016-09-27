<?php

class controlPlugins
{
	public static function index()
	{

		$pageData=array('alert'=>'');
		
		$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_manage_plugins');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}		
		$pageData=array('alert'=>'');


		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$pageData['theList']=Plugins::getDirs();

		System::setTitle('Plugins list - nPanel');

		Views::make('head');

		Views::make('left');

		Views::make('pluginList',$pageData);

		Views::make('footer');		
	}	



	public static function activate()
	{
		if(!$match=Uri::match('\/activate\/(\w+)'))
		{
			Redirects::to(System::getUrl().'npanel/plugins/');
		}

		$foldername=$match[1];

		// $pluginPath=ROOT_PATH.'contents/plugins/'.$foldername.'/';

		Plugins::activate($foldername);

		Redirects::to(System::getUrl().'npanel/plugins/');
	}

	public static function deactivate()
	{
		if(!$match=Uri::match('\/deactivate\/(\w+)'))
		{
			Redirects::to(System::getUrl().'npanel/plugins/');
		}

		$foldername=$match[1];

		// $pluginPath=ROOT_PATH.'contents/plugins/'.$foldername.'/';

		Plugins::deactivate($foldername);

		Redirects::to(System::getUrl().'npanel/plugins/');
	}

	public static function install()
	{
		if(!$match=Uri::match('\/install\/(\w+)'))
		{
			Redirects::to(System::getUrl().'npanel/plugins/');
		}

		$foldername=$match[1];

		// $pluginPath=ROOT_PATH.'contents/plugins/'.$foldername.'/';

		Plugins::install($foldername);

		Redirects::to(System::getUrl().'npanel/plugins/');
	}

	public static function uninstall()
	{
		if(!$match=Uri::match('\/uninstall\/(\w+)'))
		{
			Redirects::to(System::getUrl().'npanel/plugins/');
		}

		$foldername=$match[1];

		// $pluginPath=ROOT_PATH.'contents/plugins/'.$foldername.'/';

		Plugins::uninstall($foldername);

		Redirects::to(System::getUrl().'npanel/plugins/');
	}

	public static function edit()
	{
		$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_edit_page');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}	
			
		
		if(!$match=Uri::match('\/edit\/(\d+)'))
		{
			Redirects::to(System::getAdminUrl().'pages/');
		}


		$id=$match[1];

		$pageData=array('alert'=>'');

		if(Request::has('btnSave'))
		{
			$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_edit_page');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}

			try {
				
				updateProcess($id);

				$pageData['alert']='<div class="alert alert-success">Save changes success.</div>';

			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}

		$loadData=Pages::get(array(
			'where'=>"where id='$id'",
			'isHook'=>'no',
			'cache'=>'no'
			));

		$pageData['edit']=$loadData[0];

		System::setTitle('Edit page - nPanel');

		Views::make('head');

		Views::make('left');

		Views::make('pagesEdit',$pageData);

		Views::make('footer');		
	}

	public static function controller()
	{
		$controlName='home';

		if(!$match=Uri::match('plugins\/controller\/(\w+)'))
		{
			Redirects::to(System::getUrl().'npanel');
		}

		$foldername=$match[1];

		if($match=Uri::match('plugins\/controller\/(\w+)\/(\w+)'))
		{
			$controlName=$match[2];
		}	

		$funcName='index';

		if($match=Uri::match('plugins\/controller\/(\w+)\/(\w+)\/(\w+)'))
		{
			$funcName=$match[3];
		}		

		Controllers::load(ucfirst($controlName),$funcName,'contents/plugins/'.$foldername);

	}

	public function import()
	{

		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_import_plugin');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}

		$pageData=array('alert'=>'');

		if(Request::has('btnSend'))
		{
			try {
				
				importProcess();

				$pageData['alert']='<div class="alert alert-success">Import plugins success.</div>';

			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}		
		}

		System::setTitle('Import plugin - nPanel');

		Views::make('head');

		Views::make('left');

		Views::make('pluginImport',$pageData);

		Views::make('footer');		
	}
	
	public static function addnew()
	{

		$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_addnew_page');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}


		$pageData=array('alert'=>'');

		if(Request::has('btnAdd'))
		{
			$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_addnew_page');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}

			try {
				
				insertProcess();

				$pageData['alert']='<div class="alert alert-success">Add new page success.</div>';

			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}
		
		System::setTitle('Add new page - nPanel');

		Views::make('head');

		Views::make('left');

		Views::make('pagesAdd',$pageData);

		Views::make('footer');		
	}

}