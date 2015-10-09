<?php

/*
Call: http://site.com/api/cronjob/run.php
*/

function apiProcess()
{
	if(!$match=Uri::match('^api\/(\w+)\/(\w+)'))
	{
		$result=json_encode(array('error'=>'yes','message'=>'Api not valid'));

		echo $result;

		die();
	}

	$method=strtolower($match[1]);

	$action=strtolower($match[2]);

	$result=array('error'=>'no','message'=>'');
	
	switch ($method) {
		
		case 'image':
			Model::load('api/image');

			try {
				$result['data']=loadApi($action);
			} catch (Exception $e) {
				$result=array('error'=>'yes','message'=>$e->getMessage());
			}

			break;

		case 'user':
			try {
				$result['data']=Users::api($action);
			} catch (Exception $e) {
				$result=array('error'=>'yes','message'=>$e->getMessage());
			}
			break;

		case 'category':
			try {
				$result['data']=Categories::api($action);
			} catch (Exception $e) {
				$result=array('error'=>'yes','message'=>$e->getMessage());
			}
			break;

		case 'plugin':
			try {

				$foldername=$action;

				$result['data']=PluginsApi::get($foldername);

			} catch (Exception $e) {
				$result=array('error'=>'yes','message'=>$e->getMessage());
			}
			
			break;
		case 'payment':
			try {

				$foldername=$action;

				$result['data']=PaymentApi::get($foldername);

			} catch (Exception $e) {
				$result=array('error'=>'yes','message'=>$e->getMessage());
			}

			break;
		case 'theme':
			try {

				$foldername=$action;

				$result['data']=ThemeApi::get($foldername);

			} catch (Exception $e) {
				$result=array('error'=>'yes','message'=>$e->getMessage());
			}

			break;

		case 'cronjob':

			if(!$match=Uri::match('run\.php$'))
			{
				// throw new Exception("Error Processing Request");

				$result=array('error'=>'yes','message'=>"Error Processing Request");
			}

			Cronjobs::run();

			break;
			
		case 'pluginstore':

			try {
				$result['data']=PluginStoreApi::api($action);
			} catch (Exception $e) {
				$result=array('error'=>'yes','message'=>$e->getMessage());
			}

			break;
			
		case 'system':

			Model::load('api/system');

			try {
				$result['data']=loadApi($action);
			} catch (Exception $e) {
				$result=array('error'=>'yes','message'=>$e->getMessage());
			}

			break;
			
		case 'file':

			Model::load('api/file');

			try {
				$result['data']=loadApi($action);
			} catch (Exception $e) {
				$result=array('error'=>'yes','message'=>$e->getMessage());
			}

			break;

			
		
	}

	echo json_encode($result);
}
?>