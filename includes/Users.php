<?php

class Users
{

	private static $groups=array();

	private static $isLogin='no';

	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="userid,groupid,image,firstname,lastname,balance,email,password,ip,date_added,is_affiliate,is_admin,approved,isreaded";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();
		
		$command="select $selectFields from users $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

	

		// Load dbcache

		$loadCache=DBCache::get($queryCMD);

		if($loadCache!=false)
		{
			return $loadCache;
		}

		// end load

		$query=Database::query($queryCMD);
		
		if(isset(Database::$error[5]))
		{
			return false;
		}

		// echo Database::$error;

		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				$row['date_added']=Render::dateFormat($row['date_added']);

				$row['group_title']=self::group($row['groupid']);
								
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		// Save dbcache
		DBCache::make(md5($queryCMD),$result);
		// end save

		return $result;
		
	}

	public function changePassword($userid,$newPassword)
	{
		$password=md5($newPassword);

		$isUser=self::get(array(
			'where'=>"where userid='$userid'"
			));

		if(!isset($isUser[0]['userid']))
		{
			return false;
		}

		self::update($userid,array(
			'password'=>$password
			));	

		if(isset($_SESSION['userid']))
		{
			Session::make('password',$password);
		}
			
		return true;	

	}

	public function isenable()
	{
		if((int)GlobalCMS::$setting['enable_register']==1)
		{
			return true;
		}

		return false;
	}
	
	public function isUser($email,$pword)
	{
		Request::make('email',$email);

		Request::make('password',$pword);

		$valid=Validator::make(array(
			'email'=>'email|slashes',
			'password'=>'min:5|slashes'
			));

		if(!$valid)
		{
			return false;
		}

		$password=md5($pword);

		$loadData=self::get(array(
			'where'=>"where email='$email' AND password='$password'"
			));

		if(!isset($loadData[0]['userid']))
		{
			return false;
		}

		return json_encode($loadData[0]);
	}

	public function isLogined()
	{
		if(self::$isLogin=='yes')
		{
			return true;
		}

		
		if(Cookie::has('email')==false || Cookie::has('password')==false)
		{
			return false;
		}

	    $valid=Validator::check(array(

	    Cookie::get('email')=>'email|max:150|slashes',

	    Cookie::get('password')=>'min:2|slashes',

	    Cookie::get('userid')=>'min:2|slashes'

	    ));

	    if(!$valid)
	    {
	        return false;
	    }

	    $username = Cookie::get('email');
	    $password = Cookie::get('password');

	    DBCache::disable();
	    $loadData=self::get(array(
	    	'where'=>"where email='$username' AND password='$password'"
	    	));
	    DBCache::enable();	    

	    if (!isset($loadData[0]['userid']))
	    {
	        return false;      
	    }

	    $row=$loadData[0];

	    Session::make('groupid',$row['groupid']);    

	    // Session::make('userid',$row['userid']);

	    Session::make('userid',$row['userid']);

	    self::$isLogin='yes';

		return true;
	}

	public function registerEmail()
	{
		if(Session::has('register'))
		{
			return true;
		}

		$valid=Validator::make(array(
			'send.email'=>'min:5|email|slashes'
			));

		if(!$valid)
		{
			return false;
		}

		$email=trim(Request::get('send.email'));


		$tmp=Cache::loadKey('mailSetting',-1);

		$dataSetting=json_decode($tmp,true);

		$sendMethod=$dataSetting['send_method'];

		$firstname=trim(Request::get('send.firstname'));

		$lastname=trim(Request::get('send.lastname'));

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
				'subject'=>$dataSetting['registerSubject'],
				'message'=>$dataSetting['registerContent']
				);

			if(Mail::sendMailFromLocal($post))
			{
				Session::make('register','1');
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

				'subject'=>$dataSetting['registerSubject'],
				'message'=>$dataSetting['registerContent'],

				'smtpAddress'=>$dataSetting['smtpAddress'],
				'smtpUser'=>$dataSetting['smtpUser'],
				'smtpPass'=>$dataSetting['smtpPass'],
				'smtpPort'=>$dataSetting['smtpPort']
				);

			if(Mail::sendMail($post))
			{
				Session::make('register','1');
				return true;
			}

				break;

		}



		return true;		
	}

	public function makeLogin()
	{

	    $valid=Validator::check(array(

	    Request::get('email')=>'email|max:150|slashes',

	    Request::get('password')=>'min:2|slashes'

	    ));

	    if(!$valid)
	    {
	        return false;
	    }

	    $username=Request::get('email');

	    $password=Request::get('password');
	   
	    $password = md5($password);

	    DBCache::disable();
	    $loadData=self::get(array(
	    	'where'=>"where email='$username' AND password='$password'"
	    	));
	    DBCache::enable();	    

	    if (!isset($loadData[0]['userid']))
	    {
	        return false;      
	    }

	    $row=$loadData[0];

        Cookie::make('email', $username, 8460);

        Cookie::make('password', $password, 8460);

        Session::make('groupid',$row['groupid']);

        // Session::make('userid',$row['userid']);

        Session::make('userid',$row['userid']);

        UserGroups::loadCaches();

        return true;

	}

	public function address($id)
	{
		$loadData=Address::get(array(
			'where'=>"where userid='$id'"
			));

		return $loadData[0];
	}


	public function affiliate($id)
	{
		$loadData=Affiliate::get(array(
			'where'=>"where userid='$id'"
			));

		return $loadData[0];
	}


	
	
	public function group($groupid)
	{
		if(!isset(self::$groups[1]['groupid']))
		{
			self::$groups=Usergroups::get();			
		}

		$total=count(self::$groups);

		$title='Member';

		for($i=0;$i<$total;$i++)
		{
			if($groupid==self::$groups[$i]['groupid'])
			{
				$title=self::$groups[$i]['group_title'];

				break;
			}
		}

		return $title;

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

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}
	public function insert($inputData=array())
	{

		// Addons
		if(!isset($inputData['groupid']))
		{
			$inputData['groupid']=isset(GlobalCMS::$setting['default_groupid'])?GlobalCMS::$setting['default_groupid']:'2';
		}
		// End addons

		// $inputData['nodeid']=String::genNode();
		
		$inputData['date_added']=date('Y-m-d h:i:s');

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Plugins::load('before_insert_users',$inputData);

		Database::query("insert into users($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();	

			$inputData['userid']=$id;

			Plugins::load('after_insert_users',$inputData);

			return $id;	
		}

		return false;
	
	}
	public function remove($post,$whereQuery='',$addWhere='')
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

		$command="delete from address where userid in ($listID)";

		Database::query($command);	

		$command="delete from affiliate where userid in ($listID)";

		Database::query($command);	


		return true;


	}

}

?>