<?php

class controlApi
{

	public function index()
	{
		// $resultData=Api::parseUri();

		// echo $resultData;

		// die();

		
		if(Uri::has('statsPost'))
		{
			Model::load('admincp/news');
		}

		if(Uri::has('statsUser'))
		{
			Model::load('admincp/users');
		}

		getApi();

		die();
	}




}

?>