<?php

/*


$inputData[0]['id']=1;
$inputData[0]['name']='james';
$inputData[1]['id']=2;
$inputData[1]['name']='jane';
$inputData[2]['id']=3;
$inputData[2]['name']='bond';


Collection::make($inputData);


$result=Collection::map(function($user){

	if($user['id']!=1)
	return $user;
});


$result=Collection::reject(function($user){

	if($user['id']==1)
	return $user;
});


*/
class Collection
{

	private static $data=array();

	public static function make($inputData=array(),$keyName='default')
	{
		self::$data[$keyName]=$inputData;
	}

	public static function map($object,$keyName='default')
	{
		$total=count(self::$data[$keyName]);

		$result=array();

		if($total > 0)
		{
			for ($i=0; $i < $total; $i++) { 
				$tmp=$object(self::$data[$keyName][$i]);

				if($tmp)
				{
					$result[]=$tmp;
				}
				
			}

		}

		return $result;
	}

	public static function reject($object,$keyName='default')
	{
		$total=count(self::$data[$keyName]);

		$result=array();

		if($total > 0)
		{
			for ($i=0; $i < $total; $i++) { 
				$tmp=$object(self::$data[$keyName][$i]);

				if(!$tmp)
				{
					$result[]=self::$data[$keyName][$i];
				}
				
			}

		}

		return $result;
	}

	public static function random($total=1,$keyName='default')
	{
		$result=array();

		$j=0;

		for ($i=0; $i < $total; $i++) { 

			$tmp=shuffle(self::$data[$keyName]);

			$result[$j]=$tmp[0];

			$j++;				
		}

		return $result;
	}


}
?>