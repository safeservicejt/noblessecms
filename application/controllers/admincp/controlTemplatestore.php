<?php

class controlTemplatestore
{
	public function index()
	{

		$post=array('alert'=>'');

		// Model::load('admincp/dbstore');

      	if(Domain::isOtherDomain())
      	{
      		Alert::make('You dont have permission to access this page.');
      	}

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

?>