<?php

class Payments
{

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

		$field="id,foldername,title,status".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by id desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;
		
		$command="select $selectFields from ".$prefix."payment_methods $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache
			$loadCache=Cache::loadKey('dbcache/system/payment_methods/'.$md5Query,$cacheTime);

			if($loadCache!=false)
			{
				$loadCache=unserialize($loadCache);
				return $loadCache;
			}

			// end load			
		}



		$query=Database::query($queryCMD);
		

		if(isset(Database::$error[5]))
		{
			return false;
		}

		$inputData['isHook']=isset($inputData['isHook'])?$inputData['isHook']:'yes';
	

		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
			
									
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		// Save dbcache
		Cache::saveKey('dbcache/system/payment_methods/'.$md5Query,serialize($result));

		// end save


		return $result;
		
	}
	
	public static function callProcess($method='paypal',$funcName='required_form',$inputData=array())
	{
		$savePath=ROOT_PATH.'contents/plugins/fastecommerce/paymentmethods/'.$method.'/payment_process.php';

		$result='';

		if(file_exists($savePath))
		{
			include($savePath);

			if(function_exists($funcName))
			{
				try {
					$result=$funcName($inputData);
				} catch (Exception $e) {
					throw new Exception($e->getMessage());
				}				
			}
			else
			{
				throw new Exception('This payment method not support process.');
			}

		}
		else
		{
			throw new Exception('This payment method not support process.');
		}

		return $result;
	}

	public static function exists($foldername)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/paymentmethod/'.$foldername.'.cache';

		if(!file_exists($savePath))
		{
			return false;
		}

		return true;		
	}

	public static function removeCache($listFoldername=array())
	{
		$listFoldername=!is_array($listFoldername)?array($listFoldername):$listFoldername;

		$total=count($listFoldername);

		for ($i=0; $i < $total; $i++) { 
			$foldername=$listFoldername[$i];

			$savePath=ROOT_PATH.'contents/fastecommerce/paymentmethod/'.$foldername.'.cache';

			if(file_exists($savePath))
			{
				unlink($savePath);
			}

		}
	}

	public static function loadCache($foldername)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/paymentmethod/'.$foldername.'.cache';

		if(!file_exists($savePath))
		{
			return false;
		}

		$loadData=unserialize(file_get_contents($savePath));

		return $loadData;

	}

	public static function getFromCache()
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/paymentmethod/listAll.cache';

		$result=false;

		$loadData=array();

		if(file_exists($savePath))
		{
			$result=unserialize(file_get_contents($savePath));
		}

		return $result;
	}

	public static function saveToCache()
	{
		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where status='1'"
			));

		$savePath=ROOT_PATH.'contents/fastecommerce/paymentmethod/listAll.cache';

		if(isset($loadData[0]['id']))
		{
			File::create($savePath,serialize($loadData));
		}
	}

	public static function saveCache($foldername,$inputData=array())
	{

		$savePath=ROOT_PATH.'contents/fastecommerce/paymentmethod/'.$foldername.'.cache';

		if(isset($inputData['foldername']))
		{
			$loadData=array();

			$loadData[0]=$inputData;
		}
		else
		{
			$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where foldername='$foldername'"
				));			
		}

		if(isset($loadData[0]['foldername']))
		{
			File::create($savePath,serialize($loadData[0]));
		}
		
	}

	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);
		CustomPlugins::load('before_payment_method_insert',$inputData);

		$addMultiAgrs='';

		

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";	

		$addMultiAgrs="($insertValues)";	

		Database::query("insert into ".Database::getPrefix()."payment_methods($insertKeys) values".$addMultiAgrs);

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['id']=$id;

			CustomPlugins::load('after_payment_method_insert',$inputData);

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

		CustomPlugins::load('before_payment_method_remove',$post);

		$whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from ".Database::getPrefix()."payment_methods where $whereQuery $addWhere";


		$result=array();


		Database::query($command);	

		CustomPlugins::load('after_payment_method_remove',$post);

		// DBCache::removeDir('system/post');

		// DBCache::removeCache($listID,'system/post');

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

		CustomPlugins::load('before_payment_method_update',$listID);
				
		$keyNames=array_keys($post);

		$total=count($post);

		$setUpdates='';

		for($i=0;$i<$total;$i++)
		{
			$keyName=$keyNames[$i];
			$setUpdates.="$keyName='$post[$keyName]', ";
		}

		$setUpdates=substr($setUpdates,0,strlen($setUpdates)-2);
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update ".Database::getPrefix()."payment_methods set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/post');

		// DBCache::removeCache($listIDs,'system/post');



		if(!$error=Database::hasError())
		{
			// self::saveCache();
			CustomPlugins::load('after_payment_method_update',$listID);

			return true;
		}

		return false;
	}

	public static function paymentProcess($paymentMethod='paypal',$funcCall='')
	{
		if(!isset($paymentMethod[2]) || !isset($funcCall[2]))
		{
			throw new Exception('Payment method data not valid.');
		}

		$paymentPath=ROOT_PATH.'contents/plugins/fastecommerce/paymentmethods/'.$paymentMethod.'/';

		if(!file_exists($paymentPath.'payment_process.php'))
		{
			throw new Exception('This payment method not exists in our system.');
			
		}

		$result='';

		include($paymentPath.'payment_process.php');

		if(function_exists($funcCall))
		{
			try {
				$result=$funcCall();
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		return $result;
	}

	public static function route()
	{
		if($match=Uri::match('paymentapi\/(\w+)'))
		{

			$paymentMethod=$match[1];

			if(!$matchRoute=Uri::match('\/paymentapi\/(\w+)\/(\w+)'))
			{
				self::showError('Payment route not valid.');
			}

			$routeCall=$matchRoute[2];

			$paymentPath=ROOT_PATH.'contents/plugins/fastecommerce/paymentmethods/'.$paymentMethod.'/';

			if(!is_dir($paymentPath))
			{
				self::showError('This payment method not exists.');
			}

			if(!file_exists($paymentPath.'api.php'))
			{
				self::showError('This payment method not support api.');
			}

			include($paymentPath.'api.php');

			$listRoute=SelfApi::route();

			if(!isset($listRoute[$routeCall]))
			{
				self::showError('This payment method not support method: '.$routeCall);
			}

			$func=$listRoute[$routeCall];

			try {
				SelfApi::$func();
			} catch (Exception $e) {
				self::showError($e->getMessage());
			}

			$result=array('error'=>'no','message'=>'Success');

			echo json_encode($result);

			die();

		}	
	}

	public static function showError($message='')
	{
		$result=array('error'=>'yes','message'=>$message);

		echo json_encode($result);

		die();
	}



	public static function saveSetting($keyName='paypal',$inputData=array())
	{
		$data=self::getSetting();

		$keyNames=array_keys($inputData);

		$total=count($inputData);

		for ($i=0; $i < $total; $i++) { 
			$keyName=$keyNames[$i];

			$data[$keyName]=$inputData[$keyName];
			
			self::$setting[$keyName]=$inputData[$keyName];

		}
		
		self::saveSettingData($keyName,$data);

	}

	public static function removeSetting($keyName,$inputData=array())
	{
		$data=self::getSetting();

		$total=count($inputData);

		for ($i=0; $i < $total; $i++) { 
			$keyName=$inputData[$i];

			unset($data[$keyName]);

		}

		self::saveSettingData($data);
		
	}

	public static function saveSettingData($keyName,$inputData=array())
	{
		File::create(ROOT_PATH.'contents/fastecommerce/paymentmethod/'.$keyName.'_setting.cache',String::encrypt(base64_encode(serialize($inputData))));

	}

	public static function getSetting($method='paypal',$keyName='',$keyValue='')
	{	

		$data=array();

		if(!isset(self::$setting['store_name']))
		{

			$fileName=ROOT_PATH.'contents/fastecommerce/paymentmethod/'.$method.'_setting.cache';

			if(!file_exists($fileName))
			{
				$data=self::makeSetting();

			}
			else
			{
				$data=file_get_contents($fileName);

				if(isset($data[2]))
				$data=unserialize(base64_decode(String::decrypt($data)));

			}


			self::$setting=$data;
		}
		else
		{
			$data=self::$setting;
		}

		if(!isset($keyName[1]))
		{
			return $data;
		}
		else
		{
			$keyValue=false;

			$keyValue=isset($data[$keyName])?$data[$keyName]:$keyValue;

			return $keyValue;

		}



	}

}