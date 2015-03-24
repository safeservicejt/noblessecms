<?php

function fileProcess()
{
	if(!$matches=Uri::match('getfile\/orderid\/(\d+)\/file\/(\d+)_.*?$'))
	{
		Alert::make('Page not found');
	}

	if(!Session::has('userid'))
	{
		Alert::make('You must login for download this file.');
	}

	$orderid=$matches[1];

	$downloadid=$matches[2];

	$loadData=Orders::get(array(
		'where'=>"where orderid='$orderid'"
		));

	if(!isset($loadData[0]['orderid']))
	{
		Alert::make('This order not exists');
	}

	$fileData=Downloads::get(array(
		'where'=>"where orderid='$downloadid'"
		));

	if(!isset($fileData[0]['downloadid']))
	{
		Alert::make('File not found');
	}

	$filePath=ROOT_PATH.$fileData[0]['filename'];

	if(file_exists($filePath))
	{
		File::download($filePath,$fileData[0]['title']);
	}


}

?>