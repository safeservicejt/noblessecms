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

			$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_remove_page');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}

			Pages::remove($id);

			// Render::makeSiteMap();

			break;
		case 'publish':

			Pages::update($id,array(
				'status'=>1
				));

			// Render::makeSiteMap();
			break;
		case 'unfeatured':
			Pages::update($id,array(
				'is_featured'=>0
				));

			// Render::makeSiteMap();
			break;
		case 'allowcomment':
			Pages::update($id,array(
				'allowcomment'=>1
				));
			break;
		case 'unallowcomment':
			Pages::update($id,array(
				'allowcomment'=>0
				));
			break;
		case 'ishomepage':

			$pageid=$id[0];

			if((int)$pageid <= 0)
			{
				return false;
			}

			$loadData=Pages::get(array(
				'where'=>"where id='$pageid'"
				));

			if(!isset($loadData[0]['id']))
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
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'min:1',
		'send.friendly_url'=>'min:1|slashes',
		'send.content'=>'min:1'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request: ".Validator::getMessage());
	}

	$uploadMethod=Request::get('uploadMethod');


	$loadData=Pages::get(array(
		'where'=>"where id='$id'"
		));

	if(!isset($loadData[0]['id']))
	{
		throw new Exception("This page not exists.");
		
	}

	switch ($uploadMethod) {
		case 'frompc':
			if(Request::hasFile('imageFromPC'))
			{
				if(Request::isImage('imageFromPC'))
				{
					$send['image']=File::upload('imageFromPC');

					File::remove($loadData[0]['image']);
				}
			}
			break;
		case 'fromurl':

			if(Request::isImage('imageFromUrl'))
			{
				$url=Request::get('imageFromUrl');

				$send['image']=File::upload('uploadFromUrl');

				File::remove($loadData[0]['image']);
			}

			break;
	}


	if(!Pages::update($id,$send))
	{
		throw new Exception("Error. ".Database::$error);
	}

}

function insertProcess()
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'min:1',
		'send.content'=>'min:1',
		'send.type'=>'slashes',
		'send.allowcomment'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request: ".Validator::getMessage());
	}

	if(!isset($send['page_title'][2]))
	{
		$send['page_title']=$send['title'];
	}

	$uploadMethod=Request::get('uploadMethod');

	switch ($uploadMethod) {
		case 'frompc':
			if(Request::hasFile('imageFromPC'))
			{
				if(Request::isImage('imageFromPC'))
				{
					$send['image']=File::upload('imageFromPC');
				}
			}
			break;
		case 'fromurl':

			if(Request::isImage('imageFromUrl'))
			{
				$url=Request::get('imageFromUrl');

				$send['image']=File::upload('uploadFromUrl');
			}

			break;
	}

	if(!$id=Pages::insert($send))
	{
		throw new Exception("Error. ".Database::$error);
	}

}
