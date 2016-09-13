<?php

function actionProcess()
{
	$id=Request::get('id');


	$listID="'".implode("','", $id)."'";

	$action=Request::get('action');



	switch ($action) {

		case 'deleteall':

			$loadData=Post::get(array(
				'cache'=>'no',
				'isHook'=>'no'
				));

			$total=count($loadData);
			for ($i=0; $i < $total; $i++) { 
				Post::remove(array($loadData[$i]['postid']));


			}

			Categories::remove(0,"catid > '0'");


			break;

		case 'deleteallpost':

			$loadData=Post::get(array(
				'cache'=>'no',
				'isHook'=>'no'
				));

			$total=count($loadData);

			for ($i=0; $i < $total; $i++) { 
				Post::remove($loadData[$i]['postid']);

				Post::removeCache($loadData[$i]['postid']);
			}

			break;

		case 'delete':


			$loadData=Post::get(array(
				'cache'=>'no',
				'isHook'=>'no',
				'where'=>"where catid IN ($listID)"
				));

			$total=count($loadData);
			for ($i=0; $i < $total; $i++) { 
				Post::remove(array($loadData[$i]['postid']));

				Post::removeCache($loadData[$i]['postid']);
			}

			Categories::remove(0,"catid IN ($listID)");

			// Render::makeSiteMap();
			break;
		
	}
}

function updateProcess($id)
{
	$update=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'min:1',
		'send.parentid'=>'slashes',
		'send.friendly_url'=>'min:1|slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request: ".Validator::getMessage());
	}

	$loadData=Categories::get(array(
		'where'=>"where id='$id'"
		));

	if(!isset($loadData[0]['id']))
	{
		throw new Exception('This category not exists.');
		
	}

	if(Request::hasFile('image'))
	{
		if(Request::isImage('image'))
		{
			$update['image']=File::upload('image');

			if(isset($loadData[0]['id']))
			{
				File::remove($loadData[0]['image']);
			}
		}
	}


	Categories::update($id,$update);

	// Render::makeSiteMap();
}

function insertProcess()
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'min:1',
		'send.parentid'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request: ".Validator::getMessage());
	}

	if(Request::hasFile('image'))
	{
		if(Request::isImage('image'))
		{
			$send['image']=File::upload('image');
		}
	}

	if(!$id=Categories::insert($send))
	{
		throw new Exception("Error. ".Database::$error);
	}

	if((int)$id > 0)
	{
		$loadData=Categories::get(array(
			'cache'=>'no',
			'where'=>"where id='$id'"
			));

		if(isset($loadData[0]['id']))
		{
			Categories::update(array($id),array(
				'friendly_url'=>$loadData[0]['friendly_url'].'-'.$loadData[0]['id']
				));
		}
	}

	Categories::saveCache($id);
	
	// Render::makeSiteMap();
}
