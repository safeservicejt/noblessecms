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


	
	public function removeCache($listID,$addPath='')
	{
		// $cachePath='dbcache/'.$addPath.'/'.$keyName;

		if(!is_array($listID))
		{
			if(preg_match_all('/(\d+)/i', $listID, $matches))
			{
				$listID=$matches[1];
			}
		}

		$total=count($listID);


		if((int)$total > 0)
		{
			for ($i=0; $i < $total; $i++) { 
				$id=$listID[$i];

				$loadPath=CACHES_PATH.'dbcache/'.$addPath.'/'.$id.'_*';

				$result=glob($loadPath);

				if(isset($result[0]))
				{
					$totalFile=count($result);

					for ($j=0; $j < $totalFile; $j++) { 

						$singlePath=$result[$j];

						if(preg_match('/((.*?\/)\d+\_(.*?\.cache))/i', $singlePath,$matchPath))
						{
							$dataPath=$matchPath[2].$matchPath[3];

							if(file_exists($dataPath))
							{
								unlink($dataPath);
							}
						}

						unlink($result[$j]);
					}
				}

			}
		}
	}

	public function makeIDCache($keyName,$inputData=array(),$fieldName,$addPath='')
	{
		if(self::$enable=='no')
		{
			return false;
		}

		$savePath='dbcache/'.$addPath.'/'.$keyName;

		if(isset($inputData[0][$fieldName]))
		{
			$total=count($inputData);

			for ($i=0; $i < $total; $i++) { 
				$id=$inputData[$i][$fieldName];

				$savePath='dbcache/'.$addPath.'/'.$id.'_'.$keyName;

				Cache::saveKey($savePath,'');
			}
		}

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