<?php

function loadApi($action)
{
	$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_edit_post');

	if($valid!='yes')
	{
		throw new Exception('You not have permission to view this page');
	}

	$send_postid=trim(Request::get('send_postid',0));

	switch ($action) {
		case 'release':

			if((int)$send_postid==0)
			{
				throw new Exception('Data not valid.');
			}

			$today=date('Y-m-d H:i:s');

			Post::update(array($send_postid),array(
				'date_added'=>$today
				));
			
			break;
		case 'change_status':

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
			
			break;

		case 'set_featured':

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
			
			break;

		case 'allow_comment':

			if((int)$send_postid==0)
			{
				throw new Exception('Data not valid.');
			}

			Post::update(array($send_postid),array(
				'allowcomment'=>1
				));
			
			break;

		case 'disallow_comment':

			if((int)$send_postid==0)
			{
				throw new Exception('Data not valid.');
			}

			Post::update(array($send_postid),array(
				'allowcomment'=>0
				));
			
			break;

	}	
}

?>