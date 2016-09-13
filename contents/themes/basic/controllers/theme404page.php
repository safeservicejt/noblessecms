<?php

class theme404page
{
	public function index()
	{
		System::setTitle('Page not found');

		Theme::view('head');
		
		Theme::view('404page');
		
		Theme::view('footer');
	}
}