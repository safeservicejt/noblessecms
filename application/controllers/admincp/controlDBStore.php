<?php

class controlDBStore
{
	public function index()
	{

		$post=array('alert'=>'');

		// Model::load('admincp/dbstore');

		if($match=Uri::match('\/dbstore\/(\w+)'))
		{
			if(method_exists("controlDBStore", $match[1]))
			{	
				$method=$match[1];

				$this->$method();

				die();
			}
			
		}

		Redirect::to(ADMINCP_URL);

	}

	public function plugin()
	{
		System::setTitle('Plugin list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('pluginsStore',$post);

		View::make('admincp/footer');		
	}


    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>