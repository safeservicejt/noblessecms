<?php

function loadApi($action)
{
	switch ($action) {

		case 'install':

			if(!isset($_SESSION['groupid']))
			{
				throw new Exception("Error Processing Request");
			}

			$url=Request::get('send_url','');
			$send_method=Request::get('send_method','plugin');



			if(!isset($url[4]))
			{
				throw new Exception("Error Processing Request");
			}

			$path='contents/plugins/';

			if($send_method=='template')
			{
				$path='contents/themes/';
			}

			File::downloadModule($url,$path,'yes');

			$fileName=basename($url);

			preg_match('/^(.*?)\.\w+$/i', $fileName,$match);

			$filePath=ROOT_PATH.$path.$match[1];

			if(is_dir($filePath))
			{
				rmdir($filePath);
			}

			break;

		case 'load':

			$queryData=array(
				'send_catid'=>Request::get('send_catid',0),
				'is_filter'=>Request::get('is_filter','no'),
				'send_keyword'=>Request::get('send_keyword',''),
				'send_page'=>Request::get('send_page',0),
				'send_limitshow'=>Request::get('send_limitshow',20),
				'send_method'=>Request::get('send_method','plugin'),
				'send_showtype'=>Request::get('send_showtype','lastest')
				);

			$loadData=PluginStoreApi::get($queryData);

			$loadData=json_decode($loadData,true);

			if($loadData['error']=='yes')
			{
				throw new Exception($loadData['message']);
			}

			return $loadData['data'];

			break;

		case 'loadhtml':

			$queryData=array(
				'send_catid'=>Request::get('send_catid',0),
				'is_filter'=>Request::get('is_filter','no'),
				'send_keyword'=>Request::get('send_keyword',''),
				'send_page'=>Request::get('send_page',0),
				'send_limitshow'=>Request::get('send_limitshow',20),
				'send_method'=>Request::get('send_method','plugin'),
				'send_showtype'=>Request::get('send_showtype','lastest')
				);

			$loadData=PluginStoreApi::getHTML($queryData);

			return $loadData;

			break;



	}	
}

?>