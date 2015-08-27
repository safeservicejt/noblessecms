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

		case 'changeHomePage':
		
			$send_url=trim(Request::get('send_url'));

			$send_url=str_replace(System::getUrl(), '', $send_url);

			$inputData=array(
				'default_page_method'=>'url',
				'default_page_url'=>$send_url
				);

			System::saveSetting($inputData);

			break;

		case 'getSetting':
			
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
		case 'addSetting':

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