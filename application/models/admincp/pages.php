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

			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_remove_page');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}

			Pages::remove($id);

			break;
		case 'publish':

			Pages::update($id,array(
				'status'=>1
				));
			break;
		case 'unfeatured':
			Pages::update($id,array(
				'is_featured'=>0
				));
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
				'where'=>"where pageid='$pageid'"
				));

			if(!isset($loadData[0]['pageid']))
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
		'where'=>"where pageid='$id'"
		));

	if(!isset($loadData[0]['pageid']))
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

	Pages::update($id,array(
		'friendly_url'=>String::makeFriendlyUrl(strip_tags($send['title'])).'-'.$id
		));	
		
	
}

function insertProcess()
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'min:1',
		'send.content'=>'min:1',
		'send.page_type'=>'slashes',
		'send.allowcomment'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request: ".Validator::getMessage());
	}

	$friendlyUrl=trim(String::makeFriendlyUrl($send['title']));

	$getData=Pages::get(array(
		'where'=>"where friendly_url='$friendlyUrl'"
		));

	if(isset($getData[0]['pageid']))
	{
		throw new Exception("This page exists in database.");
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

	Pages::update($id,array(
		'friendly_url'=>String::makeFriendlyUrl(strip_tags($send['title'])).'-'.$id
		));	


}
