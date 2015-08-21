<?php

class LumiDB
{
	private static $dbPath='';

	private static $currentDBName='';

	private static $currentTableName='';

	private static $dbData=array();

	private static $tableData=array();

	public static $error='no';

	public static $message='';

	public function __construct()
	{
		$path=CACHES_PATH.'lumidb/';

		if(!is_dir($path))
		{
			Dir::create($path);
		}

		self::$dbPath=$path;
		
	}

	// LumiDB::setPath('');
	public function setPath($newPath='')
	{
		self::$dbPath=$newPath;
	}

	public function getPath()
	{
		return self::$dbPath;
	}

	public function getMessage()
	{
		return self::$message;
	}

	public function setMessage($str='')
	{
		self::$error='yes';

		self::$message=$str;
	}

	public function getError()
	{
		return self::$error;
	}

	public function connectDB($dbName='')
	{
		$dbPath=self::$dbPath.'database/';

		$filePath=$dbPath.$dbName.'.db';

		if(!file_exists($filePath))
		{
			self::setMessage('Database '.$dbName.' not exists.');
			return false;
		}

		$loadData=file_get_contents($filePath);

		if(isset($loadData[5]))
		self::$dbData=unserialize($loadData);
	}


	public function createDB($inputData='')
	{
		try {
			self::createDBProcess($inputData);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

		return true;
	}

	public function createDBProcess($dbName='')
	{
		$dbPath=self::$dbPath.'database/';

		// $filePath=$dbPath.$dbName;

		// Cache::setPath($dbPath);

		// Cache::saveKey($dbName,'');

		// Cache::resetPath();

		File::create($dbPath.$dbName.'.db','');
	}

	public function getTables()
	{
		if(!isset(self::$currentDBName[1]))
		{
			self::setMessage('You must connect to database before get list table.');
			return false;
		}

		return self::$dbData['tables'];
	}

	public function createTable($tableName='',$inputData=array())
	{
		/*
		$inputData=array(
			'field_name'=>array(
				'type'=>'int',
				'length'=>10,
				'autoincrease'=>true,
				'null'=>false,
				'default'=>false
				),

			'title'=>array(
				'type'=>'string',
				'length'=>255,
				'autoincrease'=>false,
				'null'=>true,
				'default'=>'pending'
				)
			);	
	
		*/

		if(!isset($currentDBName[1]))
		{
			self::setMessage('You must connect to database before create table.');

			return false;
		}

		if(!isset($tableName[1]))
		{
			self::setMessage('Table name not valid.');

			return false;
		}

		$totalKeys=count($inputData);

		if($totalKeys==0)
		{
			self::setMessage('Data to create table not valid.');

			return false;
		}

		$listKeys=array_keys($inputData);

		for ($i=0; $i < $totalKeys; $i++) { 

			$fieldName=$listKeys[$i];

			try {
				$fieldData=self::autoSetFieldOption($fieldName,$inputData[$fieldName]);
			} catch (Exception $e) {
				// throw new Exception($e->getMessage());
				self::setMessage($e->getMessage());
				return false;
			}
		}


		$tableData=array(
			'name'=>$tableName,
			'fields'=>implode(', ', $listKeys),
			'totalfield'=>$totalKeys,
			'totalrow'=>0
			'fieldsData'=>$inputData
			);

		$tableData=serialize($tableData);

		$dbPath=self::$dbPath.'tables/';

		$filePath=self::$currentDBName.'_'.$tableName;

		// Cache::setPath($dbPath);

		// Cache::saveKey($filePath,'');

		// Cache::resetPath();	

		File::create($filePath.'.table',$tableData);

		updateDatabase(array(
			'type'=>'addTable',
			'tableName'=>$tableName
			));	

	}

	public function autoSetFieldOption($fieldName,$inputData=array())
	{
		if(!isset($inputData['type']))
		{
			throw new Exception($fieldName.' not have data type.');
		}
		
		if(!isset($inputData['length']))
		{
			throw new Exception($fieldName.' not have length.');
		}

		$inputData['autoincrease']=isset($inputData['autoincrease'])?$inputData['autoincrease']:false;

		$inputData['null']=isset($inputData['null'])?$inputData['null']:false;

		$inputData['default']=isset($inputData['default'])?$inputData['default']:false;

	}

	public function updateDatabase($inputData=array())
	{
		$dbName=self::$currentDBName;

		$type=$inputData['type'];

		$tableName=$inputData['tableName'];

		$path=self::$dbPath.'database/';

		$dbPath=$path.$dbName.'.db';

		if(!file_exists($dbPath))
		{
			self::setMessage('Database '.$dbName.' not exists.');
			return false;
		}

		$dbData=file_get_contents($dbPath);

		if(!isset($dbData[5]))
		{
			$dbData=array();
		}
		else
		{
			$dbData=unserialize($dbData);
		}

		switch ($type) {
			case 'addTable':
				
				$dbData['tables']=isset($dbData['tables'])?$dbData['tables'].$tableName.', ':$tableName;

				$parse=explode(',', $dbData['tables']);

				$total=count($parse);

				$dbData['totaltables']=$total;

				break;
		}

		$dbData=serialize($dbData);

		File::create($dbPath,$dbData);

	}


}

?>