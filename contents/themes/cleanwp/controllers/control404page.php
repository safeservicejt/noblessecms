<?php

class control404page
{
	public function index()
	{
		System::setTitle('Page not found');

		Views::make('head');
		
		Views::make('404page');
		
		Views::make('footer');
	}
}