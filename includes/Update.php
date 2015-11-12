<?php

class Update
{

	
	public static function get()
	{
		$loadData=Http::getDataUrl(SERVER_URL.'api/plugin/noblessestore/get_update');

		$loadData=json_decode($loadData,true);

		return $loadData;
	}

	/*
	$inputData:
		'version'=>'4.5',
		'file'=>'upload.zip'


	*/

	public static function make($inputData=array())
	{
		$loadData=self::get();

		$url=trim($loadData['data']['file']);

		if(!preg_match('/^http/i', $url))
		{
			$url='https://github.com/safeservicejt/noblessecms/archive/master.zip';
		}

		$sourcePath='';

		if(!is_dir(ROOT_PATH.'uploads/tmp/update/'))
		{
			Dir::create(ROOT_PATH.'uploads/tmp/update/');
		}

		File::downloadModule($url,'uploads/tmp/update/','yes');

		if(preg_match('/github\.com/i', $url))
		{
			$sourcePath=ROOT_PATH.'uploads/tmp/update/noblessecms-master/';
		}
		else
		{
			$sourcePath=ROOT_PATH.'uploads/tmp/update/noblessecms/';
		}

		$descPath=ROOT_PATH.'uploads/tmp/test/';

		if(is_dir($sourcePath))
		{
			unlink($sourcePath.'.htaccess');

			unlink($sourcePath.'config.php');

			unlink($sourcePath.'autoload.php');

			unlink($sourcePath.'routes.php');

			unlink($sourcePath.'README.md');

			if(file_exists($sourcePath.'install/update.sql'))
			{
				
				Database::import($sourcePath.'install/db.sql');

				Database::import($sourcePath.'install/update.sql');

			}

			Dir::remove($sourcePath.'install');

			Dir::remove($sourcePath.'contents');
			
			Dir::remove($sourcePath.'application/caches');

		}

		// File::fullCopy($sourcePath,ROOT_PATH.'uploads/tmp/test/');
		
		File::fullCopy($sourcePath,ROOT_PATH);

		Dir::remove($sourcePath);
		// Dir::remove($descPath);


	}

	


}
?>