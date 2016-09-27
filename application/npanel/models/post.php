<?php

function actionProcess()
{
	$id=Request::get('id');


	$listID="'".implode("','", $id)."'";

	$action=Request::get('action');

	// die($action);

	switch ($action) {
		case 'delete':

			$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_remove_all_post');

			$addWhere='';
			$addWhere2='';

			if($valid!='yes')
			{
				$userid=Users::getCookieUserId();
				
				$addWhere=" userid='$userid'";
				$addWhere2=" AND p.userid='$userid'";
			}

			Post::remove($id,$addWhere);

			Database::query("delete pt from post_tags pt left join post p on pt.postid=p.id WHERE p.id IN ($listID) $addWhere2");

			// Render::makeSiteMap();			

			break;

		case 'deleteall':

			$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_remove_all_post');

			$addWhere='';
			$addWhere2='';

			if($valid!='yes')
			{
				$userid=Users::getCookieUserId();
				
				$addWhere=" userid='$userid'";
				$addWhere2=" p.userid='$userid'";

			}
			
			Database::query("delete pt from post_tags pt left join post p on pt.postid=p.id WHERE $addWhere2");			

			Post::remove(0,$addWhere);

			// Render::makeSiteMap();

			break;

		case 'release':
			Post::update($id,array(
				'date_added'=>date('Y-m-d H:i:s')
				));
			break;

		case 'publish':

			Post::update($id,array(
				'status'=>'publish'
				));

			// Render::makeSiteMap();

			break;

		case 'unpublish':
			Post::update($id,array(
				'status'=>'pending'
				));

			// Render::makeSiteMap();
			break;

		case 'featured':
		$today=date('Y-m-d h:i:s');
			Post::update($id,array(
				'is_featured'=>1,
				'date_featured'=>$today
				));
			break;

		case 'unfeatured':
			Post::update($id,array(
				'is_featured'=>0
				));
			break;

		case 'allowcomment':
			Post::update($id,array(
				'allowcomment'=>1
				));
			break;

		case 'unallowcomment':
			Post::update($id,array(
				'allowcomment'=>0
				));
			
		case 'ishomepage':

			$postid=$id[0];

			if((int)$postid <= 0)
			{
				return false;
			}

			$loadData=Post::get(array(
				'where'=>"where id='$postid'"
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
		'send.catid'=>'slashes',
		'send.type'=>'slashes',
		'send.allowcomment'=>'slashes',
		'send.friendly_url'=>'min:1|slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request. Error: ".Validator::getMessage());
	}

	$uploadMethod=Request::get('uploadMethod');
	$autoCrop=trim(Request::get('autoCrop','disable'));

	// $send['userid']=Users::getCookieUserId();

	// $userid=Users::getCookieUserId();


	$loadData=Post::get(array(
		'cache'=>'no',
		'where'=>"where id='$id'"
		));

	if(!isset($loadData[0]['id']))
	{
		throw new Exception("This post not exists.");
		
	}


	switch ($uploadMethod) {
		case 'frompc':
			if(Request::hasFile('imageFromPC'))
			{
				if(Request::isImage('imageFromPC'))
				{
					$send['image']=File::upload('imageFromPC','uploads/files/',$send['title']);

					File::remove($loadData[0]['image']);
				}
			}
			break;
		case 'fromurl':

			$url=Request::get('imageFromUrl');

			$send['image']=File::uploadFromUrl($url,'uploads/files/',$send['title']);

			File::remove($loadData[0]['image']);

			break;
	}

	if($autoCrop=='enable' && preg_match('/.*?\.\w+/i', $send['image']))
	{
		$data=Image::getSize(ROOT_PATH.$send['image']);

		if((int)$data['width'] < (int)$data['height'])
		{
			Image::cropCenter(ROOT_PATH.$send['image'],$data['width'],$data['width'],ROOT_PATH.$send['image']);
		}

		if((int)$data['width'] > (int)$data['height'])
		{
			Image::cropCenter(ROOT_PATH.$send['image'],$data['height'],$data['height'],ROOT_PATH.$send['image']);
		}
	}


	if(!Request::has('send.catid'))
	{
		$loadCat=Categories::get(array(
			'cache'=>'no',
			'limitShow'=>1
			));

		if(isset($loadCat[0]['catid']))
		{
			$send['catid']=$loadCat[0]['catid'];
		}
	}

	
	if(!Post::update($id,$send))
	{
		throw new Exception("Error. ".Database::$error);
	}

	PostTags::remove($id," postid='$id' ");

	$tags=trim(Request::get('tags'));

	$parse=explode(',', $tags);

	$total=count($parse);

	$insertData=array();

	for ($i=0; $i < $total; $i++) { 
		
		$text=trim($parse[$i]);

		if($text=='')
		{
			continue;
		}

		$insertData[$i]['title']=strtolower($text);
		$insertData[$i]['postid']=$id;

		PostTags::insert($insertData[$i]);
	}
	
	Post::updateData($id);

	Post::saveCache($id);

}

function insertProcess()
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'min:1',
		'send.catid'=>'slashes',
		'send.type'=>'slashes',
		'send.allowcomment'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request: ".Validator::getMessage());
	}

	$autoCrop=trim(Request::get('autoCrop','disable'));

	$friendlyUrl=trim(Strings::makeFriendlyUrl($send['title']));


	$uploadMethod=trim(Request::get('uploadMethod'));

	switch ($uploadMethod) {
		case 'frompc':
			if(Request::hasFile('imageFromPC'))
			{
				if(Request::isImage('imageFromPC'))
				{
					$send['image']=File::upload('imageFromPC','uploads/files/',$send['title']);
				}
			}
			break;
		case 'fromurl':

			$url=Request::get('imageFromUrl');

			$send['image']=File::uploadFromUrl($url,'uploads/files/',$send['title']);

			break;
	}

	if($autoCrop=='enable' && preg_match('/.*?\.\w+/i', $send['image']))
	{
		$data=Image::getSize(ROOT_PATH.$send['image']);

		if((int)$data['width'] < (int)$data['height'])
		{
			Image::cropCenter(ROOT_PATH.$send['image'],$data['width'],$data['width'],ROOT_PATH.$send['image']);
		}

		if((int)$data['width'] > (int)$data['height'])
		{
			Image::cropCenter(ROOT_PATH.$send['image'],$data['height'],$data['height'],ROOT_PATH.$send['image']);
		}
	}

	$send['userid']=Users::getCookieUserId();

	if(!Request::has('send.catid'))
	{
		$loadCat=Categories::get(array(
			'limitShow'=>1,
			));

		if(isset($loadCat[0]['catid']))
		{
			$send['catid']=$loadCat[0]['id'];
		}
	}

	if($send['status']=='publish')
	{
		$send['status']=(int)Usergroups::getPermission(Users::getCookieGroupId(),'default_new_post_status');
	}

	if(!$id=Post::insert($send))
	{
		throw new Exception("Error. ".Database::$error);
	}

	$tags=trim(Request::get('tags'));

	$parse=explode(',', $tags);

	$total=count($parse);

	$insertData=array();

	for ($i=0; $i < $total; $i++) { 

		$text=trim($parse[$i]);

		if($text=='')
		{
			continue;
		}

		$insertData[$i]['title']=strtolower($text);
		$insertData[$i]['postid']=$id;

		PostTags::insert($insertData[$i]);
	}

	
	Post::updateData($id);

	Post::saveCache($id);

}
