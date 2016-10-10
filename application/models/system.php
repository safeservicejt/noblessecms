<?php

function apiProcess($keyName='')
{
	if($keyName=='sendtestemail')
	{
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
	}
	elseif($keyName=='changehomepage')
	{
		if(!Users::hasLogin())
		{
			throw new Exception('You must login to do this action.');
			
		}

		$send_url=trim(Request::get('send_url'));

		$send_url=str_replace(System::getUrl(), '', $send_url);

		$inputData=array(
			'default_page_method'=>'url',
			'default_page_url'=>$send_url
			);

		System::saveSetting($inputData);
	}
	else
	{
		throw new Exception('We not support api: '.$keyName);
	}
}