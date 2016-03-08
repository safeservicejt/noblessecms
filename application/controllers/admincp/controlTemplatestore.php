<?php

class controlTemplatestore
{
	public function index()
	{
		$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_manage_themes');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}		

		$post=array('alert'=>'');

		// Model::load('admincp/dbstore');


		$post['theList']=PluginStoreApi::getHtml(array(
			'send_method'=>'template'
			));

		System::setTitle('Template list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('templatsStore',$post);

		View::make('admincp/footer');

	}



    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}
