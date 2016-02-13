<?php

class RakonDB
{
	/*
	Struct data

	rakondb/db.data | List database line by line
	
	rakondb/databasename/tables.data | List tables line by line

	rakondb/databasename/tables | List folders (tables)

	rakondb/databasename/tables/tablename/info.data | Information of table: created_date datetime, columns int, records int,

	rakondb/databasename/tables/tablename/records | List records of each table

	rakondb/databasename/tables/tablename/records/_record_id/info.data | Data of record by id

	*/

	private static $path=ROOT_PATH.'contents/rakondb/';

	private static $tablePath=ROOT_PATH.'contents/rakondb/';
	
	private static $db=array();

	private static $dblist=array();

	private static $data=array();

	private static $dbname='';

	public static function dbExists($dbName='')
	{
		if(!isset($dbName[1]))
		{
			throw new Exception('Data not valid.');
		}

		$status=file_exists(self::$path.$dbName.'tables.data')?true:false;

		return $status;
	}

	public static function tableExists($tableName='')
	{
		if(!isset($tableName[1]))
		{
			throw new Exception('Data not valid.');
		}

		$tablePath=self::getTablePath().$tableName.'/';

		$status=file_exists($tablePath.'info.data')?true:false;

		return $status;
	}

	// Database functions-------------------------------------------------------------
	public static function createDB($dbName='')
	{
		if(!isset($dbName[1]))
		{
			throw new Exception('Data not valid.');
		}

		if(!is_dir(self::$path.$dbName))
		{
			Dir::create(self::$path.$dbName);
		}
		
	}

	public static function dropDB($dbName='')
	{
		if(!isset($dbName[1]))
		{
			throw new Exception('Data not valid.');
		}

		if(is_dir(self::$path.$dbName))
		{
			Dir::remove(self::$path.$dbName);
		}
		
	}

	// Table functions-------------------------------------------------------------
	public static function createTable($tableName='',$inputData=array())
	{
		if(!isset($tableName[1]))
		{
			throw new Exception('Data not valid.');
		}

		if(!file_exists(self::$db[self::$dbame]['tablepath'].$tableName.'/info.data'))
		{
			$insertData=array(
				'created_time'=>time(),
				'created_date'=>date('d M, Y H:i'),
				'modify_date'=>date('d M, Y H:i'),
				'columns'=>count($inputData),
				'records'=>0,
				'data'=>$inputData
				);

			File::create(self::$db[self::$dbame]['tablepath'].$tableName.'/info.data',serialize($insertData));

			Dir::create(self::$db[self::$dbame]['tablepath'].$tableName.'/records');
		}
		
	}

	public static function getTableInfo($tableName='')
	{
		if(!isset($tableName[1]))
		{
			throw new Exception('Data not valid.');
		}

		$loadData=unserialize(file_get_contents(self::$db[self::$dbame]['tablepath'].$tableName.'/info.data'));

		return $loadData;
	}

	public static function dropTable($tableName='')
	{
		if(!isset($tableName[1]))
		{
			throw new Exception('Data not valid.');
		}

		if(is_dir(self::$db[self::$dbame]['tablepath'].$tableName))
		{
			Dir::remove(self::$db[self::$dbame]['tablepath'].$tableName);
		}
		
	}


	// Record functions------------------------------------------------------------------------

	public static function createRecord($tableName='',$inputData='')
	{
		if(!isset($tableName[1]))
		{
			throw new Exception('Data not valid.');
		}

		$time_start = microtime(true);

		$recordName=$time_start;

		if(!file_exists(self::$db[self::$dbame]['tablepath'].$tableName.'/info.data'))
		{
			$insertData=array(
				'id'=>$time_start,
				'created_date'=>date('d M, Y H:i'),
				'modify_date'=>date('d M, Y H:i'),
				'columns'=>count($inputData),
				'records'=>0
				);

			File::create(self::$db[self::$dbame]['tablepath'].$tableName.'/records/'.$recordName.'/info.data',serialize($insertData));
		}

		return $recordName;
	}

	public static function deleteRecord($tableName='',$whereTerm='*')
	{
		if(!isset($tableName[1]))
		{
			throw new Exception('Data not valid.');
		}

		if(is_dir(self::$db[self::$dbame]['tablepath'].$tableName))
		{
			$tableData=unserialize(file_get_contents(self::$db[self::$dbame]['tablepath'].$tableName.'/info.data'));

			if($whereTerm=='*')
			{
				Dir::remove(self::$db[self::$dbame]['tablepath'].$tableName.'/records');

				$tableData['records']=0;
				$tableData['modify_date']=date('d M, Y H:i');
			}
			elseif()
			

			File::create(self::$db[self::$dbame]['tablepath'].$tableName.'/info.data',serialize($tableData));
		}
		
	}

	// -------------------------------------------------------------------------------

	public static function query($str='')
	{
		$str=trim($str);

		if(!isset($str[2]) || !preg_match('/^(create|drop|select|update|delete) ([a-zA-Z0-9_\_\,\.]+) /i', $str,$match))
		{
			throw new Exception('Data not valid.');
		}

		$method=strtoupper($match[1]);

		$object=strtoupper($match[2]);

		switch ($method) {
			case 'CREATE':
				
				switch ($object) {

					case 'DATABASE':
						if(!preg_match('/create database (\w+)/i', $str,$matchC))
						{
							throw new Exception('We not match database name.');							
						}

						$dbName=$matchC[1];

						$status=self::dbExists($dbName);

						if(!$static)
						{
							throw new Exception('Database '.$dbName.' have been exists.');
						}

						self::createDB($dbName);

						break;

					case 'TABLE':
						if(!preg_match('/create table (\w+)/i', $str,$matchC))
						{
							throw new Exception('We not match table name.');							
						}

						$tableName=$matchC[1];

						$status=self::tableExists($tableName);

						if(!$static)
						{
							throw new Exception('Table '.$tableName.' have been exists.');
						}

						self::createTable($tableName);
						break;
					
				}

				break;

			case 'DROP':
				
				switch ($object) {

					case 'DATABASE':
						if(!preg_match('/drop database (\w+)/i', $str,$matchC))
						{
							throw new Exception('We not match database name.');							
						}

						$dbName=$matchC[1];

						$status=self::dbExists($dbName);

						if(!$static)
						{
							throw new Exception('Database '.$dbName.' not exists.');
						}

						self::dropDB($dbName);

						break;

					case 'TABLE':
						if(!preg_match('/drop table (\w+)/i', $str,$matchC))
						{
							throw new Exception('We not match table name.');							
						}

						$tableName=$matchC[1];

						$status=self::tableExists($tableName);

						if(!$static)
						{
							throw new Exception('Table '.$tableName.' not exists.');
						}

						self::dropTable($tableName);
						break;
					
				}

				break;

			case 'DELETE':
		
				if(!preg_match('/^delete from (\w+)/i', $str,$matchC))
				{
					throw new Exception('We not match database name.');							
				}

				$tableName=$matchC[1];

				$addWhere='*';

				if(preg_match('/^delete from (\w+) where (.*?)$/i', $str,$matchWhere))
				{
					$addWhere=isset($matchWhere[1][2])?$matchWhere[1]:'*';		


				}

				self::deleteRecord($tableName,$addWhere);


				break;
			
		}


	}

	public static function getDBPath($dbName='default')
	{
		return self::$db[$dbName]['path'];
	}

	public static function getTablePath($dbName='default')
	{
		return self::$db[$dbName]['tablepath'];
	}

	public static function getRecordPath($dbName='default')
	{
		return self::$db[$dbName]['recordpath'];
	}

	public static function connect($dbName='default')
	{
		self::$dbame=$dbName;

		self::$db[$dbName]['name']=$dbName;

		self::$db[$dbName]['path']=ROOT_PATH.'contents/rakondb/'.$dbName.'/';

		self::$db[$dbName]['tablepath']=self::$db['path'].'tables/';

		self::$db[$dbName]['recordpath']=self::$db['tablepath'].'records/';
	}
}

?>