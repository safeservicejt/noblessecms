<?php

function apiProcess($keyName='')
{
	$send_postid=trim(Request::get('send_postid',0));
	
	if($keyName=='release')
	{
		if((int)$send_postid==0)
		{
			throw new Exception('Data not valid.');
		}

		$today=date('Y-m-d H:i:s');

		Post::update(array($send_postid),array(
			'date_added'=>$today
			));	
	}
	elseif($keyName=='change_status')
	{
		if((int)$send_postid==0)
		{
			throw new Exception('Data not valid.');
		}

		$send_status=trim(Request::get('send_status',0));

		$send_status=($send_status=='publish')?1:$send_status;

		$send_status=($send_status=='unpublish')?0:$send_status;

		Post::update(array($send_postid),array(
			'status'=>$send_status
			));
	}
	elseif($keyName=='set_featured')
	{
		if((int)$send_postid==0)
		{
			throw new Exception('Data not valid.');
		}

		$send_status=trim(Request::get('send_status',0));

		$send_status=($send_status=='featured')?1:$send_status;
		
		$send_status=($send_status=='unfeatured')?0:$send_status;

		$today=date('Y-m-d H:i:s');

		Post::update(array($send_postid),array(
			'is_featured'=>$send_status,
			'date_featured'=>$today
			));
	}
	elseif($keyName=='allow_comment')
	{
		if((int)$send_postid==0)
		{
			throw new Exception('Data not valid.');
		}

		Post::update(array($send_postid),array(
			'allowcomment'=>1
			));
	}
	elseif($keyName=='disallow_comment')
	{
		if((int)$send_postid==0)
		{
			throw new Exception('Data not valid.');
		}

		Post::update(array($send_postid),array(
			'allowcomment'=>0
			));
	}
	else
	{
		throw new Exception('We not support api: '.$keyName);
	}
}