<?php

function forgotProcess()
{
	if(Session::has('forgotPassword'))
	{
		return true;
	}

	$valid=Validator::make(array(
		'email'=>'email|slashes'
		));

	if(!$valid)
	{
		return false;
	}

	$email=trim(Request::get('email'));

	$loadData=Users::get(array(
		'where'=>"where email='$email'"
		));

	if(!isset($loadData[0]['userid']))
	{
		return false;
	}

	$tmp=Cache::loadKey('mailSetting',-1);

	$dataSetting=json_decode($tmp,true);

	$sendMethod=$dataSetting['send_method'];

	$firstname=$loadData[0]['firstname'];

	$lastname=$loadData[0]['lastname'];

	$fullname=$firstname.' '.$lastname;

	if(!isset($fullname[2]))
	{
		$fullname='Customer';
	}



	switch ($sendMethod) {
		case 'local':

		$post=array(
			'toName'=>$fullname,
			'toEmail'=>$email,
			'fromName'=>$dataSetting['fromName'],
			'fromEmail'=>$dataSetting['fromEmail'],
			'subject'=>$dataSetting['forgotSubject'],
			'message'=>$dataSetting['forgotContent']
			);

		if(Mail::sendMailFromLocal($post))
		{
			Session::make('forgotPassword','1');
			return true;
		}

		return false;

			break;
		case 'account':

		$post=array(
			'toName'=>$fullname,
			'toEmail'=>$email,

			'fromName'=>$dataSetting['fromName'],
			'fromEmail'=>$dataSetting['fromEmail'],

			'subject'=>$dataSetting['forgotSubject'],
			'message'=>$dataSetting['forgotContent'],

			'smtpAddress'=>$dataSetting['smtpAddress'],
			'smtpUser'=>$dataSetting['smtpUser'],
			'smtpPass'=>$dataSetting['smtpPass'],
			'smtpPort'=>$dataSetting['smtpPort']
			);

		if(Mail::sendMail($post))
		{
			Session::make('forgotPassword','1');
			return true;
		}

			break;

	}



	return true;
}


?>