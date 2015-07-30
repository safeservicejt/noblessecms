<?php

class controlSetting
{
	public function index()
	{
		
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
			System::saveSetting(Request::get('general'));
		}

		$data=array();

		if(!$data=Cache::loadKey('systemSetting',-1))
		{
			$data=System::makeSetting();
		}
		else
		{
			$data=unserialize($data);
		}


		$post=$data;

		$post['usergroups']=UserGroups::get();
		
		System::setTitle('Setting System - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('settingGeneral',$post);

		View::make('admincp/footer');

	}
	public function update()
	{
		$post=array('alert'=>'');

		if(Request::has('btnStart'))
		{
			// System::saveMailSetting(Request::get('mail'));
			Update::make();
			
			$post['alert']='<div class="alert alert-success">Update system success.</div>';
		}


		$post['data']=Update::get();

		// print_r($post);die();

		View::make('admincp/head',array('title'=>'Update System - '.ADMINCP_TITLE));

		self::makeContents('updateVersion',$post);

		View::make('admincp/footer');		
	}
	public function mailsystem()
	{
		$post=array('alert'=>'');

		if(Request::has('btnSave'))
		{
			System::saveMailSetting(Request::get('mail'));
		}


		$data=array();

		if(!$data=Cache::loadKey('systemSetting',-1))
		{
			$data=System::makeSetting();
		}
		else
		{
			$data=unserialize($data);
		}

		$post=$data;

		View::make('admincp/head',array('title'=>'Mail Setting - '.ADMINCP_TITLE));

		self::makeContents('settingMail',$post);

		View::make('admincp/footer');		
	}

	public function ecommerce()
	{
		$post=array('alert'=>'');
		if(Request::has('btnSave'))

		{
			System::saveSetting(Request::get('general'));
		}
		

		$data=array();

		if(!$data=Cache::loadKey('systemSetting',-1))
		{
			$data=System::makeSetting();
		}
		else
		{
			$data=unserialize($data);
		}

		$post=$data;

		$loadData=Currency::get();

		$post['listCurrency']=$loadData;

		View::make('admincp/head',array('title'=>'Ecommerce Setting - '.ADMINCP_TITLE));

		self::makeContents('settingEcommerce',$post);

		View::make('admincp/footer');		
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>