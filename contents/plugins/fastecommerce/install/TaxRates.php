<?php

class TaxRates
{
	public static $data=array();

	public static function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$moreFields=isset($inputData['moreFields'])?','.$inputData['moreFields']:'';

		$field="id,title,amount,type,countries".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by id desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;
		
		$command="select $selectFields from ".$prefix."taxrates $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache
			$loadCache=Cache::loadKey('dbcache/system/taxrates/'.$md5Query,$cacheTime);

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

				if(isset($row['countries']) && isset($row['countries'][5]))
				{
					$row['countries']=unserialize($row['countries']);
				}
				if(isset($row['amount']))
				{
					if($row['type']=='percent')
					{
						$row['amountFormat'].=' %';
					}
					else
					{
						$row['amountFormat']=FastEcommerce::money_format($row['amount']);
					}
					
				}
									
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		// Save dbcache
		Cache::saveKey('dbcache/system/taxrates/'.$md5Query,serialize($result));

		// end save


		return $result;
		
	}

	public static function getTax($country='')
	{
		$loadData=self::loadCache($country);

		self::$data=$loadData;

		$totalMoney=0;

		$loadCart=Cart::loadCache(Http::get('ip'));

		$result=self::cal($loadCart['total']);

		return $result;
	}

	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/dbcache/system/taxrates/';

		return $result;
	}	

	public static function loadCache($countryName='all')
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/countries/';

		$amount=0;

		$loadData=array();

		if(file_exists($savePath.$countryName.'_taxrate.cache'))
		{
			$loadData=unserialize(file_get_contents($savePath.$countryName.'_taxrate.cache'));
		}
		else
		{
			$loadData=unserialize(file_get_contents($savePath.'taxrate.cache'));
		}

		self::$data=$loadData;

		return $loadData;
	}

	public static function removeCache($inputData=array())
	{
		$listID="'".implode("','", $inputData)."'";

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where id IN ($listID)"
			));

		$total=count($loadData);

		$savePath=ROOT_PATH.'contents/fastecommerce/countries/';


		for ($i=0; $i < $total; $i++) { 

			if(!isset($loadData[$i]['id']))
			{
				continue;
			}

			$id=$loadData[$i]['id'];

			$countries=$loadData[$i]['countries'];

			if($countries[0]!='all')
			{
				$totalC=count($countries);

				for ($j=0; $j < $totalC; $j++) { 
					$cName=strtolower($countries[$j]);

					$filePath=$savePath.$cName.'_taxrate.cache';

					if(file_exists($filePath))
					{
						unlink($filePath);
					}

				}
			}	
			else
			{
				$filePath=$savePath.'taxrate.cache';

				if(file_exists($filePath))
				{

					unlink($filePath);
				}
			}
		}


	}

	public static function cal($money=0)
	{
		$result=0;

		if(!isset(self::$data['type']))
		{
			return false;
		}

		if(self::$data['type']=='percent')
		{
			$result=((double)$money*(double)self::$data['amount'])/100;
		}
		else
		{
			$result=(double)self::$data['amount'];
		}

		return $result;
	}

	public static function saveCache($id)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/countries/';

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where id='$id'"
			));

		if(isset($loadData[0]['id']))
		{
			$countries=$loadData[0]['countries'];

			if($countries[0]!='all')
			{
				$total=count($countries);

				for ($i=0; $i < $total; $i++) { 
					$cName=strtolower($countries[$i]);

					$cPath=$savePath.$cName.'_taxrate.cache';

					$saveData=array(
						'type'=>$loadData[0]['type'],
						'amount'=>$loadData[0]['amount'],
						);

					File::create($cPath,serialize($saveData));
				}
			}
			else
			{
				$savePath.='taxrate.cache';

				File::create($savePath,serialize($loadData[0]));
			}

		}
	}

	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);

		$addMultiAgrs='';

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";	

		$addMultiAgrs="($insertValues)";	

		Database::query("insert into ".Database::getPrefix()."taxrates($insertKeys) values".$addMultiAgrs);

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['id']=$id;


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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from ".Database::getPrefix()."taxrates where $whereQuery $addWhere";


		$result=array();


		Database::query($command);	

		// DBCache::removeDir('system/post');

		// DBCache::removeCache($listID,'system/post');

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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update ".Database::getPrefix()."taxrates set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/post');

		// DBCache::removeCache($listIDs,'system/post');



		if(!$error=Database::hasError())
		{
			// self::saveCache();
			return true;
		}

		return false;
	}


}