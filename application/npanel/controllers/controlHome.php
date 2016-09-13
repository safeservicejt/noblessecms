<?php

class controlHome
{
	public static function index()
	{


		$pageData=array();

		$pageData=countStats();

		Views::make('head');

		Views::make('left');

		Views::make('dashboard',$pageData);

		Views::make('footer');		
	}	
}