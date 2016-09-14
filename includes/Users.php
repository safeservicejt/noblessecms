<?php

class Users
{
	public static $id=0;

	public static $permissions=array();

	public static $groupid=0;

	public static function load()
	{
		$id=self::getCookieUserId();

		if((int)$id > 0)
		{
			$groupid=self::getCookieGroupId();

			self::$id=$id;

			self::$groupid=$groupid;

			$groupData=Usergroups::loadCache($groupid);

			self::$permissions=$groupData['permissions_array'];
		}
	}

	public static function get($inputData=array())
	{
		Table::setTable('users');

		Table::setFields('id,date_added,username,email,password,image,groupid,verify_code,forgot_date,verify_forgot');

		$result=Table::get($inputData,function($rows){

			$total=count($rows);

			for ($i=0; $i < $total; $i++) { 
				if(isset($rows[$i]['image']))
				{
					$rows[$i]['imageUrl']=System::getUrl().$rows[$i]['image'];
				}
			}

			return $rows;
		});

		return $result;
	}

	public static function insert($inputData=array())
	{
		Table::setTable('users');

		$result=Table::insert($inputData,function($insertData){
			if(!isset($insertData['date_added']))
			{
				$insertData['date_added']=date('Y-m-d H:i:s');
			}

			return $insertData;
		});

		Plugins::load('after_insert_user');

		return $result;
	}

	public static function update($listID,$updateData=array(),$beforeUpdate='')
	{
		Table::setTable('users');

		$result=Table::update($listID,$updateData,$beforeUpdate);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('users');

		$result=Table::remove($inputIDs,$whereQuery);

		Plugins::load('after_remove_user');

		return $result;
	}

	public static function logout()
	{
		Cookie::destroy('userid');

		Cookie::destroy('groupid');

		Cookie::destroy('username');

		Cookie::destroy('password');

		// unset($_SESSION['groupid'], $_SESSION['userid']);

		return true;

	}
	
	public static function up($keyName='',$total=1,$addWhere='')
	{
		Table::setTable('users');

		Table::up($keyName,$total,$addWhere);
	}


	public static function down($keyName='',$total=1,$addWhere='')
	{
		Table::setTable('users');

		Table::down($keyName,$total,$addWhere);
	}


	public static function exists($id)
	{
		Table::setTable('users');

		$result=Table::exists($id);

		return $result;
	}

	public static function loadCache($id)
	{
		Table::setTable('users');

		$result=Table::loadCache($id,function($id){
			Users::saveCache($id);
		});

		return $result;
	}

	public static function removeCache($id)
	{
		Table::setTable('users');

		Table::removeCache($id);

	}


	public static function saveCache($id,$inputData=array())
	{
		if((int)$id==0)
		{
			return false;
		}

		$savePath=ROOT_PATH.'caches/system/users/'.$id.'.cache';

		$loadData=array();

		if(isset($inputData['id']))
		{
			$loadData=array();

			$loadData[0]=$inputData;
		}
		else
		{
			$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where id='$id'"
				));	

			if(!isset($loadData[0]['id']))
			{
				return false;
			}

			$loadAddress=Address::get(array(
				'cache'=>'no',
				'where'=>"where userid='$id'"
				));	

			$loadGroup=Usergroups::get(array(
				'cache'=>'no',
				'where'=>"where id='".$loadData[0]['groupid']."'"
				));	

			if($loadAddress[0]['userid'])
			{
				$loadData[0]=array_merge($loadData[0],$loadAddress[0]);
			}

			if($loadGroup[0]['id'])
			{
				$loadData[0]['group_title']=$loadGroup[0]['title'];
			}

		}

		if(isset($loadData[0]['id']))
		{
			File::create($savePath,serialize($loadData[0]));
		}
		
	}


	public static function forgotPassword($email)
	{
		$email=trim($email);

		$validtime=date('Y-m-d');

		$loadUser=self::get(array(
			'where'=>"where email='$email'"
			));

		if(!isset($loadUser[0]['id']))
		{
			throw new Exception("Email not exists in database");
		}


		$checkDate=self::get(array(
			'where'=>"where DATE(forgot_date)='$validtime'"
			));		

		if(isset($checkDate[0]['id']))
		{
			throw new Exception("We have been send email for verify to your email ".$email.' .Check your inbox/spam page. Thanks!');
		}

		$loadAddress=Address::get(array(
			'cache'=>'no',
			'where'=>"where userid='".$loadUser[0]['id']."'"
			));

		$verifyCode=String::randText(10);

		self::update($loadUser[0]['id'],array(
			'forgot_code'=>$verifyCode
			));

		$codeUrl=System::getUrl().'api/user/verify_forgotpassword?verify_code='.$verifyCode;

		$replaces=array(
			'{username}'=>$loadUser[0]['username'],
			'{email}'=>$loadUser[0]['email'],
			'{firstname}'=>$loadAddress[0]['firstname'],
			'{lastname}'=>$loadAddress[0]['lastname'],
			'{fullname}'=>$loadAddress[0]['firstname'].' '.$loadAddress[0]['lastname'],
			'{verify_url}'=>$verifyCode
			);

		$subject=System::getMailSetting('forgotSubject');
		
		$content=System::getMailSetting('forgotContent');

		$listKeys=array_keys($replaces);

		$listValues=array_values($replaces);

		$content=str_replace($listKeys, $listValues, $content);
		$subject=str_replace($listKeys, $listValues, $subject);

		try {
			Mail::send(array(
			'toEmail'=>$email,
			'toName'=>$loadUser[0]['username'],
			'subject'=>$subject,
			'body'=>$content
			));
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
			
		}
	}

	public static function newRegister($inputData=array())
	{
		$fullname=isset($inputData['firstname'])?$inputData['firstname'].' '.$inputData['lastname']:$inputData['fullname'];

		$replaces=array(
			'{fullname}'=>$fullname,
			'{username}'=>$inputData['username'],
			'{password}'=>$inputData['password'],
			'{email}'=>$inputData['email']
			);

		$subject='';

		$content='';

		$is_verify=isset(System::$setting['register_verify_email'])?System::$setting['register_verify_email']:'disable';

		if($is_verify=='enable')
		{
			// $replaces['{verify_code}']=$inputData['verify_code'];

			$replaces['{verify_code}']=System::getUrl().'api/user/verify_email?verify_code='.$inputData['verify_code'];

			$subject=System::getMailSetting('registerConfirmSubject');

			$content=System::getMailSetting('registerConfirmContent');

		}
		else
		{
			$subject=System::getMailSetting('registerSubject');

			$content=System::getMailSetting('registerContent');

		}

		$listKeys=array_keys($replaces);

		$listValues=array_values($replaces);

		$content=str_replace($listKeys, $listValues, $content);
		
		$subject=str_replace($listKeys, $listValues, $subject);

		try {
			Mail::send(array(
			'toEmail'=>$inputData['email'],
			'toName'=>$inputData['username'],
			'subject'=>$subject,
			'body'=>$content
			));
		} catch (Exception $e) {
			// throw new Exception('We can not send email confirmation to your email: '.$inputData['email']);
			Logs::insert(array(
				'content'=>'Failed sent email "'.$subject.'" to '.$inputData['email']
				));				
		}
	}

	public static function sendNewPassword($email)
	{
		$email=trim($email);

		$loadUser=self::get(array(
			'where'=>"where email='$email'"
			));

		if(!isset($loadUser[0]['id']))
		{
			throw new Exception("Email not exists in database");
			
		}

		$loadAddress=Address::get(array(
			'cache'=>'no',
			'where'=>"where userid='".$loadUser[0]['id']."'"
			));
		
		$newPass=String::randText(10);

		self::update($loadUser[0]['id'],array(
			'password'=>String::encrypt($newPass)
			));

		// $codeUrl=System::getUrl().'api/user/verify_forgotpassword?verify_code='.$verifyCode;

		$replaces=array(
			'{username}'=>$loadUser[0]['username'],
			'{email}'=>$loadUser[0]['email'],
			'{firstname}'=>$loadAddress[0]['firstname'],
			'{lastname}'=>$loadAddress[0]['lastname'],
			'{fullname}'=>$loadAddress[0]['firstname'].' '.$loadAddress[0]['lastname'],
			'{password}'=>$newPass,
			'{siteurl}'=>System::getUrl(),
			'{site_url}'=>System::getUrl()
			);

		$parse=parse_url(System::getUrl());


		$subject=System::getMailSetting('forgotNewPasswordSubject');

		$content=System::getMailSetting('forgotNewPasswordContent');

		$listKeys=array_keys($replaces);

		$listValues=array_values($replaces);

		$content=str_replace($listKeys, $listValues, $content);

		$subject=str_replace($listKeys, $listValues, $subject);

		try {
			Mail::send(array(
			'toEmail'=>$email,
			'toName'=>$loadUser[0]['username'],
			'subject'=>$subject,
			'content'=>$content

			));
		} catch (Exception $e) {
			// throw new Exception($e->getMessage());
			Logs::insert(array(
				'content'=>'Failed sent email "'.$subject.'" to '.$email
				));					
		}
	}

	public static function hasLogin()
	{
		$userid=self::getCookieUserId();

		$userid=((int)$userid > 0)?true:false;

		if(!$userid)
		{
			return false;
		}

		return true;
	}

	public static function makeRegister($inputData=array())
	{
		$groupid=System::$setting['default_member_groupid'];

		if((int)$groupid==0)
		{
			$groupid=2;
		}

		$insertData=array(
			'email'=>$inputData['email'],
			'firstname'=>$inputData['firstname'],
			'lastname'=>$inputData['lastname'],
			'username'=>$inputData['username'],
			'password'=>$inputData['password'],
			'groupid'=>$groupid,
			'email'=>$inputData['email'],
			);

		$insertData['password']=String::encrypt($insertData['password']);

		$is_verify=isset(System::$setting['register_verify_email'])?System::$setting['register_verify_email']:'disable';

		if($is_verify=='enable')
		{
			$insertData['verify_code']=String::randText(12);
			$inputData['verify_code']=$insertData['verify_code'];
		}

		if(!$id=Users::insert($insertData))
		{
			throw new Exception(Database::$error);
		}	


		Users::update(array($id),array(
			'groupid'=>$groupid
			));

		$addData=array(
			'firstname'=>trim($insertData['firstname']),
			'lastname'=>trim($insertData['lastname']),
			'userid'=>$id
			);

		$addData['address_1']=isset($inputData['address_1'])?$inputData['address_1']:'';

		$addData['address_2']=isset($inputData['address_2'])?$inputData['address_2']:'';

		$addData['city']=isset($inputData['city'])?$inputData['city']:'';

		$addData['country']=isset($inputData['country'])?$inputData['country']:'';

		$addData['state']=isset($inputData['state'])?$inputData['state']:'';

		$addData['postcode']=isset($inputData['postcode'])?$inputData['postcode']:'';

		$addData['phone']=isset($inputData['phone'])?$inputData['phone']:'';

		Address::insert($addData);

		self::saveCache($id);

		try {
			self::newRegister($inputData);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
			
		}

		return $id;

	}


	public static function makeLogin($username,$password)
	{
		$_REQUEST['username']=$username;

		$_REQUEST['password']=$password;

		$valid=Validator::make(array(
			'username'=>'min:3|max:30|slashes',
			'password'=>'min:3|max:30|slashes'
			));

		if(!$valid)
		{
			throw new Exception("Check your login infomartion again, pls!");
			
		}

		$encryptPassword=String::encrypt($password);

		$must_verify=isset(System::$setting['register_verify_email'])?System::$setting['register_verify_email']:'disable';


		$getData=self::get(array(
			'cache'=>'no',
			'where'=>"where (username='$username' OR email='$username') AND password='$encryptPassword'"
			));

		if(!isset($getData[0]['id']))
		{
			throw new Exception("User not exists in system.");
			
		}

		if($must_verify=='enable')
		{
			$verify_code=$getData[0]['verify_code'];

			if(isset($verify_code[4]))
			{
				throw new Exception("Your email not confirmed. You have to confirm your email, check your inbox/spam.");
				
			}
		}

		Cookie::make('userid',String::encrypt($getData[0]['id']),1440*7);

		Cookie::make('groupid',String::encrypt($getData[0]['groupid']),1440*7);

		Cookie::make('username',$username,1440*7);

		Cookie::make('password',$encryptPassword,1440*7);

		// Session::make('groupid',$getData[0]['groupid']);

		// Session::make('userid',$getData[0]['userid']);

	}

	public static function getCookieUserId()
	{
		if(!isset($_COOKIE['userid']))
		{
			return false;
		}

		$userid=0;

		if((int)self::$id==0)
		{
			$userid=isset($_COOKIE['userid'])?$_COOKIE['userid']:0;

			$userid=String::decrypt($userid);

			if((int)$userid <= 0)
			{
				return false;
			}

			preg_match('/(\d+)/i', $userid,$match);

			self::$id=$match[1];			
		}
		else
		{
			$userid=self::$id;
		}

		return $userid;
	}

	public static function getCookieGroupId()
	{
		if(!isset($_COOKIE['groupid']))
		{
			return false;
		}

		$groupid=0;

		if((int)self::$groupid==0)
		{
			$groupid=isset($_COOKIE['groupid'])?$_COOKIE['groupid']:0;

			$groupid=String::decrypt($groupid);

			if((int)$groupid <= 0)
			{
				return false;
			}

			preg_match('/(\d+)/i', $groupid,$match);

			self::$groupid=$match[1];			
		}

		$groupid=self::$groupid;

		return $groupid;
	}	
}