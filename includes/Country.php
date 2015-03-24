<?php

class Country
{
	public static $load=array();

	public function get()
	{
		$result=Cache::loadKey('listCountries',-1);

		$result=json_decode($result,true);

		$total=count($result);

		$result[$total]['name']='Worldwide';
		$result[$total]['iso_code_2']='worldwide';

		return $result;
	}	

	public function thisIP()
	{
		$ip=$_SERVER['REMOTE_ADDR'];

		$resultData=array();

		if($ip=='127.0.0.1')
		{
			$resultData['name']='Worldwide';
			$resultData['iso_code_2']='worldwide';

			return $resultData;
		}

		$loadData=Http::getDataUrl('http://ipinfo.io/'.$ip.'/json','no');

		$loadData=json_decode($loadData,true);

		$resultData['name']=$loadData['region'];
		$resultData['iso_code_2']=$loadData['country'];

		return $resultData;
	}

}
?>