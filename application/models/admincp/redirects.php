<?php

function actionProcess()
{
	$id=Request::get('id');

	if(!isset($id[0]))
	{
		return false;
	}

	$listID="'".implode("','", $id)."'";

	$action=Request::get('action');

	// die($action);

	switch ($action) {
		case 'delete':
	
			Redirect::remove($id);
			break;
			
		case 'enable':
	
			Redirect::update($id,array(
				'status'=>1
				));
			break;

		case 'disable':
	
			Redirect::update($id,array(
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


	Redirect::update($id,$update);
	
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

	if(!$id=Redirect::insert($send))
	{
		throw new Exception("Error. ".Database::$error);
	}

}
