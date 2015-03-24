<?php

class controlApi
{

	public function index()
	{
		if(Uri::has('statsPost'))
		{
			$this->statsPost();
			die();
		}
		if(Uri::has('statsUser'))
		{
			$this->statsUser();
			die();
		}
	}

	public function statsPost()
	{
		Model::load('admincp/news');

		$loadMethod=Uri::getNext('statsPost');

		if($loadMethod == 'statsPost')
		{
			echo '';

			die();
		}


		$loadData='';

		switch ($loadMethod) {
			case 'week':
				$loadData=statsWeek();
				break;
			case 'month':
				$loadData=statsMonth();
				break;
			

		}

		echo $loadData;die();

	}

	public function statsUser()
	{
		Model::load('admincp/users');

		$loadMethod=Uri::getNext('statsUser');

		if($loadMethod == 'statsUser')
		{
			echo '';

			die();
		}


		$loadData='';

		switch ($loadMethod) {
			case 'week':
				$loadData=user_statsWeek();
				break;
			case 'month':
				$loadData=user_statsMonth();
				break;
			

		}

		echo $loadData;die();

	}


}

?>