<?php

class Address
{

	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="userid,company,firstname,lastname,address_1,address_2,city,state,postcode,country,phone,fax";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by userid desc';

		$result=array();
		
		$command="select $selectFields from address $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$query=Database::query($queryCMD);
		
		if(isset(Database::$error[5]))
		{
			return false;
		}

		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				if(isset($row['company']))
				{
					$row['company']=String::decode($row['company']);
				}				
				if(isset($row['firstname']))
				{
					$row['firstname']=String::decode($row['firstname']);
				}				
				if(isset($row['lastname']))
				{
					$row['lastname']=String::decode($row['lastname']);
				}				
				if(isset($row['address_1']))
				{
					$row['address_1']=String::decode($row['address_1']);
				}				
				if(isset($row['address_2']))
				{
					$row['address_2']=String::decode($row['address_2']);
				}				
				if(isset($row['city']))
				{
					$row['city']=String::decode($row['city']);
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


	public function insert($inputData=array())
	{

		if(isset($inputData['company']))
		{
			$inputData['company']=String::encode($inputData['company']);
		}				
		if(isset($inputData['firstname']))
		{
			$inputData['firstname']=String::encode($inputData['firstname']);
		}				
		if(isset($inputData['lastname']))
		{
			$inputData['lastname']=String::encode($inputData['lastname']);
		}				
		if(isset($inputData['address_1']))
		{
			$inputData['address_1']=String::encode($inputData['address_1']);
		}				
		if(isset($inputData['address_2']))
		{
			$inputData['address_2']=String::encode($inputData['address_2']);
		}				
		if(isset($inputData['city']))
		{
			$inputData['city']=String::encode($inputData['city']);
		}				
		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Database::query("insert into address($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			return $id;		
		}

		return false;
	
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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:" userid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";
	
		$command="delete from address where $whereQuery $addWhere";

		Database::query($command);	

		return true;
	}

	public function update($id,$post=array(),$whereQuery='',$addWhere='')
	{
		if(isset($post['company']))
		{
			$post['company']=String::encode($post['company']);
		}				
		if(isset($post['firstname']))
		{
			$post['firstname']=String::encode($post['firstname']);
		}				
		if(isset($post['lastname']))
		{
			$post['lastname']=String::encode($post['lastname']);
		}				
		if(isset($post['address_1']))
		{
			$post['address_1']=String::encode($post['address_1']);
		}				
		if(isset($post['address_2']))
		{
			$post['address_2']=String::encode($post['address_2']);
		}				
		if(isset($post['city']))
		{
			$post['city']=String::encode($post['city']);
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

		$whereQuery=isset($whereQuery[5])?$whereQuery:" userid='$id'";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update address set $setUpdates where $whereQuery $addWhere");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>