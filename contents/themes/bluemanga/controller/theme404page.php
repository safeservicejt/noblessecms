<?php

class theme404page
{
	public function index()
	{
		Response::headerCode(404);
		
		System::setTitle('Page not found');

		$themePath=System::getThemePath().'view/';

		View::makeWithPath('head',array(),$themePath);

		View::makeWithPath('404page',array(),$themePath);

		// View::makeWithPath('right_home',array(),$themePath);

		View::makeWithPath('footer',array(),$themePath);

	}


}

?>