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
			UserGroups::remove($id);

			UserGroups::saveCacheAll();

			break;
		
	}
}

function updateProcess($groupid)
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'min:1|slashes',
		'send.permissions'=>'min:1|slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}

	$title=trim(Request::get('send.title'));


	$content=trim(Request::get('send.permissions'));

	$updateData=array(
		'title'=>$title,
		'permissions'=>$content
		);

	UserGroups::update($groupid,$updateData);

	UserGroups::saveCache($groupid);
	
}

function insertProcess()
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'min:1|slashes',
		'send.permissions'=>'min:1|slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}

	$title=trim(Request::get('send.title'));

	$loadData=UserGroups::get(array(
		'where'=>"where title='$title'"
		));

	if(isset($loadData[0]['permissions']))
	{
		throw new Exception("This group have been exists.");
		
	}

	$content=trim(Request::get('send.permissions'));

	$insertData=array(
		'title'=>$title,
		'permissions'=>$content
		);

	$id=UserGroups::insert($insertData);

	UserGroups::saveCache($id);

}
