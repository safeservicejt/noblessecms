<?php

function actionProcess()
{
	$id=Request::get('id');


	$listID="'".implode("','", $id)."'";

	$action=Request::get('action');

	// die($action);

	switch ($action) {
		case 'delete':

			$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_remove_link');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}

			Links::remove($id);
			
			Links::saveCache();	
			break;
		case 'ishomepage':

			$linkid=$id[0];

			if((int)$linkid <= 0)
			{
				return false;
			}

			$loadData=Links::get(array(
				'where'=>"where id='$linkid'"
				));

			if(!isset($loadData[0]['urlFormat']))
			{
				return false;
			}

			$send_url=$loadData[0]['url'];

			$send_url=str_replace(System::getUrl(), '', $send_url);

			$inputData=array(
				'default_page_method'=>'url',
				'default_page_url'=>$send_url
				);

			System::saveSetting($inputData);

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

	$loadData=Links::get(array(
		'where'=>"where id='$id'"
		));

	if(!isset($loadData[0]['url']))
	{
		throw new Exception("This link not exists in database.");
	}

	$send['url']=str_replace(System::getUrl(), '', $send['url']);

	Links::update($id,$update);
	
	Links::saveCache();	
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
		'where'=>"where title='".addslashes($send['title'])."' AND url='".Strings::encode($send['url'])."'"
		));

	if(isset($loadData[0]['url']))
	{
		throw new Exception("This link exists in database.");
	}

	$send['url']=str_replace(System::getUrl(), '', $send['url']);

	$send['status']='published';

	if(!$id=Links::insert($send))
	{
		throw new Exception("Error. ".Database::$error);
	}

	$updateData=array(
		'sort_order'=>$id
		);

	Links::update($id,$updateData);

	Links::saveCache();
}
