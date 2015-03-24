<?php

class controlDashboard
{
	public function index()
	{
		Model::load('admincp/dashboard');

		if($matches=Uri::match('stats\/(\w+)'))
		{
			// die('dfd');
			statsProcess($matches[1]);
			die();
		}	
	}


}

?>