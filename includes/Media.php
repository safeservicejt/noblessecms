<?php

class Media
{
	public static function api($action)
	{
		$route=array(
			'load_file'=>'loadFile',
			'load_dir'=>'loadDir',
			'upload_file'=>'uploadFile',
			'remove_file'=>'removeFile',

			);

		if(!isset($route[$action]) || !method_exists('Media', $route[$action]))
		{
			throw new Exception('We not support this action.');
		}

		$methodName=$route[$action];

		try {
			$result=self::$methodName();
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

		return $result;
	}	

	public static function uploadFile()
	{
		$userid=(int)Users::getCookieUserId();

		if($userid==0)
		{
			throw new Exception('You must login to upload media.');
		}

		error_reporting(E_ALL | E_STRICT);

		require(ROOT_PATH.'bootstrap/jsupload/php/UploadHandler.php');

		if(!is_dir(ROOT_PATH.'/uploads/media/'))
		{
			Dir::create(ROOT_PATH.'/uploads/media/');
		}

		$upload_handler = new UploadHandler();	

		die();
		// return $upload_handler;
	}

	public static function removeFile()
	{
		$userid=(int)Users::getCookieUserId();

		if($userid==0)
		{
			throw new Exception('You must login to remove media.');
		}

		$send_filename=trim(Request::get('send_filename',''));

		$filePath=ROOT_PATH.'uploads/media/'.$send_filename;

		if(file_exists($filePath))
		{
			unlink($filePath);
		}

		// return $upload_handler;
	}


	public static function loadFile()
	{
		$send_path=trim(Request::get('send_path',''));

		$filePath=ROOT_PATH.'uploads/media/'.$send_path;

		$fileUrl=System::getUrl().'uploads/media/'.$send_path;

		if(preg_match('/\.\./i', $filePath))
		{
			throw new Exception('We not allow to view this dir.');
		}

		$allDir=Dir::all($filePath);

		$total=count($allDir);

		$li='';

		for ($i=2; $i < $total; $i++) { 
			$theFile=$filePath.$allDir[$i];

			$li.='
			<tr>
			<td><a href="'.$fileUrl.$allDir[$i].'" target="_blank">'.$allDir[$i].'</a></td>
			<td>'.File::humanFileSize(filesize($theFile)).'</td>
			<td>'.date('M d, Y',strtotime(filectime($theFile))).'</td>
			<td class="text-right"><button type="button" class="remove_media_file" data-filename="'.$allDir[$i].'"  class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-remove-sign"></span></button></td>
			</tr>
			';
		}

		return $li;
			
	}




	public static function loadDir()
	{
		$send_path=trim(Request::get('send_path',''));

		if($send_path==ROOT_PATH)
		{
			throw new Exception('We not allow to view this dir.');
		}

		$allDir=Dir::all($send_path);

		if(in_array('includes', $allDir) && in_array('routes.php', $allDir) && in_array('config.php', $allDir))
		{
			throw new Exception('We not allow to view this dir.');
		}	
		
			
	}


}

?>