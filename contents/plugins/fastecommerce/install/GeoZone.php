<?php

class GeoZone
{
	public static function ipInfo($inputData='')
	{
		$loadCache=self::loadCache($inputData);

		if(!$loadCache)
		{
			$url='http://ipinfo.io/'.$ip.'/json';

			$loadData=Http::getDataUrl($url);

			$result='none';

			if(!isset($loadData[10]))
			{
				$url='http://ip-api.com/json/'.$ip;

				$loadData=Http::getDataUrl($url);

				$parse=json_decode($loadData);

				if(isset($parse['countryCode']))
				{
					$result=strtolower($parse['countryCode']);
				}			
			}
			else
			{
				$parse=json_decode($loadData);

				if(isset($parse['country']))
				{
					$result=strtolower($parse['country']);
				}			
			}

			self::saveCache($ip,$result);

			return $result;			
		}
		else
		{
			return $loadCache;
		}

	}

	public static function saveCache($ip,$country)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/geozone/'.ip2long($ip).'.cache';

		File::create($savePath,$country);
	}

	public static function loadCache($ip)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/geozone/'.ip2long($ip).'.cache';

		$result=false;

		if(file_exists($savePath))
		{
			$result=trim(file_get_contents($savePath));
		}

		return $result;
	}


}