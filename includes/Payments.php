<?php

class Payments
{
	public static function get($inputData=array())
	{
		Table::setTable('payment_methods');

		Table::setFields('id,foldername,title,status');

		$result=Table::get($inputData);

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
		Table::setTable('payment_methods');

		$result=Table::insert($inputData);

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('payment_methods');

		$result=Table::update($listID,$updateData);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('payment_methods');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
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