<?php

function loadApi($action)
{

	$groupid=Users::getCookieGroupId();

	$userid=Users::getCookieUserId();

	if((int)$groupid<=0 || (int)$userid<=0)
	{
		throw new Exception('You must login');
	}

	if((int)$groupid!=1)
	{
		throw new Exception('You can not do this action');
	}

	switch ($action) {

		case 'sendtestemail':
		
			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			$userid=Users::getCookieUserId();

			if($owner!='yes')
			{
				throw new Exception('You not have permission to do this action.');
				
			}			

			$send_email=trim(Request::get('send_email',''));

			if(!preg_match('/\w+\@\w+\./i', $send_email))
			{
				throw new Exception('Data not valid.');
				
			}

			Mail::send(array(
			'toEmail'=>$send_email,
			'toName'=>'You',
			'subject'=>'Test mail',
			'body'=>'<h1>This is test mail</h1>'
			));			

			break;

		case 'changehomepage':
		
			$send_url=trim(Request::get('send_url'));

			$send_url=str_replace(System::getUrl(), '', $send_url);

			$inputData=array(
				'default_page_method'=>'url',
				'default_page_url'=>$send_url
				);

			System::saveSetting($inputData);

			break;

		case 'getsetting':
			
			if(!isset($_COOKIE['groupid']))
			{
				throw new Exception("You must be login.");

			}

			try {

				if(!$id=Categories::insert(Request::make('send')))
				{
					throw new Exception("Error. ".Database::$error);
					
				}

				return json_encode(array('error'=>'no'));

			} catch (Exception $e) {

				throw new Exception($e->getMessage());
			}
			
			break;
		case 'addsetting':

			try {

				$data=Categories::get();

				return json_encode($data);

			} catch (Exception $e) {

				throw new Exception($e->getMessage());

			}
			
			break;

	}	
}

?>