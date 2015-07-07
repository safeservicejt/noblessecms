<?php

class Update
{

	
	public function get()
	{
		$loadData=Http::getDataUrl(SERVER_URL.'api/update/get');

		$loadData=json_decode($loadData,true);

		return $loadData;
	}

	/*
	$inputData:
		'version'=>'4.5',
		'file'=>'upload.zip'


	*/

	public function make($inputData=array())
	{
		$loadData=self::get();

		// print_r($loadData);die();

		$url=$loadData['data']['file'];

		// if(!preg_match('/github\.com/i', $url))

		File::downloadModule($url,'uploads/tmp/update/','yes');

		$sourcePath=ROOT_PATH.'uploads/tmp/update/noblessecms-master/';

		$descPath=ROOT_PATH.'uploads/tmp/test/';

		if(is_dir($sourcePath))
		{
			unlink($sourcePath.'.htaccess');

			unlink($sourcePath.'config.php');

			unlink($sourcePath.'autoload.php');

			unlink($sourcePath.'routes.php');

			unlink($sourcePath.'README.md');

			Dir::remove($sourcePath.'install');

			Dir::remove($sourcePath.'contents');

		}

		// File::fullCopy($sourcePath,ROOT_PATH.'uploads/tmp/test/');
		
		File::fullCopy($sourcePath,ROOT_PATH);

		Dir::remove($sourcePath);
		// Dir::remove($descPath);


	}

	


}
?>