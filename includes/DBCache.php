<?php

class DBCache
{
	private static $enable='yes';

	public function enable()
	{
		self::$enable='yes';
	}

	public function disable()
	{
		self::$enable='no';
	}



	public function get($queryStr='',$timeLive=15,$addPath='')
	{
		// die(self::$enable);
		if(self::$enable=='no' || !isset($queryStr[1]))
		{
			return false;
		}

		if(isset($addPath[1]))
		{
			$fullPath=CACHES_PATH.'dbcache/'.$addPath;

			if(!is_dir($fullPath))	
			{
				Dir::create($fullPath);
			}		
		}


		$queryStr=md5($queryStr);

		// Cache::setPath(CACHES_PATH.'dbcache/');

		if(!$loadData=Cache::loadKey('dbcache/'.$addPath.'/'.$queryStr,$timeLive))
		{
			return false;
		}

		// Cache::setPath(CACHES_PATH);

		// self::$enable='no';

		// $loadData=json_decode($loadData,true);
		$loadData=unserialize($loadData);
		// $loadData=unserialize(base64_decode($loadData));

		return $loadData;
	}

	// public function systemMake($keyName,$inputData=array(),$addPath='')
	// {
	// 	$result=self::make($keyName,$inputData=array(),'system/'.$addPath);

	// 	return $result;
	// }


	public function removeDir($path='')
	{
		$path=CACHES_PATH.'dbcache/'.$path;

		Dir::remove($path);
	}
	
	public function make($keyName,$inputData=array(),$addPath='')
	{
		if(self::$enable=='no')
		{
			return false;
		}
		
		// $inputData=base64_encode(serialize($inputData));
		$inputData=serialize($inputData);
		
		// print_r($keyName);
		// die();
		// Cache::setPath(CACHES_PATH.'dbcache/');

		Cache::saveKey('dbcache/'.$addPath.'/'.$keyName,$inputData);

		// Cache::setPath(CACHES_PATH);

		return true;
	}


}

?>