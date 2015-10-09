<?php

function loadApi($action)
{
	switch ($action) {

		case 'import_theme':

			if(!isset($_REQUEST['send_filename']))
			{
				throw new Exception('Data not valid.');
			}

			$fileName=$_REQUEST['send_filename'];

			$filePath=ROOT_PATH.'bootstrap/jsupload/php/files/'.$_REQUEST['send_filename'];

			if(!file_exists($filePath))
			{
				throw new Exception('File '.$fileName.' not exists.');
			}

			$targetPath='';

			$sourcePath=$filePath;

			$shortPath='contents/themes/'.$fileName;

			$targetPath.=$shortPath;

			File::move($sourcePath,$targetPath);

			// $sourcePath=dirname($sourcePath);

			// rmdir($sourcePath);

			File::unzipModule($targetPath,'yes');

			$installFile=ROOT_PATH.$shortPath.'/update.sql';

			if(file_exists($installFile))
			{
				Database::import($installFile);
			}			

			$installFile=ROOT_PATH.$shortPath.'/install/update.sql';

			if(file_exists($installFile))
			{
				Database::import($installFile);
			}		

			$installFile=ROOT_PATH.$shortPath.'/install/code_update.php';

			if(file_exists($installFile))
			{
				include($installFile);
			}			

			File::cleanTmpFiles(ROOT_PATH.'bootstrap/jsupload/php/files/');

			break;

		case 'import_plugin':

			if(!isset($_REQUEST['send_filename']))
			{
				throw new Exception('Data not valid.');
			}

			$fileName=$_REQUEST['send_filename'];

			$filePath=ROOT_PATH.'bootstrap/jsupload/php/files/'.$_REQUEST['send_filename'];

			if(!file_exists($filePath))
			{
				throw new Exception('File '.$fileName.' not exists.');
			}

			$targetPath='';

			$sourcePath=$filePath;

			$shortPath='contents/plugins/'.$fileName;

			$targetPath.=$shortPath;

			File::move($sourcePath,$targetPath);

			// $sourcePath=dirname($sourcePath);

			// rmdir($sourcePath);

			File::unzipModule($targetPath,'yes');

			$installFile=ROOT_PATH.$shortPath.'/update.sql';

			if(file_exists($installFile))
			{
				Database::import($installFile);
			}			

			$installFile=ROOT_PATH.$shortPath.'/install/update.sql';

			if(file_exists($installFile))
			{
				Database::import($installFile);
			}		

			$installFile=ROOT_PATH.$shortPath.'/install/code_update.php';

			if(file_exists($installFile))
			{
				include($installFile);
			}			

			File::cleanTmpFiles(ROOT_PATH.'bootstrap/jsupload/php/files/');

			break;

	}	
}

?>