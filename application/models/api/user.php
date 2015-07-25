<?php

function loadApi($action)
{
	switch ($action) {
		case 'login':
			
			if(isset($_SESSION['userid']))
			{
				throw new Exception("You have been loggedin.");

			}

			$username=Request::get('username','');

			$password=Request::get('password','');

			try {

				Users::makeLogin($username,$password);

				return json_encode(array('error'=>'no','loggedin'=>'yes'));

			} catch (Exception $e) {

				throw new Exception($e->getMessage());
			}
			
			break;
		case 'register':

			try {

				$id=Users::makeRegister();

				return json_encode(array('error'=>'no','userid'=>$id));

			} catch (Exception $e) {

				throw new Exception($e->getMessage());

			}
			
			break;

		case 'verify_forgotpassword':

			$code=Request::get('verify_code','');

			if($code=='')
			{
				throw new Exception("Error Processing Request");
			}

			$loadData=Users::get(array(
				'where'=>"where forgot_code='$code'"
				));

			if(isset($loadData[0]['userid']))
			{
				Users::update($loadData[0]['userid'],array(
					'forgot_code'=>''
					));

				Users::sendNewPassword($loadData[0]['email']);
			}
			else
			{
				throw new Exception("Verify code not valid.");
			}
			
			break;			

	}	
}

?>