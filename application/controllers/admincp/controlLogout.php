<?php

class controlLogout
{
	public function index()
	{
        Users::logout();

        Redirect::to(System::getUrl().'admincp');

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
