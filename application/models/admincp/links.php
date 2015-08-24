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
			Links::remove($id);
			break;
		
	}
}

function updateProcess($id)
{
	$update=Request::get('update');

	$valid=Validator::make(array(
		'update.title'=>'required|min:1|slashes',
		'update.parentid'=>'slashes',
		
		'update.url'=>'required|min:1|slashes',
		'update.sort_order'=>'required|min:1|slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request: ".Validator::getMessage());
	}

	Links::update($id,$update);
	
}

function insertProcess()
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'required|min:1|slashes',
		'send.parentid'=>'slashes',
		'send.url'=>'required|min:1|slashes'

		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request: ".Validator::getMessage());
	}

	$loadData=Links::get(array(
		'where'=>"where url='".String::encode($send['url'])."'"
		));

	if(isset($loadData[0]['url']))
	{
		throw new Exception("This link exists in database.");
	}

	if(!$id=Links::insert($send))
	{
		throw new Exception("Error. ".Database::$error);
	}

	$updateData=array(
		'sort_order'=>$id
		);

	Links::update($id,$updateData);
}

?>