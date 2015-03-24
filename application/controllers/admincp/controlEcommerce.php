<?php

class controlEcommerce
{
	function __construct()
	{
		if(GlobalCMS::ecommerce()==false){
			Alert::make('Page not found');
		}
	}
	public function index()
	{
		Model::load('admincp/ecommerce');

		if($matches=Uri::match('stats\/(\w+)'))
		{
			statsProcess($matches[1]);
			die();
		}


		$post=array('alert'=>'');

		Model::load('misc');
		


		View::make('admincp/head',array('title'=>'Ecommerce Statitics - '.ADMINCP_TITLE));

        $this->makeContents('edashboard',$post);
        
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