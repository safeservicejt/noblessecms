<?php

class Multidb
{
	private static $totalPost=0;

	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="dbid,dbtype,dbhost,dbport,dbuser,dbpassword,dbname,status";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by dbid desc';

		$result=array();

		$command="select $selectFields from multidb $whereQuery $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$query=Database::query($queryCMD);

		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				if(isset($row['status']))
				{
					$row['statusFormat']=((int)$row['status']==1)?'Activate':'Not activate';
				}

				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}

		return $result;
		
	}	

	public function maxPost()
	{
		$total=GlobalCMS::$setting['multidb_maxpost'];

		return $total;
	}

	public function saveCurrentDb()
	{
		$maxPost=self::maxPost();

		$totalPost=self::getTotalPost();

		$num=intval((int)$totalPost/(int)$maxPost);

		// print_r(self::getCurrentDb());die();

		if($num >= 1)
		{
			$dbname=self::getDbNameViaNumber($num);

			
			Cache::saveKey('currentMainDB',$dbname);
		}

	}
	public function getCurrentDb()
	{
		if(!$loadData=Cache::loadKey('currentMainDB',-1))
		{
			return '';
		}

		$maxPost=self::maxPost();

		$totalPost=self::getTotalPost();

		if((int)$totalPost < (int)$maxPost)
		{
			return '';
		}

		return $loadData.'.';
	}

	public function increasePost($number=1)
	{
		if((int)self::$totalPost == 0)
		{
			if(!$loadData=Cache::loadKey('totalPost',-1))
			{
				$total=1;
			}
			else
			{
				$total=(int)$loadData+(int)$number;
			}

		}
		else
		{
			$total=(int)self::$totalPost + 1;
		}

		self::$totalPost=$total;

		Cache::saveKey('totalPost',$total);

		self::saveCurrentDb();
	}
	
	public function getTotalPost()
	{
		if(!$loadData=Cache::loadKey('totalPost',-1))
		{
			$total=0;
		}

		$total=$loadData;

		return $total;
	}
	public function decreasePost($number=1)
	{
		if(!$loadData=Cache::loadKey('totalPost',-1))
		{
			return false;
		}

		$total=(int)$loadData-(int)$number;

		Cache::saveKey('totalPost',$total);

		return true;
	}
	public function resetPost()
	{
		if(!$loadData=Cache::loadKey('totalPost',-1))
		{
			return false;
		}

		Cache::saveKey('totalPost',0);

		return true;
	}

	public function serverNumber()
	{
		if(!$loadData=Cache::loadKey('totalPost',-1))
		{
			return false;
		}

		$number=intval((int)$loadData/2000);

		return $number;
	}

	public function renderDb($tableName='',$queryCMD='')
	{
		global $db;

		if(!$loadData=self::loadCache())
		{
			// return $tableName;

			$loadData=array();
		}

		$total=count($loadData);

		// if($total==0)
		// {
		// 	$li=$db['default']['dbname'].'.'.$tableName;

		// 	return $li;
		// }
		// die('dfdf');
		
		$loadData[]=$db['default'];

		$keyNames=array_keys($loadData);

		$total=count($keyNames);

		$li='';

		if(isset($queryCMD[5]))
		{
			for($i=0;$i<$total;$i++)
			{
				$id=$keyNames[$i];

				$dbname=$loadData[$id]['dbname'].'.'.$tableName;

				$li.=str_replace('{{table}}', $dbname, $queryCMD).' UNION ';
			}

			$li=substr($li, 0, strlen($li)-6).' ';
			return $li;				
		}
		else
		{
			for($i=0;$i<$total;$i++)
			{
				$id=$keyNames[$i];

				$li.=$loadData[$id]['dbname'].'.'.$tableName.', ';
			}

			$li=substr($li, 0, strlen($li)-2).' ';
			return $li;				
		}

	
	}
	public function renderMutiQuery($tableName='',$queryCMD='')
	{
		global $db;

		if(!$loadData=self::loadCache())
		{
			return $tableName;
		}

		$total=count($loadData);

		if($total==0)
		{
			$li=$db['default']['dbname'].'.'.$tableName;

			return $li;
		}

		$loadData[]=$db['default'];

		$keyNames=array_keys($loadData);

		$total=count($keyNames);

		$li='';

		if(isset($queryCMD[5]))
		{
			for($i=0;$i<$total;$i++)
			{
				$id=$keyNames[$i];

				$dbname=$loadData[$id]['dbname'].'.'.$tableName;

				$li.=str_replace('{{table}}', $dbname, $queryCMD).';';
			}

			// $li=substr($li, 0, strlen($li)-6).' ';
			return $li;				
		}

	
	}

	public function renderOnlyDb($tableName='')
	{
		global $db;

		if(!$loadData=self::loadCache())
		{
			return $tableName;
		}

		$total=count($loadData);

		if($total==0)
		{
			$li=$db['default']['dbname'].'.'.$tableName;

			return $li;
		}

		$loadData[]=$db['default'];

		$keyNames=array_keys($loadData);

		$total=count($keyNames);

		$li='';

		for($i=0;$i<$total;$i++)
		{
			$id=$keyNames[$i];

			$li.=$loadData[$id]['dbname'].'.'.$tableName.', ';
		}

		$li=substr($li, 0, strlen($li)-2).' ';
		return $li;		
	}
	
	public function connect($id)
	{
		global $db;

		$loadData=self::getCache($id);

		$tmpName='tmpMulti'.$id;

		$db[$tmpName]=$result;

		Database::connect($tmpName);
	}

	public function saveCache()
	{
		$loadData=self::get(array(
			'where'=>"where status='1'"
			));

		$total=count($loadData);

		$result=array();

		for($i=0;$i<$total;$i++)
		{
			$id=$loadData[$i]['dbid'];

			$result[$id]=$loadData[$i];
		}		

		Cache::saveKey('listMultidb',json_encode($result));
	}

	public function getCache($id)
	{
		if(!$loadData=self::loadCache())
		{
			return false;
		}

		$total=count($loadData);

		$result=array();

		if(!isset($loadData[$id]))
		{
			return false;
		}

		$result=$loadData[$id];

		return $result;
	}
	
	public function getDbNameViaNumber($num)
	{
		// global $db;

		$num--;

		// $dbname=$db['default']['dbname'];

		$query=Database::query("select dbid,dbtype,dbhost,dbport,dbuser,dbpassword,dbname from multidb limit $num,1");

		$total=Database::num_rows($query);

		if((int)$total==0)
		{
			return '';
		}

		$row=Database::fetch_assoc($query);

		$result=$row['dbname'];

		return $result;
	}
	public function getDbName($id)
	{
		if(!$loadData=self::loadCache())
		{
			return false;
		}

		$total=count($loadData);

		$result=array();

		if(!isset($loadData[$id]))
		{
			return false;
		}

		$result=$loadData[$id]['dbname'];

		return $result;
	}

	public function loadCache()
	{
		if(!$loadData=Cache::loadKey('listMultidb',-1))
		{
			return false;
		}

		$loadData=json_decode($loadData,true);

		return $loadData;
	}


	public function insert($inputData=array())
	{

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Database::query("insert into multidb($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			self::saveCache();

			return true;		
		}

		return false;
	
	}
	public function remove($post=array())
	{
		if(is_numeric($post))
		{
			$id=$post;

			unset($post);

			$post=array($id);
		}

		// print_r($post);die();

		$total=count($post);

		$listID="'".implode("','",$post)."'";

		Database::query("delete from multidb where dbid in ($listID)");	

		self::saveCache();

		return true;
	}

	public function update($id,$post=array())
	{	
		$keyNames=array_keys($post);

		$total=count($post);

		$setUpdates='';

		for($i=0;$i<$total;$i++)
		{
			$keyName=$keyNames[$i];
			$setUpdates.="$keyName='$post[$keyName]', ";
		}

		$setUpdates=substr($setUpdates,0,strlen($setUpdates)-2);

		Database::query("update multidb set $setUpdates where dbid='$id'");

		if(!$error=Database::hasError())
		{
			self::saveCache();

			return true;
		}

		return false;
	}


}
?>