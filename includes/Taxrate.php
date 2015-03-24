<?php

class Taxrate
{
	public static $load=array();

	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="taxid,nodeid,tax_title,tax_rate,tax_type,country_short,date_added,status";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added asc';

		$result=array();

		// $dbName=Multidb::renderDb('tax_rates');

		$command="select $selectFields from tax_rates $whereQuery $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$query=Database::query($queryCMD);
		
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


		return $result;
		
	}	


	public function thisIP()
	{
		$country=Country::thisIP();

		$countryCode=strtolower($country['iso_code_2']);

		// $tax=self::get(array(
		// 	'where'=>"where country_short LIKE '%$countryCode%'"
		// 	));

		// if(!isset($tax[0]['taxid']))
		// {
		// 	$resultData['tax_title']='Free Tax';
		// 	$resultData['tax_rate']=0;
		// 	$resultData['tax_type']='fixedamount';
		// }
		// else
		// {
		// 	$resultData=$tax[0];

		// 	$resultData['country']=$countryCode;			
		// }

		$tax=self::get(array(
			'orderby'=>"order by tax_title asc"
			));

		$total=count($tax);

		$resultData=array();

		if($total==0)
		{
			$resultData['tax_title']='Free Shipping';
			$resultData['tax_rate']=0;
			$resultData['tax_type']='fixedamount';
		}
		else
		{
			for($i=0;$i<$total;$i++)
			{
				if($countryCode=='worldwide')
				{
					$resultData=$tax[$i];
				}				

				if($countryCode==strtolower($tax[$i]['country_short']))
				{
					$resultData=$tax[$i];

					break;
				}
			}
		}


		return $resultData;
	}

	public function insert($inputData=array())
	{
		$inputData['date_added']=date('Y-m-d h:i:s');

		// $nodeid=String::genNode();

		// $inputData['nodeid']=$nodeid;

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		// $dbName=Multidb::getCurrentDb();

		Database::query("insert into tax_rates($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			// Multidb::increasePost();	

			return $id;		
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

		$total=count($post);

		$listID="'".implode("','",$post)."'";

		// $dbName=Multidb::renderDb('tax_rates');

		Database::query("delete from tax_rates where taxid in ($listID)");		
	
		Multidb::decreasePost($total);	

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

		// $dbName=Multidb::renderDb('tax_rates');

		Database::query("update tax_rates set $setUpdates where taxid='$id'");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>