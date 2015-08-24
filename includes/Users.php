<?php

class Users
{

	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="userid,groupid,username,firstname,lastname,image,email,password,userdata,ip,verify_code,parentid,date_added,forgot_code,forgot_date";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();
		
		$command="select $selectFields from users $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		if($cache=='yes')
		{
			// Load dbcache

			$loadCache=DBCache::get($queryCMD,$cacheTime,'system/user');

			if($loadCache!=false)
			{
				return $loadCache;
			}

			// end load			
		}

		// echo $queryCMD;die();


		$query=Database::query($queryCMD);
		
		if(isset(Database::$error[5]))
		{
			return false;
		}
		
		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{

				if(isset($row['date_added']))
				$row['date_addedFormat']=Render::dateFormat($row['date_added']);	

				if(isset($row['image']))
				$row['imageFormat']=self::getAvatar($row['image']);	

											
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		
		// Save dbcache
		$addPostid='';

		$saveName='';

		$saveName=md5($queryCMD);

		// if(!isset($result[1]) && isset($result[0]['userid']))
		// {
		// 	$saveName=$addPostid.'_'.md5($queryCMD);
		// }
		// else
		// {
		// 	$saveName=md5($queryCMD);
		// }

		DBCache::make($saveName,$result,'system/user');

		// DBCache::makeIDCache($saveName,$result,'userid','system/user');		
		// end save


		return $result;
		
	}

	public function api($action)
	{
		Model::load('api/users');

		try {
			$result=loadApi($action);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

		return $result;
	}	

	public function getAvatar($row)
	{
		$img='bootstrap/images/noavatar.jpg';

		if(is_array($row))
		{
			$img=isset($row['image'])?$row['image']:'';
		}


		if(!preg_match('/^.*?\.\w+$/', $img))
		{
			$img='bootstrap/images/noavatar.jpg';
		}

		$img=ROOT_URL.$img;

		return $img;
	}


	public function forgotPassword($email)
	{
		$email=trim($email);

		$validtime=date('Y-m-d');

		$loadUser=self::get(array(
			'where'=>"where email='$email'"
			));

		if(!isset($loadUser[0]['userid']))
		{
			throw new Exception("Email not exists in database");
		}


		$checkDate=self::get(array(
			'where'=>"where DATE(forgot_date)='$validtime'"
			));		

		if(isset($checkDate[0]['userid']))
		{
			throw new Exception("We have been send email for verify to your email ".$email.' .Check your inbox/spam page. Thanks!');
		}

		$verifyCode=String::randText(10);

		self::update($loadUser[0]['userid'],array(
			'forgot_code'=>$verifyCode
			));

		$codeUrl=ROOT_URL.'api/user/verify_forgotpassword?verify_code='.$verifyCode;

		$replaces=array(
			'{username}'=>$loadUser[0]['username'],
			'{email}'=>$loadUser[0]['email'],
			'{firstname}'=>$loadUser[0]['firstname'],
			'{lastname}'=>$loadUser[0]['lastname'],
			'{fullname}'=>$loadUser[0]['firstname'].' '.$loadUser[0]['lastname'],
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

	public function newRegister($inputData=array())
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

			$replaces['{verify_code}']=ROOT_URL.'api/user/verify_email?verify_code='.$inputData['verify_code'];

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
			'content'=>$content
			));
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
			
		}
	}

	public function sendNewPassword($email)
	{
		$email=trim($email);

		$loadUser=self::get(array(
			'where'=>"where email='$email'"
			));

		if(!isset($loadUser[0]['userid']))
		{
			throw new Exception("Email not exists in database");
			
		}

		$newPass=String::randText(10);

		self::update($loadUser[0]['userid'],array(
			'password'=>String::encrypt($newPass)
			));

		// $codeUrl=ROOT_URL.'api/user/verify_forgotpassword?verify_code='.$verifyCode;

		$replaces=array(
			'{username}'=>$loadUser[0]['username'],
			'{email}'=>$loadUser[0]['email'],
			'{firstname}'=>$loadUser[0]['firstname'],
			'{lastname}'=>$loadUser[0]['lastname'],
			'{fullname}'=>$loadUser[0]['firstname'].' '.$loadUser[0]['lastname'],
			'{password}'=>$newPass,
			'{siteurl}'=>ROOT_URL,
			'{site_url}'=>ROOT_URL
			);

		$parse=parse_url(ROOT_URL);


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
			'content'=>$content3

			));
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
			
		}
	}

	public function makeRegister($inputData=array())
	{
		if(!isset($_REQUEST['send']['firstname']) && isset($inputData['firstname']))
		{
			$_REQUEST['send']=$inputData;
		}

		$valid=Validator::make(array(
			'send.firstname'=>'required|min:1|max:20|slashes',
			'send.lastname'=>'required|min:1|max:20|slashes',
			'send.username'=>'required|min:1|max:30|slashes',
			'send.email'=>'required|email|max:120|slashes',
			'send.password'=>'required|min:1|max:30|slashes'
			));

		if(!$valid)
		{
			throw new Exception("Check your infomartion again: ".Validator::getMessage());
		}

		$insertData=Request::get('send');

		if(!$id=Users::insert($insertData))
		{
			throw new Exception("Check your infomartion again, pls!");
		}	

		$addData=array(
			'firstname'=>trim($insertData['firstname']),
			'lastname'=>trim($insertData['lastname']),
			'userid'=>$id
			);

		Address::insert($addData);

		try {
			self::newRegister($insertData);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
			
		}

	}

	public function makeLogin($username,$password)
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
			'where'=>"where (username='$username' OR email='$username') AND password='$encryptPassword'"
			));

		if(!isset($getData[0]['userid']))
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

		Cookie::make('userid',String::encrypt($getData[0]['userid']),1440*7);

		Cookie::make('groupid',String::encrypt($getData[0]['groupid']),1440*7);

		Cookie::make('username',$username,1440*7);

		Cookie::make('password',$encryptPassword,1440*7);

		Cookie::make('firstname',$getData[0]['firstname'],1440*7);

		Cookie::make('lastname',$getData[0]['lastname'],1440*7);

		// Session::make('groupid',$getData[0]['groupid']);

		// Session::make('userid',$getData[0]['userid']);

	}

	public function getCookieUserId()
	{
		$userid=isset($_COOKIE['userid'])?$_COOKIE['userid']:0;

		$userid=String::decrypt($userid);

		if((int)$userid <= 0)
		{
			return false;
		}

		return $userid;
	}

	public function getCookieGroupId()
	{
		$groupid=isset($_COOKIE['groupid'])?$_COOKIE['groupid']:0;

		$groupid=String::decrypt($groupid);

		if((int)$groupid <= 0)
		{
			return false;
		}

		return $groupid;
	}



	public function hasLogin()
	{
		if(!Cookie::has('username') || !Cookie::has('password') || !isset($_COOKIE['groupid']))
		{
			return false;
		}

		$username=Cookie::get('username');

		$password=Cookie::get('password');

		$userid=self::getCookieUserId();

		$groupid=self::getCookieGroupId();

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where userid='$userid' AND groupid='$groupid' AND username='$username' AND password='$password'"
			));

		if(!isset($loadData[0]['userid']))
		{
			return false;
		}

		return true;
	}

	public function logout()
	{
		Cookie::destroy('userid');

		Cookie::destroy('groupid');

		Cookie::destroy('username');

		Cookie::destroy('password');

		// unset($_SESSION['groupid'], $_SESSION['userid']);

		return true;

	}

	public function changePassword($userid,$newPassword='')
	{

		if(!isset($newPassword[1]))
		{
			return false;
		}

		$thisUserid=self::getCookieUserId();

		$encryptPassword=String::encrypt($newPassword);

		self::update($userid,array(
			'password'=>$encryptPassword
			));

		if($userid==$thisUserid)
		{
			Cookie::make('password',$encryptPassword,1440*7);
		}

	}

	public function upBalance($userid,$money)
	{
		Database::query("update users set balance=balance+$money where userid='$userid'");
	}

	public function downBalance($userid,$money)
	{
		Database::query("update users set balance=balance-$money where userid='$userid'");
	}



	public function changeGroup($userid,$groupid)
	{

		$getData=UserGroups::get(array(
			'where'=>"where groupid='$groupid'"
			));

		if(!isset($getData[0]['groupid']))
		{
			return false;
		}

		self::update($userid,array(
			'groupid'=>$groupid
			));

		return true;
	}

	public function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);

		$addMultiAgrs='';

		if(isset($inputData[0]['username']))
		{
		    foreach ($inputData as $theRow) {

				$theRow['date_added']=System::dateTime();

				$keyNames=array_keys($theRow);

				$insertKeys=implode(',', $keyNames);

				$keyValues=array_values($theRow);

				$insertValues="'".implode("','", $keyValues)."'";

				$addMultiAgrs.="($insertValues), ";

		    }

		    $addMultiAgrs=substr($addMultiAgrs, 0,strlen($addMultiAgrs)-2);
		}
		else
		{
			$inputData['date_added']=System::dateTime();

			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		Database::query("insert into users($insertKeys) values".$addMultiAgrs);

		DBCache::removeDir('system/user');

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			return $id;	
		}

		return false;
	
	}

	public function remove($post=array(),$whereQuery='',$addWhere='')
	{


		if(is_numeric($post))
		{
			$id=$post;

			unset($post);

			$post=array($id);
		}

		$total=count($post);

		$listID="'".implode("','",$post)."'";

		$whereQuery=isset($whereQuery[5])?$whereQuery:"userid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from users where $whereQuery $addWhere";

		Database::query($command);	

		// DBCache::removeDir('system/user');
		
		DBCache::removeCache($listID,'system/user');

		return true;
	}

	public function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{

		if(is_numeric($listID))
		{
			$catid=$listID;

			unset($listID);

			$listID=array($catid);
		}

		$listIDs="'".implode("','",$listID)."'";		
				
		$keyNames=array_keys($post);

		$total=count($post);

		$setUpdates='';

		for($i=0;$i<$total;$i++)
		{
			$keyName=$keyNames[$i];
			$setUpdates.="$keyName='$post[$keyName]', ";
		}

		$setUpdates=substr($setUpdates,0,strlen($setUpdates)-2);
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"userid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update users set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/user');

		DBCache::removeCache($listIDs,'system/user');

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>