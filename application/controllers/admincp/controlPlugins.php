<?php

class controlPlugins
{
	public function index()
	{
      	// if(Domain::isOtherDomain())
      	// {
      	// 	Alert::make('You dont have permission to access this page.');
      	// }
      	
		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_manage_plugins');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}		


		$post=array('alert'=>'');

		Model::load('admincp/plugins');

		if($match=Uri::match('\/plugins\/(\w+)'))
		{
			if(method_exists("controlPlugins", $match[1]))
			{	
				$method=$match[1];

				$this->$method();

				die();
			}
			
		}



		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['theList']=Plugins::getDirs();


		View::make('admincp/head',array('title'=>'Plugin list - '.ADMINCP_TITLE));

		self::makeContents('pluginList',$post);

		View::make('admincp/footer');

	}

	public function install()
	{

		if(!$match=Uri::match('\/install\/(\w+)'))
		{
			Redirect::to(System::getAdminUrl());
		}

		$foldername=$match[1];

      	if(Domain::isOtherDomain() && !Domain::isAllowPlugin($foldername))
      	{
      		Alert::make('You dont have permission to access this page.');
      	}

		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_install_plugin');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}

		define("PLUGIN_PATH", PLUGINS_PATH.$foldername.'/');

		define("PLUGIN_VIEW_PATH", PLUGIN_PATH.'views/');
		define("PLUGIN_CONTROLLER_PATH", PLUGIN_PATH.'controller/');
		define("PLUGIN_MODEL_PATH", PLUGIN_PATH.'model/');

		Plugins::makeInstall($foldername);

		$path=PLUGINS_PATH.$foldername.'/index.php';

		if(file_exists($path))
		{
			require($path);
		}

		Redirect::to(System::getAdminUrl().'plugins');


	}

	public function controller()
	{
		
      	// if(Domain::isOtherDomain())
      	// {
      	// 	Alert::make('You dont have permission to access this page.');
      	// }

		if(!$match=Uri::match('\/controller\/(\w+)\/(\w+)'))
		{
			Redirect::to(System::getAdminUrl());
		}


		$foldername=$match[1];

      	if(Domain::isOtherDomain() && !Domain::isAllowPlugin($foldername))
      	{
      		Alert::make('You dont have permission to access this page.');
      	}

		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_control_plugin');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}

		$funcName=$match[2];

		$path=PLUGINS_PATH.$foldername.'/controller/control'.ucfirst($funcName).'.php';

		$thisUrl=System::getAdminUrl().'plugins/controller/'.$foldername.'/'.$funcName.'/';

		if(!file_exists($path))
		{
			Redirect::to(System::getAdminUrl());
		}

		define("THIS_URL",$thisUrl);

		define("THIS_PATH",PLUGINS_PATH.$foldername.'/');

		define("PLUGIN_PATH", PLUGINS_PATH.$foldername.'/');

		define("PLUGIN_VIEW_PATH", PLUGIN_PATH.'views/');
		define("PLUGIN_CONTROLLER_PATH", PLUGIN_PATH.'controller/');
		define("PLUGIN_MODEL_PATH", PLUGIN_PATH.'model/');
		
		$post['title']=ucfirst($foldername);

		$post['filePath']=$path;

		$post['controller']='control'.ucfirst($funcName);
		
		System::setTitle(ucfirst($foldername).' - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('pluginRunController',$post);

		View::make('admincp/footer');	
	}

	public function run()
	{
		if(!$match=Uri::match('\/run\/(\w+)'))
		{
			Redirect::to(System::getAdminUrl());
		}



		$funcName=base64_decode($match[1]);

		$parse=explode(':', $funcName);

		$foldername=$parse[0];

		$funcName=$parse[1];

		$path=PLUGINS_PATH.$foldername.'/index.php';

		if(!file_exists($path))
		{
			Redirect::to(System::getAdminUrl());
		}

      	if(Domain::isOtherDomain() && !Domain::isAllowPlugin($foldername))
      	{
      		Alert::make('You dont have permission to access this page.');
      	}

		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_run_plugin');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}

		define("THIS_URL",PLUGINS_URL.$foldername.'/');

		define("PLUGIN_PATH", PLUGINS_PATH.$foldername.'/');

		define("PLUGIN_VIEW_PATH", PLUGIN_PATH.'views/');
		define("PLUGIN_CONTROLLER_PATH", PLUGIN_PATH.'controller/');
		define("PLUGIN_MODEL_PATH", PLUGIN_PATH.'model/');
		
		$post['title']=ucfirst($foldername);

		$post['filePath']=$path;

		$post['func']=$funcName;
		
		System::setTitle(ucfirst($foldername).' - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('pluginRunFunc',$post);

		View::make('admincp/footer');	
	}

	public function setting()
	{
      	// if(Domain::isOtherDomain())
      	// {
      	// 	Alert::make('You dont have permission to access this page.');
      	// }

		if(!$match=Uri::match('\/setting\/(\w+)'))
		{
			Redirect::to(System::getAdminUrl());
		}

		$foldername=$match[1];

		$path=PLUGINS_PATH.$foldername.'/setting.php';

		if(!file_exists($path))
		{
			Redirect::to(System::getAdminUrl().'plugins');
		}

      	if(Domain::isOtherDomain() && !Domain::isAllowPlugin($foldername))
      	{
      		Alert::make('You dont have permission to access this page.');
      	}

		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_setting_plugin');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}

		define("PLUGIN_PATH", PLUGINS_PATH.$foldername.'/');

		define("PLUGIN_VIEW_PATH", PLUGIN_PATH.'views/');
		define("PLUGIN_CONTROLLER_PATH", PLUGIN_PATH.'controller/');
		define("PLUGIN_MODEL_PATH", PLUGIN_PATH.'model/');

		$post['title']=ucfirst($foldername);

		$post['filePath']=$path;

		View::make('admincp/head',array('title'=>'Setting plugin - '.ADMINCP_TITLE));

		self::makeContents('pluginSetting',$post);

		View::make('admincp/footer');	
	}

	public function uninstall()
	{
      	// if(Domain::isOtherDomain())
      	// {
      	// 	Alert::make('You dont have permission to access this page.');
      	// }

		if(!$match=Uri::match('\/uninstall\/(\w+)'))
		{
			Redirect::to(System::getAdminUrl());
		}

		$foldername=$match[1];


		$path=PLUGINS_PATH.$foldername.'/index.php';

      	if(!Domain::isAllowPlugin($foldername))
      	{
      		Alert::make('You dont have permission to access this page.');
      	}

		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_uninstall_plugin');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}

		define("PLUGIN_PATH", PLUGINS_PATH.$foldername.'/');

		define("PLUGIN_VIEW_PATH", PLUGIN_PATH.'views/');
		define("PLUGIN_CONTROLLER_PATH", PLUGIN_PATH.'controller/');
		define("PLUGIN_MODEL_PATH", PLUGIN_PATH.'model/');

		$loadData=Plugins::get(array(
			'cache'=>'no',
			'where'=>"where foldername='$foldername'"
			));

		if((int)$loadData[0]['status']==1)
		{
			Database::query("update ".Database::getPrefix()."plugins set status='0' where foldername='$foldername'");
			Database::query("update ".Database::getPrefix()."plugins_meta set status='0' where foldername='$foldername'");

			PluginsZone::saveCache();

			Redirect::to(System::getAdminUrl().'plugins');
			
		}

		// Database::query("update ".Database::getPrefix()."plugins set status='0' where foldername='$foldername'");
		// Database::query("update ".Database::getPrefix()."plugins_meta set status='0' where foldername='$foldername'");

		// PluginsZone::saveCache();


		Plugins::makeUninstall($foldername);

		PluginsZone::saveCache();
		
		if(file_exists($path))
		{
			require($path);			
		}

		Redirect::to(System::getAdminUrl().'plugins');

	}
	public function activate()
	{
      	// if(Domain::isOtherDomain())
      	// {
      	// 	Alert::make('You dont have permission to access this page.');
      	// }

		if(!$match=Uri::match('\/activate\/(\w+)'))
		{
			Redirect::to(System::getAdminUrl());
		}

		$foldername=$match[1];

      	if(Domain::isOtherDomain() && !Domain::isAllowPlugin($foldername))
      	{
      		Alert::make('You dont have permission to access this page.');
      	}

		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_activate_plugin');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}

		define("PLUGIN_PATH", PLUGINS_PATH.$foldername.'/');

		define("PLUGIN_VIEW_PATH", PLUGIN_PATH.'views/');
		define("PLUGIN_CONTROLLER_PATH", PLUGIN_PATH.'controller/');
		define("PLUGIN_MODEL_PATH", PLUGIN_PATH.'model/');

		Database::query("update ".Database::getPrefix()."plugins set status='1' where foldername='$foldername'");
		Database::query("update ".Database::getPrefix()."plugins_meta set status='1' where foldername='$foldername'");

		PluginsZone::saveCache();

		if(file_exists(ROOT_PATH.'contents/plugins/'.$foldername.'/install/update.php'))
		{
			include(ROOT_PATH.'contents/plugins/'.$foldername.'/install/update.php');
		}
		
		Redirect::to(System::getAdminUrl().'plugins');
	}
	public function deactivate()
	{
      	// if(Domain::isOtherDomain())
      	// {
      	// 	Alert::make('You dont have permission to access this page.');
      	// }

		if(!$match=Uri::match('\/deactivate\/(\w+)'))
		{
			Redirect::to(System::getAdminUrl());
		}

		$foldername=$match[1];
		
      	if(Domain::isOtherDomain() && !Domain::isAllowPlugin($foldername))
      	{
      		Alert::make('You dont have permission to access this page.');
      	}

		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_deactivate_plugin');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}

		define("PLUGIN_PATH", PLUGINS_PATH.$foldername.'/');

		define("PLUGIN_VIEW_PATH", PLUGIN_PATH.'views/');
		define("PLUGIN_CONTROLLER_PATH", PLUGIN_PATH.'controller/');
		define("PLUGIN_MODEL_PATH", PLUGIN_PATH.'model/');

		Database::query("update ".Database::getPrefix()."plugins set status='0' where foldername='$foldername'");
		Database::query("update ".Database::getPrefix()."plugins_meta set status='0' where foldername='$foldername'");

		PluginsZone::saveCache();

		Redirect::to(System::getAdminUrl().'plugins');
	}

	public function import()
	{
      	if(Domain::isOtherDomain())
      	{
      		Alert::make('You dont have permission to access this page.');
      	}

		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_import_plugin');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}

		$post=array('alert'=>'');

		if(Request::has('btnSend'))
		{
			try {
				
				importProcess();

				$post['alert']='<div class="alert alert-success">Import plugins success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}		
		}

		View::make('admincp/head',array('title'=>'Import plugins - '.ADMINCP_TITLE));

		self::makeContents('pluginImport',$post);

		View::make('admincp/footer');		
	}


    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>