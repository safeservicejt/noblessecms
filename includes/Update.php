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

	public static function fromUpload($keyName='upload_file')
	{
		$name=$_FILES[$keyName]['name'];

		if(!preg_match('/\.zip$/i', $name))
		{
			throw new Exception('File name not valid.');
		}

		$savePath=ROOT_PATH.'uploads/tmp/update/';

		$filePath=$savePath.'update.zip';

		if(!is_dir($savePath))
		{
			Dir::create($savePath);
		}

		if(!move_uploaded_file($_FILES[$keyName]['tmp_name'], $savePath.'update.zip'))
		{
			throw new Exception('Error while trying upload zip file.');
			
		}

		if(!file_exists($savePath.'update.zip'))
		{
			throw new Exception('Error while detecting zip file.');

		}

		$matchPath=$savePath;

		$listFile=File::unzipModule($filePath,'yes');

		if(!in_array('config.php', $listFile))
		{
			$listDir=Dir::listDir($savePath);

			$matchPath=$savePath.$listDir[0].'/';

			if(!file_exists($matchPath.'config.php'))
			{
				$listDir=Dir::listDir($matchPath);

				$matchPath=$matchPath.$listDir[0].'/';

				if(!file_exists($matchPath.'config.php'))
				{
					$listDir=Dir::listDir($matchPath);

					$matchPath=$matchPath.$listDir[0].'/';

					if(!file_exists($matchPath.'config.php'))
					{
						$listDir=Dir::listDir($matchPath);

						$matchPath=$matchPath.$listDir[0].'/';

						
					}					
				}
			}


		}

		if(!file_exists($matchPath.'config.php'))
		{
			throw new Exception('Data not valid. Upload .zip file again!');
		}

		unlink($matchPath.'.htaccess');

		unlink($matchPath.'config.php');

		unlink($matchPath.'autoload.php');

		unlink($matchPath.'routes.php');

		unlink($matchPath.'README.md');

		if(file_exists($matchPath.'install/update.sql'))
		{
			
			Database::import($matchPath.'install/db.sql');

			Database::import($matchPath.'install/update.sql');

		}

		if(file_exists($matchPath.'install/update.php'))
		{
			include($matchPath.'install/update.php');
		}

		Dir::remove($matchPath.'install');

		Dir::remove($matchPath.'contents');
		
		Dir::remove($matchPath.'update');

		File::removeOnly($matchPath.'index.html');
		
		Dir::remove($matchPath.'application/caches');

		Dir::copy($matchPath,ROOT_PATH);	

		Dir::remove($matchPath);			

	}

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

			if(file_exists($sourcePath.'install/update.php'))
			{
				include($sourcePath.'install/update.php');
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