<?php

function apiProcess($keyName='')
{
	if($keyName=='import_theme')
	{

		if(!isset($_REQUEST['send_filename']))
		{
			throw new Exception('Data not valid.');
		}

		$fileName=$_REQUEST['send_filename'];

		$toDay=date('Y-m-d');

		$filePath=ROOT_PATH.'uploads/media/'.$toDay.'/'.$_REQUEST['send_filename'];

		if(!file_exists($filePath))
		{
			throw new Exception('File '.$fileName.' not exists.');
		}

		if(!preg_match('/\w+\.zip$/i', $fileName))
		{
			unlink($filePath);

			throw new Exception('We only allow upload .zip file');
			
		}

		$targetPath=ROOT_PATH.'uploads/themes/';

		if(!is_dir($targetPath))
		{
			Dir::create($targetPath);
		}

		preg_match('/^(.*?)\.\w+$/i', basename($_REQUEST['send_filename']),$match);

		$theName=$match[1];

		File::move($filePath,$targetPath.basename($_REQUEST['send_filename']));

		File::unzipModule($targetPath.basename($_REQUEST['send_filename']),'yes');

		// throw new Exception($targetPath.$theName.'/info.txt');
		

		if(!file_exists($targetPath.$theName.'/info.txt'))
		{
			// $listDir=Dir::listDir($targetPath);
			copyNested($targetPath.$theName.'/');
		}
		else
		{
			Dir::create(ROOT_PATH.'contents/themes/'.$theName);

			Dir::copy($targetPath.$theName.'/',ROOT_PATH.'contents/themes/'.$theName);



		}

		if(file_exists(ROOT_PATH.'contents/themes/'.$theName.'/install/update.php'))
		{
			include(ROOT_PATH.'contents/themes/'.$theName.'/install/update.php');
		}
		
		File::cleanTmpFiles(ROOT_PATH.'bootstraps/jsupload/php/files/');

		Dir::remove(ROOT_PATH.'uploads/themes');
	
	}
	elseif($keyName=='import_plugin')
	{

		if(!isset($_REQUEST['send_filename']))
		{
			throw new Exception('Data not valid.');
		}

		$fileName=$_REQUEST['send_filename'];

		$toDay=date('Y-m-d');

		$filePath=ROOT_PATH.'uploads/media/'.$toDay.'/'.$_REQUEST['send_filename'];

		if(!file_exists($filePath))
		{
			throw new Exception('File '.$fileName.' not exists.');
		}

		if(!preg_match('/\w+\.zip$/i', $fileName))
		{
			unlink($filePath);

			throw new Exception('We only allow upload .zip file');
			
		}
		
		$targetPath=ROOT_PATH.'uploads/plugins/';

		if(!is_dir($targetPath))
		{
			Dir::create($targetPath);
		}

		preg_match('/^(.*?)\.\w+$/i', basename($_REQUEST['send_filename']),$match);

		$theName=$match[1];

		File::move($filePath,$targetPath.basename($_REQUEST['send_filename']));

		File::unzipModule($targetPath.basename($_REQUEST['send_filename']),'yes');

		// throw new Exception($targetPath.$theName.'/info.txt');
		

		if(!file_exists($targetPath.$theName.'/info.txt'))
		{
			// $listDir=Dir::listDir($targetPath);
			copyNested($targetPath.$theName.'/','plugins');
		}
		else
		{
			Dir::create(ROOT_PATH.'contents/plugins/'.$theName);

			Dir::copy($targetPath.$theName.'/',ROOT_PATH.'contents/plugins/'.$theName);


		}

		if(file_exists(ROOT_PATH.'contents/plugins/'.$theName.'/update.php'))
		{
			include(ROOT_PATH.'contents/plugins/'.$theName.'/update.php');
		}

		File::cleanTmpFiles(ROOT_PATH.'bootstraps/jsupload/php/files/');

		Dir::remove(ROOT_PATH.'uploads/plugins');

	}
	else
	{
		throw new Exception('We not support api: '.$keyName);
	}
}


function copyNested($targetPath='',$type='themes')
{
	$listDir=Dir::listDir($targetPath);

	$totalDir=count($listDir);

	if((int)$totalDir > 0)
	for ($i=0; $i < $totalDir; $i++) { 
		$theDir=$targetPath.$listDir[$i].'/';

		if(!file_exists($theDir.'info.txt'))
		{
			copyNested($theDir);
			continue;
		}

		Dir::create(ROOT_PATH.'contents/'.$type.'/'.$listDir[$i]);

		Dir::copy($theDir,ROOT_PATH.'contents/'.$type.'/'.$listDir[$i]);

	
	}

}