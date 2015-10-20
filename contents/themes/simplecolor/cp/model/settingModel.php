<?php

function settingProcess()
{

	$send=Request::get('send');

	saveSetting($send);

}


function saveSetting($inputData=array())
{
	$total=count($inputData);

	if((int)$total > 0)
	{	
		$loadData=array();

		if($loadData=Cache::loadKey('dbcache/'.Database::getPrefix().'simplecolor',-1))
		{
			$loadData=unserialize($loadData);
		}

		$listKeys=array_keys($inputData);

		for ($i=0; $i < $total; $i++) { 
			$theKey=$listKeys[$i];

			$loadData[$theKey]=$inputData[$theKey];
		}

		$loadData=serialize($loadData);

		Cache::saveKey('dbcache/'.Database::getPrefix().'simplecolor',$loadData);
	}

}

function loadSetting()
{
	$default=array(
		'facebook_app_id'=>'',
		'site_name'=>'Your site name'
		);

	if(!$loadData=Cache::loadKey('dbcache/'.Database::getPrefix().'simplecolor',-1))
	{
		return $default;
	}

	$loadData=unserialize($loadData);

	$loadData['facebook_app_id']=isset($loadData['facebook_app_id'])?$loadData['facebook_app_id']:'675779382554952';

	$loadData['site_name']=isset($loadData['site_name'])?$loadData['site_name']:'Your site name';

	return $loadData;
}

?>