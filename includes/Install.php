<?php

class Install
{
	public function check()
	{
		global $db;

		$filePath=__FILE__;

		$isExists=file_exists('../install/index.php');

		if(!isset($db['default']['dbname'][1]) && $isExists==true)
		{
			self::move();
		}
		else
		{
			return false;
		}

		if(!stristr($filePath,ROOT_PATH) && $isExists==true)
		{
			self::move();
		}
		else
		{
			return false;
		}

		Database::connect();

		if(isset(Database::$error[5]))
		{
			self::move();
		}
		else
		{
			return false;
		}		
	}

	public function move()
	{
		header('Location: install/index.php');

		die();			
	}
}
?>