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

			// Database::query("delete p,pt from ".Database::getPrefix()."post p left join ".Database::getPrefix()."post_tags pt on p.postid=pt.postid where p.catid IN ($listID)");

			Render::makeSiteMap();

			break;

		case 'deleteallpost':

			$loadData=Post::get(array(
				'cache'=>'no',
				'isHook'=>'no'
				));

			$total=count($loadData);

			for ($i=0; $i < $total; $i++) { 
				Post::remove($loadData[$i]['postid']);
			}

			// Database::query("delete p,pt from ".Database::getPrefix()."post p left join ".Database::getPrefix()."post_tags pt on p.postid=pt.postid where p.catid IN ($listID)");

			Render::makeSiteMap();

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
			}

			Categories::remove(0,"catid IN ($listID)");

			Render::makeSiteMap();
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
		'where'=>"where catid='$id'"
		));

	if(!isset($loadData[0]['catid']))
	{
		throw new Exception('This category not exists.');
		
	}

	if(Request::hasFile('image'))
	{
		if(Request::isImage('image'))
		{
			$update['image']=File::upload('image');

			if(isset($loadData[0]['catid']))
			{
				File::remove($loadData[0]['image']);
			}
		}
	}


	Categories::update($id,$update);

	Categories::update(array($id),array(
		'friendly_url'=>String::makeFriendlyUrl(strip_tags($update['title'])).'-'.$id
		));

	Categories::saveCache($id);

	Render::makeSiteMap();
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
			'where'=>"where catid='$id'"
			));

		if(isset($loadData[0]['catid']))
		{
			Categories::update(array($id),array(
				'friendly_url'=>$loadData[0]['friendly_url'].'-'.$loadData[0]['catid']
				));
		}
	}

	Categories::saveCache($id);
	
	Render::makeSiteMap();
}
