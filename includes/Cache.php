<?php

class Cache
{
	public static function make($keyName='',$keyVal='')
	{
		$savePath=ROOT_PATH.'caches/datacache/'.$keyName;

		File::create($savePath.'.cache',$keyVal);

		File::create($savePath.'_time.cache',time());
	}

	public static function remove($keyName='')
	{
		$savePath=ROOT_PATH.'caches/datacache/'.$keyName.'.cache';

		if(file_exists($savePath))
		{
			unlink($savePath);
		}
	}

	public static function get($keyName,$ttL=86400)
	{
		$savePath=ROOT_PATH.'caches/datacache/'.$keyName;

		$filePath=$savePath.'.cache';

		$timePath=$savePath.'_time.cache';

		$result=false;

		if(file_exists($filePath))
		{
			$loadTime=(int)file_get_contents($timePath);

			$thisTime=time();

			$cal=$thisTime-$loadTime;

			$result=((int)$cal <= (int)$ttL)?file_get_contents($filePath):false;
		}

		return $result;

	}
}