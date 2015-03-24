<?php

class Currency
{

	public static $theList=array();

	public static $theCurrency=array();

	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="currencyid,title,code,symbolLeft,symbolRight,dataValue,status";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by currencyid desc';

		$result=array();

		$command="select $selectFields from currency $whereQuery $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$query=Database::query($queryCMD);
		
		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				if(isset($row['title']))
				{
					$row['title']=String::decode($row['title']);
				}
				if(isset($row['code']))
				{
					$row['code']=String::decode($row['code']);
				}
				if(isset($row['symbolLeft']))
				{
					$row['symbolLeft']=String::decode($row['symbolLeft']);
				}
				if(isset($row['symbolRight']))
				{
					$row['symbolRight']=String::decode($row['symbolRight']);
				}

				if(isset($row['dataValue']))
				{
					$getData=self::parsePrice($row['dataValue']);

					$row['dataValue']=$getData['real'];

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

	public function loadCache($code)
	{
		if($match=Uri::match('^currency\/(\w+)$'))
		{

			$code=strtolower(trim($match[1]));

			$_SESSION['currency']=$code;

			Redirect::to(ROOT_URL);
		}


		if(!$loadData=Cache::loadKey('listCurrency',-1))
		{
			return false;
		}		

		$code=strtolower($code);

		$loadData=json_decode($loadData,true);

		$total=count($loadData);

		$listID=array_keys($loadData);

		for($i=0;$i<$total;$i++)
		{
			$theID=$listID[$i];

			$theCode=strtolower($loadData[$theID]['code']);

			if($theCode==$code)
			{
				self::$theCurrency=$loadData[$theID];

				break;
			}
		}

		// print_r(self::$theCurrency);die();
	}


	public function insert($inputData=array())
	{
		if(isset($inputData['dataValue']))
		{
			$inputData['dataValue']=self::insertPrice($inputData['dataValue']);
		}

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Database::query("insert into currency($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['id']=$id;

			// $inputData['currencyid']=$id;

			self::saveCache();

			return $id;		
		}

		return false;
	
	}

	public function insertPrice($inputPrice)
	{
		$resultData=$inputPrice;

		if((double)$resultData==0)
		{
			return $resultData;
		}

		$loadData=self::$theCurrency;

		// print_r($loadData);die();
		
		$theRate=(double)$loadData['dataValue'];

		$resultData=(double)$inputPrice/(double)$theRate;

		return $resultData;
	}

	public function parsePrice($inputPrice)
	{

		// return $inputPrice;
		
		$resultData=(double)$inputPrice;

		$theRate=isset(GlobalCMS::$load['currencyRate'])?GlobalCMS::$load['currencyRate']:1;

		$defaultCode=isset(GlobalCMS::$load['currency'])?GlobalCMS::$load['currency']:'USD';

		$symbolLeft='$';

		$symbolRight='';

		$outputData=array();

		// print_r(GlobalCMS::$load);die();

		$loadData=self::$theCurrency;

		$defaultCode=GlobalCMS::$load['currency'];

		// GlobalCMS::$load['currencyRate']=(double)$loadData[$theID]['dataValue'];

		$theRate=(double)$loadData['dataValue'];

		$symbolLeft=String::decode($loadData['symbolLeft']);

		$symbolRight=String::decode($loadData['symbolRight']);		

		$resultData=(double)$theRate*(double)$inputPrice;

		$outputData['format']=$symbolLeft.' '.Render::numberFormat($resultData).' '.$symbolRight;

		$outputData['format']=trim($outputData['format']);

		$outputData['real']=$resultData;

		// print_r($outputData);

		return $outputData;
	}

	public function saveCache()
	{
		$loadData=self::get(array(
			'orderby'=>'order by title asc'
			));

		$total=count($loadData);

		$resultData=array();

		for($i=0;$i<$total;$i++)
		{
			$theID=$loadData[$i]['currencyid'];

			$resultData[$theID]=$loadData[$i];
		}

		Cache::saveKey('listCurrency',json_encode($resultData));

	}
	public function remove($post=array(),$whereQuery='',$addWhere='')
	{
		if(is_numeric($post))
		{
			$id=$post;

			unset($post);

			$post=array($id);
		}

		$total=count($post);

		$listID="'".implode("','",$post)."'";

		$whereQuery=isset($whereQuery[5])?$whereQuery:"currencyid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("delete from currency where $whereQuery $addWhere");		

		self::saveCache();
	

		return true;
	}

	public function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{
		if(is_numeric($listID))
		{
			$catid=$listID;

			unset($listID);

			$listID=array($catid);
		}

		$listIDs="'".implode("','",$listID)."'";		

		if(isset($post['dataValue']))
		{
			$post['dataValue']=self::insertPrice($post['dataValue']);
		}

		$keyNames=array_keys($post);

		$total=count($post);

		$setUpdates='';

		for($i=0;$i<$total;$i++)
		{
			$keyName=$keyNames[$i];
			$setUpdates.="$keyName='$post[$keyName]', ";
		}
		
		$setUpdates=substr($setUpdates,0,strlen($setUpdates)-2);
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"currencyid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update currency set $setUpdates where $whereQuery $addWhere");

		self::saveCache();

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>