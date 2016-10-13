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

		require(ROOT_PATH.'bootstraps/jsupload/php/UploadHandler.php');

		$toDay=date('Y-m-d');

		if(!is_dir(ROOT_PATH.'/uploads/media/'.$toDay.'/'))
		{
			Dir::create(ROOT_PATH.'/uploads/media/'.$toDay.'/');
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

		$toDay=date('Y-m-d');

		$filePath=ROOT_PATH.'uploads/media/'.$toDay.'/'.$send_filename;

		if(file_exists($filePath))
		{
			unlink($filePath);
		}

		// return $upload_handler;
	}


	public static function loadFile()
	{
		$send_path=trim(Request::get('send_path',''));

		$send_path=isset($send_path[1])?$send_path.'/':'';

		$filePath=ROOT_PATH.'uploads/media/'.$send_path;

		$fileUrl=System::getUrl().'uploads/media/'.$send_path;

		if(preg_match('/\.\./i', $filePath))
		{
			throw new Exception('We not allow to view this dir.');
		}

		$allDir=Dir::all($filePath);

		$total=count($allDir);

		$li='';

		if(isset($send_path[2]))
		{
			$li.='
			<tr>
			<td><a href="#" class="media_dir text-danger" data-dir="">[Back to home]</a></td>
			<td></td>
			<td></td>
			<td class="text-right"></td>
			</tr>
			';				
		}

		for ($i=2; $i < $total; $i++) { 
			$theFile=$filePath.$allDir[$i];



			if(!preg_match('/.*?\.\w+/i', $theFile))
			{
				$li.='
				<tr>
				<td><a href="#" class="media_dir text-success" data-dir="'.$allDir[$i].'">'.$allDir[$i].'</a></td>
				<td></td>
				<td>'.date('M d, Y H:i:s',filectime($theFile)).'</td>
				<td class="text-right"></td>
				</tr>
				';
			}
			else
			{
				$removePath='';

				if(preg_match('/media\/(.*?)$/i', $filePath,$matchPath))
				{
					$removePath=$matchPath[1];
				}

				$li.='
				<tr>
				<td><a href="'.$fileUrl.$allDir[$i].'" target="_blank">'.$allDir[$i].'</a></td>
				<td>'.File::humanFileSize(filesize($theFile)).'</td>
				<td>'.date('M d, Y H:i:s',filectime($theFile)).'</td>
				<td class="text-right"><button type="button" class="remove_media_file" data-path="'.$removePath.'" data-filename="'.$allDir[$i].'"  class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-remove-sign"></span></button></td>
				</tr>
				';				
			}

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