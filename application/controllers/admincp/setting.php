<?php

class Setting
{

	public function index()
	{
		if(Uri::has('ecommerce'))
		{
			$this->ecommerce();
			die();
		}

		if(Uri::has('mailsystem'))
		{
			$this->mailsystem();
			die();
		}

		// if(Uri::has('multidb'))
		// {
		// 	$this->multidb();
		// 	die();
		// }

		$post=array();

		$post['alert']='';

		Model::load('admincp/setting');



		if(Request::has('btnSave'))
		{

			$post['alert']='<div class="alert alert-success">Save changes success.</div>';

			// print_r(Request::get('general'));die();

			if(!saveeSetting(Request::get('general')))
			{
				$post['alert']='<div class="alert alert-danger">Check information again !</div>';
			}

			saveBanner();

		}
		
		$dataSetting=Server::getSetting();
		// print_r($dataSetting);die();

		$dataSetting['alert']=$post['alert'];

		$dataSetting['usergroups']=UserGroups::get(array(
			'orderby'=>'order by group_title asc'		
			));

		View::make('admincp/head',array('title'=>'General Settings - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/setting',$post);
        
        $this->makeContents('setting',$dataSetting);

        View::make('admincp/footer');  
	}
	
	public function multidb()
	{	
		$post=array('alert'=>'');

		Model::load('misc');

		if(Request::has('btnAdd'))
		{

			$post['alert']='<div class="alert alert-success">Add new database success.</div>';

			$data=Request::get('send');


			if(!$id=Multidb::insert($data))
			{
				$post['alert']='<div class="alert alert-warning">Add new database error.</div>';
			}
		}
		if(Request::has('btnClear'))
		{

			$post['alert']='<div class="alert alert-success">Reset cache success.</div>';

			Multidb::resetPost();
		}
		if(Request::has('btnSave'))
		{
				$post['alert']='<div class="alert alert-success">Edit database information success.</div>';

				// editCategory(array('id'=>Request::get('send.id'),'title'=>Request::get('send.title'),'order'=>Request::get('send.sort_order','0'),'oldimage'=>Request::get('send.oldimage')));

				$id=Uri::getNext('edit');

				$data=array();

				$data=Request::get('send');

				// print_r($data);die();

				Multidb::update($id,$data);

		}

		$post['showEdit']='no';
		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				if(Request::has('id'))
				Multidb::remove(Request::get('id'));	
			}
				

		}

		if(Uri::has('edit'))
		{
				$post['showEdit']='yes';

				$id=Uri::getNext('edit');

				$post['id']=$id;

				$data=Multidb::get(array(
					'where'=>"where dbid='".$id."'"
					));

						// print_r($data);die();

				$post['edit']=$data[0];
		}

		// Multidb::connect(1);


		// print_r($loadData);die();

		$post['theList']=Multidb::get();

		View::make('admincp/head',array('title'=>'Multiple Database Settings - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/setting',$post);
        
        $this->makeContents('multidbSetting',$post);

        View::make('admincp/footer');  
	}
	public function ecommerce()
	{	
		$post=array();

		$post['alert']='';

		Model::load('admincp/setting');

		if(Request::has('btnSave'))
		{

			$post['alert']='<div class="alert alert-success">Save changes success.</div>';

			// print_r(Request::get('general'));die();

			if(!saveeSetting(Request::get('general')))
			{
				$post['alert']='<div class="alert alert-danger">Check information again !</div>';
			}

		}
		
		$dataSetting=Server::getSetting();

		// print_r($dataSetting);die();

		$dataSetting['alert']=$post['alert'];

		$dataSetting['listCurrency']=Currency::get(array(
			'orderby'=>'order by title asc'		
			));


		View::make('admincp/head',array('title'=>'Ecommerce Settings - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/setting',$post);
        
        $this->makeContents('eSetting',$dataSetting);

        View::make('admincp/footer');  
	}

	public function mailsystem()
	{	
		$post=array();

		$post['alert']='';

		Model::load('admincp/setting');

		if(Request::has('btnSave'))
		{

			$post['alert']='<div class="alert alert-success">Save changes success.</div>';

			// print_r(Request::get('general'));die();

			$data=Request::get('mail');

			Cache::saveKey('mailSetting',json_encode($data));

		}

		// print_r($dataSetting);die();

		$dataSetting['alert']=$post['alert'];

		$tmp=Cache::loadKey('mailSetting',-1);

		$dataSetting['mail']=json_decode($tmp,true);


		View::make('admincp/head',array('title'=>'Mail System Settings - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/setting',$post);
        
        $this->makeContents('mailSetting',$dataSetting);

        View::make('admincp/footer');  
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/nav');
                
        View::make('admincp/left');  
              
        View::make('admincp/startContent');

        View::make('admincp/'.$viewPath,$inputData);

        View::make('admincp/endContent');
         // View::make('admincp/right');

    }	
}

?>