<?php

class controlApi
{
	public static function index()
	{
		$result=array('error'=>'yes','message'=>'','data'=>array());

		if(!$match=Uri::match('\/?api\/(\w+)\/(\w+)'))
		{
			$result['message']='Data not valid.';
		}
		else
		{
			switch ($match[1]) {
				case 'system':

					Models::load('system');

					try {
						$result['data']=apiProcess($match[2]);
					} catch (Exception $e) {
						$result['message']=$e->getMessage();
					}
					
					break;
				case 'post':

					Models::load('post');

					try {
						$result['data']=apiProcess($match[2]);
					} catch (Exception $e) {
						$result['message']=$e->getMessage();
					}
					
					break;
				case 'media':

					Models::load('media');

					try {
						$result['data']=apiProcess($match[2]);
					} catch (Exception $e) {
						$result['message']=$e->getMessage();
					}
					
					break;
				case 'file':

					Models::load('file');

					try {
						$result['data']=apiProcess($match[2]);
					} catch (Exception $e) {
						$result['message']=$e->getMessage();
					}
					
					break;
				case 'user':

					Models::load('user');

					try {
						$result['data']=apiProcess($match[2]);
					} catch (Exception $e) {
						$result['message']=$e->getMessage();
					}
					
					break;
				case 'plugin':

					Models::load('plugin');

					try {
						$result['data']=apiProcess($match[2]);
					} catch (Exception $e) {
						$result['message']=$e->getMessage();
					}
					
					break;
				case 'theme':

					Models::load('theme');

					try {
						$result['data']=apiProcess($match[2]);
					} catch (Exception $e) {
						$result['message']=$e->getMessage();
					}
					
					break;
				
			}
		}

		echo json_encode($result);		
	}

}