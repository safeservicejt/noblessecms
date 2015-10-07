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
			CallToCode::remove($id);

			break;
		
	}	
}

function updateProcess($id)
{
	$valid=Validator::make(array(
		'send.title'=>'min:2|slashes',
		'send.friendly_url'=>'slashes',
		'send.type'=>'min:2|slashes',
		'send.status'=>'slashes'

		));

	if(!$valid)
	{
		throw new Exception("Error: ".implode(', ', Validator::$message));
		
	}

	$send=Request::get('send');

	if($send['type']!='html')
	{
		$send['content']=String::encode(trim(Request::get('othercontent','')));
	}

	CallToCode::update($id,$send);
}

function insertProcess()
{
	$valid=Validator::make(array(
		'send.title'=>'min:2|slashes',
		'send.friendly_url'=>'slashes',
		'send.type'=>'min:2|slashes',
		'send.status'=>'slashes'

		));

	if(!$valid)
	{
		throw new Exception("Error: ".implode(', ', Validator::$message));
		
	}

	$send=Request::get('send');

	if($send['type']=='php')
	{
		$send['content']=trim(Request::get('othercontent',''));
	}

	CallToCode::insert($send);
}

?>