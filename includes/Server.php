<?php

class Server
{

	public function getStartTime()
	{
		$data=GlobalCMS::$load['start_time'];
		
		return $data;
	}
	
	public function releaseTTL()
	{
		$_SESSION['start_time']=time();
		
		return $data;
	}

	public function getTTL()
	{
		$start_time=GlobalCMS::$load['start_time'];

		$this_time=time();

		$ttl=(int)$this_time-(int)$start_time;

		return $ttl;
	}

	public function getSetting()
	{
		$path=ROOT_PATH.'uploads/setting.data';

		$dataLoad=file_get_contents($path);

		$dataLoad=json_decode($dataLoad,true);

		return $dataLoad;
	}

	public function getDate($str="Y-m-d h:i:s")
	{
		$data=date($str);

		return $data;
	}

	public function formatDate($time,$str="M d, Y")
	{
		$data=date($str,$time);		

		return $data;
	}



}

?>