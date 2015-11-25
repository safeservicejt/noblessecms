<?php

class Country
{

	public static function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="country_id,name,iso_code_2,iso_code_3";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by name asc';

		$result=array();
		
		$command="select $selectFields from ".Database::getPrefix()."country $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache

			$loadCache=Cache::loadKey('dbcache/system/country/'.$md5Query,$cacheTime);

			if($loadCache!=false)
			{
				$loadCache=unserialize($loadCache);
				return $loadCache;
			}

			// end load			
		}


		$query=Database::query($queryCMD);
		
		if(isset(Database::$error[5]))
		{
			return false;
		}

		$inputData['isHook']=isset($inputData['isHook'])?$inputData['isHook']:'yes';
		
		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{		
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		
		// Save dbcache
		Cache::saveKey('dbcache/system/country/'.$md5Query,serialize($result));
		// end save


		return $result;
		
	}

	public static function loadCache()
	{

		$loadData=Cache::loadKey('listCountries'.Database::getPrefix(),-1);

		$loadData=unserialize($loadData);

		return $loadData;
		
	}

	public static function saveCache()
	{
		$loadData=self::get(array(
			'orderby'=>'order by name asc'
			));
		// ".Database::getPrefix()."
		File::create(ROOT_PATH.'application/caches/listCountries'.Database::getPrefix().'.cache',serialize($loadData));
	}

	public static function makeSelect()
	{
		$loadData=self::loadCache();

		$total=count($loadData);

		$li='';

		if(isset($loadData[0]['name']))
		for ($i=0; $i < $total; $i++) { 
			$li.='<option value="'.$loadData[$i]['iso_code_2'].'">'.$loadData[$i]['name'].'</option>';
		}

		return $li;
	}

	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);

		$addMultiAgrs='';

		if(isset($inputData[0]['name']))
		{
		    foreach ($inputData as $theRow) {


				$keyNames=array_keys($theRow);

				$insertKeys=implode(',', $keyNames);

				$keyValues=array_values($theRow);

				$insertValues="'".implode("','", $keyValues)."'";

				$addMultiAgrs.="($insertValues), ";

		    }

		    $addMultiAgrs=substr($addMultiAgrs, 0,strlen($addMultiAgrs)-2);
		}
		else
		{		

			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		Database::query("insert into ".Database::getPrefix()."country($insertKeys) values".$addMultiAgrs);

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			return $id;	
		}

		return false;
	
	}

	public static function remove($post=array(),$whereQuery='',$addWhere='')
	{


		if(is_numeric($post))
		{
			$id=$post;

			unset($post);

			$post=array($id);
		}

		$total=count($post);

		$listID="'".implode("','",$post)."'";

		$whereQuery=isset($whereQuery[5])?$whereQuery:"country_id in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from ".Database::getPrefix()."country where $whereQuery $addWhere";

		Database::query($command);	

		return true;
	}

	public static function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{


		if(is_numeric($listID))
		{
			$catid=$listID;

			unset($listID);

			$listID=array($catid);
		}

		$listIDs="'".implode("','",$listID)."'";		
				
		$keyNames=array_keys($post);

		$total=count($post);

		$setUpdates='';

		for($i=0;$i<$total;$i++)
		{
			$keyName=$keyNames[$i];
			$setUpdates.="$keyName='$post[$keyName]', ";
		}

		$setUpdates=substr($setUpdates,0,strlen($setUpdates)-2);
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"country_id in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update ".Database::getPrefix()."country set $setUpdates where $whereQuery $addWhere");
		
		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>