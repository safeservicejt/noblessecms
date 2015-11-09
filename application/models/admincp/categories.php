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
		case 'deleteallpost':

			
			Database::query("delete p,pt from ".Database::getPrefix()."post p left join ".Database::getPrefix()."post_tags pt on p.postid=pt.postid where p.catid IN ($listID)");

			break;
		case 'delete':

	
			Database::query("delete p,pt from ".Database::getPrefix()."post p left join ".Database::getPrefix()."post_tags pt on p.postid=pt.postid where p.catid IN ($listID)");

			Categories::remove($id);
			break;
		
	}
}

function updateProcess($id)
{
	$update=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'required|min:1|slashes',
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
			$update['image']=File::upload('image');

			$loadData=Categories::get(array(
				'where'=>"where catid='$id'"
				));

			if(isset($loadData[0]['catid']))
			{
				File::remove($loadData[0]['image']);
			}
		}
	}


	Categories::update($id,$update);
	
}

function insertProcess()
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'required|min:1|slashes',
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

}

?>