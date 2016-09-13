<?php

function actionProcess()
{
	$id=Request::get('id');

	$result='';

	if(!isset($id[0]))
	{
		return false;
	}

	$listID="'".implode("','", $id)."'";

	$action=Request::get('action');

	// die($action);

	switch ($action) {
		case 'delete':

			Users::remove($id);

			Address::remove($id);

			Users::removeCache($id);

			break;

		case 'activate':

			Users::update($id,array(
				'verify_code'=>''
				));

			$total=count($id);

			for ($i=0; $i < $total; $i++) { 
				$theID=$id[$i];

				Users::saveCache($theID);
			}
			break;
		case 'banned':

			Users::makeBannedUserID($id);

			$total=count($id);

			for ($i=0; $i < $total; $i++) { 
				$theID=$id[$i];

				Users::saveCache($theID);
			}

			break;

		case 'changepassword':

			$newPass=String::randText(8);

			Users::update($id,array(
				'password'=>String::encrypt($newPass),
				'forgot_code'=>''
				));

			$result=$newPass;

			$total=count($id);

			for ($i=0; $i < $total; $i++) { 
				$theID=$id[$i];

				Users::saveCache($theID);
			}

			break;

		
	}

	return $result;
}

function insertProcess()
{
	$valid=Validator::make(array(
		'address.firstname'=>'min:1|slashes',
		'address.lastname'=>'min:1|slashes',
		'send.groupid'=>'number|slashes',
		'send.username'=>'min:3|slashes',
		'send.email'=>'email|slashes',
		'address.address_1'=>'slashes',
		'address.address_2'=>'slashes',
		'address.city'=>'slashes',
		'address.state'=>'slashes',
		'address.zipcode'=>'slashes',
		'address.country'=>'slashes'

		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request: ".Validator::getMessage());
		
	}

	$username=Request::get('send.username');

	$email=Request::get('send.email');

	$loadData=Users::get(array(
		'where'=>"where username='$username' OR email='$email'"
		));

	if(isset($loadData[0]['id']))
	{
		throw new Exception("This user have been exist in database.");
		
	}

	$send=Request::get('send');

	$address=Request::get('address');
	
	$thepass=Request::get('thepass');

	$passMd5=String::encrypt($thepass);

	$send['password']=$passMd5;

	$userid=Users::insert($send);

	$address['userid']=$userid;

	Address::insert($address);

	Users::saveCache($userid);
}

function updateProcess($id)
{
	$send=Request::get('send');

	$address=Request::get('address');

	Users::update($id,$send);

	Address::update($id,$address);

	Users::saveCache($id);
	
}