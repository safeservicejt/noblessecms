<?php

function actionProcess()
{
	$id=Request::get('id');

	$listID="'".implode("','", $id)."'";

	$action=Request::get('action');

	// die($action);

	switch ($action) {
		case 'delete':
	
			Redirects::remove($id);
			break;
			
		case 'enable':
	
			Redirects::update($id,array(
				'status'=>1
				));

			
			break;

		case 'disable':
	
			Redirects::update($id,array(
				'status'=>0
				));
			break;
		
	}
}

function updateProcess($id)
{
	$update=Request::get('update');

	$valid=Validator::make(array(
		'send.from_url'=>'min:1|slashes',
		'send.to_url'=>'min:1|slashes',
		'send.status'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request: ".Validator::getMessage());
	}


	Redirects::update($id,$update);
	
}

function insertProcess()
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.from_url'=>'min:1|slashes',
		'send.to_url'=>'min:1|slashes',
		'send.status'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request: ".Validator::getMessage());
	}

	if(!$id=Redirects::insert($send))
	{
		throw new Exception("Error. ".Database::$error);
	}

}
