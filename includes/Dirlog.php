<?php

/*
	Dirlog::make('includes.test@test.data',$content);

	Dirlog::makeAutoFile('uploads.testlog','ac');

	$data=Dirlog::get(array(
		'path'=>'uploads.testlog'
		));
		
	echo  $data;

*/
class Dirlog
{
	public static function make($dirPath='',$content='',$callback='',$autoFileName='no')
	{
		if(!isset($dirPath[6]))
		{
			return false;
		}

		$fileName='index.txt';

		if($autoFileName!='no')
		{
			$fileName=microtime(true).'.txt';
		}

		$dirPath=trim($dirPath);

		if(preg_match('/^(.*?)\@(\w+\.\w+)$/i', $dirPath,$match))
		{
			$dirPath=$match[1];

			$fileName=$match[2];
		}

		$dirPath=str_replace('.', '/', $dirPath);

		$dirPath=$dirPath.'/'.$fileName;

		File::create(ROOT_PATH.$dirPath,$content,'w');

		if(is_object($callback))
		{
			$callback=(object)$callback;

			$result=$callback();

			return $result;
		}
	}

	public static function makeAutoFile($dirPath='',$content='',$callback='')
	{
		$result=self::make($dirPath,$content,$callback,'yes');

		return $result;
	}

	public static function get($inputData=array())
	{
		$dirPath=isset($inputData['path'])?$inputData['path']:'';

		if(!isset($dirPath[5]))
		{
			return false;
		}

		$dirPath=str_replace('.', '/', $dirPath);

		$implode=isset($inputData['implode'])?$inputData['implode']:'';

		$before=isset($inputData['before'])?$inputData['before']:'';

		$after=isset($inputData['after'])?$inputData['after']:'';

		if(!preg_match('/\/$/i', $dirPath))
		{
			$dirPath.='/';
		}

		$allFiles=glob(ROOT_PATH.$dirPath.'*.txt');

		$result='';

		$total=count($allFiles);

		if($total > 1)
		{
			for ($i=0; $i < $total; $i++) { 
				$result.=$before.file_get_contents($allFiles[$i]).$after.$implode;
			}
		}

		return $result;
	}

	public static function getArray($inputData=array())
	{
		$dirPath=isset($inputData['path'])?$inputData['path']:'';

		if(!isset($dirPath[5]))
		{
			return false;
		}

		if(!preg_match('/\//i', $dirPath))
		{
			$dirPath.='/';
		}

		$allFiles=glob(ROOT_PATH.$dirPath.'*.txt');

		$result=array();

		$total=count($allFiles);

		if($total > 1)
		{
			for ($i=0; $i < $total; $i++) { 
				$result[]=file_get_contents($allFiles[$i]);
			}
		}

		return $result;
	}

	public static function getSubs($inputData=array())
	{
		$dirPath=isset($inputData['path'])?$inputData['path']:'';

		if(!isset($dirPath[5]))
		{
			return false;
		}

		$allDir=Dir::listDir(ROOT_PATH.$dirPath);

		$total=count($allDir);

		$result='';

		for ($i=0; $i < $total; $i++) { 

			$inputData['path'].=$allDir[$i].'/';

			$result.=self::get($inputData);

		}

		return $result;
	}

	public static function getSubsAssoc($inputData=array())
	{
		$dirPath=isset($inputData['path'])?$inputData['path']:'';

		if(!isset($dirPath[5]))
		{
			return false;
		}

		$allDir=Dir::listDir(ROOT_PATH.$dirPath);

		$total=count($allDir);

		$result=array();

		$dirName='';

		for ($i=0; $i < $total; $i++) { 

			$dirName=$allDir[$i];

			$inputData['path'].=$dirName.'/';

			$result[$dirName]=self::get($inputData);

		}

		return $result;
	}

	public static function getSubsArray($inputData=array())
	{
		$dirPath=isset($inputData['path'])?$inputData['path']:'';

		if(!isset($dirPath[5]))
		{
			return false;
		}

		$allDir=Dir::listDir(ROOT_PATH.$dirPath);

		$total=count($allDir);

		$result=array();

		$dirName='';

		for ($i=0; $i < $total; $i++) { 

			$dirName=$allDir[$i];

			$inputData['path'].=$dirName.'/';

			$result[]=self::get($inputData);

		}

		return $result;
	}

}
?>