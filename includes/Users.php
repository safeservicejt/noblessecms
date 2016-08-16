<?php


/*

$userid=Users::getCookieUserId();

$groupid=Users::getCookieGroupId();

*/
class Users
{
	public static $config=array();

	public static $userid=0;

	public static $groupid=0;

	public static function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$moreFields=isset($inputData['moreFields'])?','.$inputData['moreFields']:'';

		$field="userid,groupid,username,firstname,lastname,image,email,password,userdata,ip,verify_code,parentid,date_added,forgot_code,forgot_date".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();

		$prefix='';

		$prefixall=Database::isPrefixAll();

		if($prefixall!=false || $prefixall=='no')
		{
			$prefix=Database::getPrefix();
		}

		$command="select $selectFields from ".$prefix."users $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);
		
		if($cache=='yes')
		{
			// Load dbcache

			

			$loadCache=Cache::loadKey('dbcache/system/user/'.$md5Query,$cacheTime);

			if($loadCache!=false)
			{
				$loadCache=unserialize($loadCache);
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
		Cache::saveKey('dbcache/system/user/'.$md5Query,serialize($result));
		// end save


		return $result;
		
	}

	public static function api($action)
	{
		Model::load('api/user');

		try {
			$result=loadApi($action);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

		return $result;
	}	

	public static function configPath()
	{
		$result=ROOT_PATH.'contents/users/';

		if(!is_dir($result))
		{
			Dir::create($result);
		}

		return $result;
	}

	public static function checkConfig()
	{
		if(!isset($_COOKIE['groupid']) || !isset($_COOKIE['username']))
		{
			return false;
		}

		$username=Cookie::get('username');

		$loadPath=self::configPath().$username.'/config.cache';

		if(!file_exists($loadPath))
		{
			return false;
		}

		$loadData=unserialize(file_get_contents($loadPath));

		self::$config=$loadData;

	}

	public static function loadConfig($method='before_load_database')
	{
		if(!isset(self::$config[$method]))
		{
			return false;
		}

		$value=self::$config[$method];

		return $value;
	}

	public static function checkUseTheme()
	{
		if(!isset(self::$config['theme']))
		{
			return false;
		}		

		$theme=self::$config['theme'];

		System::setTheme($theme,'yes');
	}

	public static function checkConnectDB()
	{
        // global $db;

		if(!isset(self::$config['dbhost']))
		{
			return false;
		}

		$dbhost=self::$config['dbhost'];

		if(!isset($dbhost[2]))
		{
			return false;
		}

		$prefix=isset(self::$config['prefix'])?self::$config['prefix']:'';

		Database::setPrefix($prefix);

		Database::setPrefixAll();

		$dbtype=self::$config['dbtype'];

		$dbport=self::$config['dbport'];

		$dbuser=self::$config['dbuser'];

		$dbpassword=self::$config['dbpassword'];

		$dbname=self::$config['dbname'];

		$GLOBALS['db']['default']['dbhost']=$dbhost;

		$GLOBALS['db']['default']['dbtype']=$dbtype;

		$GLOBALS['db']['default']['dbport']=$dbport;

		$GLOBALS['db']['default']['dbuser']=$dbuser;

		$GLOBALS['db']['default']['dbpassword']=$dbpassword;

		$GLOBALS['db']['default']['dbname']=$dbname;

	}

	public static function getAvatar($row)
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

		$img=System::getUrl().$img;

		return $img;
	}


	public static function removeCache($listID=array())
	{
		$listID=!is_array($listID)?array($listID):$listID;

		$total=count($listID);

		for ($i=0; $i < $total; $i++) { 
			$id=$listID[$i];

			$savePath=ROOT_PATH.'contents/fastecommerce/product/'.$id.'.cache';

			if(file_exists($savePath))
			{
				unlink($savePath);
			}

		}
	}

	public static function exists($id)
	{
		$savePath=ROOT_PATH.'contents/userscache/'.$id.'.cache';

		if(!file_exists($savePath))
		{
			return false;			
		}

		return true;
	}

	public static function loadCache($id)
	{
		$savePath=ROOT_PATH.'contents/userscache/'.$id.'.cache';

		if(!file_exists($savePath))
		{
			self::saveCache($id);

			if(!file_exists($savePath))
			{
				return false;
			}			
		}

		$loadData=unserialize(file_get_contents($savePath));

		return $loadData;

	}

	public static function saveCache($id,$inputData=array())
	{
		if((int)$id==0)
		{
			return false;
		}

		$savePath=ROOT_PATH.'contents/userscache/'.$id.'.cache';

		if(isset($inputData['userid']))
		{
			$loadData=array();

			$loadData[0]=$inputData;
		}
		else
		{
			$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where userid='$id'"
				));	

			$loadAddress=Address::get(array(
				'cache'=>'no',
				'where'=>"where userid='$id'"
				));	

			if($loadAddress[0]['userid'])
			{
				$loadData[0]=array_merge($loadData[0],$loadAddress[0]);
			}
		}

		if(isset($loadData[0]['userid']))
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

		$codeUrl=System::getUrl().'api/user/verify_forgotpassword?verify_code='.$verifyCode;

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

		if(!isset($loadUser[0]['userid']))
		{
			throw new Exception("Email not exists in database");
			
		}

		$newPass=String::randText(10);

		self::update($loadUser[0]['userid'],array(
			'password'=>String::encrypt($newPass)
			));

		// $codeUrl=System::getUrl().'api/user/verify_forgotpassword?verify_code='.$verifyCode;

		$replaces=array(
			'{username}'=>$loadUser[0]['username'],
			'{email}'=>$loadUser[0]['email'],
			'{firstname}'=>$loadUser[0]['firstname'],
			'{lastname}'=>$loadUser[0]['lastname'],
			'{fullname}'=>$loadUser[0]['firstname'].' '.$loadUser[0]['lastname'],
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

	public static function getCookieUserId()
	{
		if(!isset($_COOKIE['userid']))
		{
			return false;
		}

		$userid=0;

		if((int)self::$userid==0)
		{
			$userid=isset($_COOKIE['userid'])?$_COOKIE['userid']:0;

			$userid=String::decrypt($userid);

			if((int)$userid <= 0)
			{
				return false;
			}

			preg_match('/(\d+)/i', $userid,$match);

			self::$userid=$match[1];			
		}
		else
		{
			$userid=self::$userid;
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



	public static function hasLogin()
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

	public static function logout()
	{
		Cookie::destroy('userid');

		Cookie::destroy('groupid');

		Cookie::destroy('username');

		Cookie::destroy('password');

		// unset($_SESSION['groupid'], $_SESSION['userid']);

		return true;

	}

	public static function changePassword($userid,$newPassword='')
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

	public static function makeBannedUserID($userid)
	{
		$groupid=System::$setting['default_member_banned_groupid'];

		if((int)$groupid==0)
		{
			$groupid=5;
		}

		$listID="";

		if(is_array($userid))
		{	
			$listID="'".implode("','", $userid)."'";
		}
		else
		{
			$listID="'$userid'";

		}

		Users::update($userid,array(
			'groupid'=>$groupid
			),"userid IN ($listID)");

	}

	public static function upBalance($userid,$money)
	{
		$prefix='';

		$prefixall=Database::isPrefixAll();

		if($prefixall!=false || $prefixall=='no')
		{
			$prefix=Database::getPrefix();
		}

		Database::query("update ".$prefix."users set balance=balance+$money where userid='$userid'");
	}

	public static function downBalance($userid,$money)
	{
		$prefix='';

		$prefixall=Database::isPrefixAll();

		if($prefixall!=false || $prefixall=='no')
		{
			$prefix=Database::getPrefix();
		}

		Database::query("update ".$prefix."users set balance=balance-$money where userid='$userid'");
	}



	public static function changeGroup($userid,$groupid)
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

	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);

		$addMultiAgrs='';

		if(isset($inputData[0]['username']))
		{
		    foreach ($inputData as $theRow) {

				$theRow['date_added']=date('Y-m-d H:i:s');

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
			$inputData['date_added']=date('Y-m-d H:i:s');

			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		$prefix='';

		$prefixall=Database::isPrefixAll();

		if($prefixall!=false || $prefixall=='no')
		{
			$prefix=Database::getPrefix();
		}

		Database::query("insert into ".$prefix."users($insertKeys) values".$addMultiAgrs);

		// DBCache::removeDir('system/user');

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['id']=$id;
			
			CustomPlugins::load('after_insert_user',$inputData);

			return $id;	
		}

		return false;
	
	}

	public static function remove($post=array(),$whereQuery='',$addWhere='')
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

		$prefix='';

		$prefixall=Database::isPrefixAll();

		if($prefixall!=false || $prefixall=='no')
		{
			$prefix=Database::getPrefix();
		}

		$command="delete from ".$prefix."users where $whereQuery $addWhere";

		Database::query($command);	

		Plugins::load('after_remove_user',$post);
		CustomPlugins::load('after_remove_user',$post);

		// DBCache::removeDir('system/user');
		
		// DBCache::removeCache($listID,'system/user');

		return true;
	}

	public static function update($listID,$post=array(),$whereQuery='',$addWhere='')
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
		
		$prefix='';

		$prefixall=Database::isPrefixAll();

		if($prefixall!=false || $prefixall=='no')
		{
			$prefix=Database::getPrefix();
		}

		Database::query("update ".$prefix."users set $setUpdates where $whereQuery $addWhere");


		// DBCache::removeDir('system/user');

		// DBCache::removeCache($listIDs,'system/user');

		if(!$error=Database::hasError())
		{
			Plugins::load('after_update_user',$listID);
			CustomPlugins::load('after_update_user',$listID);

			return true;
		}

		return false;
	}


}