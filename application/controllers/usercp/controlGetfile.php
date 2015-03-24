<?php

class controlGetfile
{
	function __construct()
	{
		if(GlobalCMS::ecommerce()==false){
			Alert::make('Page not found');
		}
	}

	public function index()
	{
		$post=array('alert'=>'');

		Model::load('usercp/getfile');

		fileProcess();

	}


}

?>