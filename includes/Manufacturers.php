<?php

class Manufacturers
{
	public static $listManufacturers=array();

	public function get($inputData=array())
	{
		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="manufacturerid,manufacturer_title,manufacturer_image,date_added,friendly_url,status";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();
		
		$command="select $selectFields from manufacturers $whereQuery";

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
				if(isset($row['manufacturer_title']))
				{
					$row['manufacturer_title']=String::decode($row['manufacturer_title']);
				}

				$row['url']=Url::manufacturer($row);

				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}

		return $result;
	}

	public function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{
		if(isset($post['title']))
		{
			$post['title']=String::encode($post['title']);
		}

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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"manufacturerid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update manufacturers set $setUpdates where $whereQuery $addWhere");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}

	public function url($row=array())
	{
		return Url::manufacturer($row);	
	}

	public function products($inputData=array())
	{
		if(!isset($inputData['manufacturerid']))
			{
				return false;
			}

		$manuid=$inputData['manufacturerid'];

		$inputData['where']=" where manufacturerid='$manuid' AND status='1' ";

		$resultData=Products::get($inputData);

		return $resultData;
	}

	public function add($type='manufacturer',$inputData=array())
	{
		$resultData=array();

		if($type=='manu')
		{
			$type='manufacturer';
		}

		if($type=='thumb')
		{
			$type='image';
		}

		if($type=='thumbnail')
		{
			$type='image';
		}

		switch ($type) {
			case 'manufacturer':
				$resultData=self::insert($post);
				break;

				case 'image':

				$catid=0;
					
				if(!isset($inputData['id']))
				{
					$catid=$inputData['id'];

					if(!isset($inputData['id']))
					{
						return false;						
					}

				}

				$catid=$inputData['id'];
				$resultData=self::insertThumbnail($catid,$post);
				break;
			
			default:
				$resultData=self::insert($post);
				break;
		}

		return $resultData;
	}

	public function insert($inputData=array())
	{
		$title=trim($inputData['manufacturer_title']);

		if(!isset($title[1]))return false;
		
		$inputData['friendly_url']=Url::makeFriendly($inputData['manufacturer_title']);	
		
		if(isset($inputData['manufacturer_title']))
		{
			$inputData['manufacturer_title']=String::encode($inputData['manufacturer_title']);
		}

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Database::query("insert into manufacturers($insertKeys) values($insertValues)");

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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"manufacturerid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$query=Database::query("select manufacturer_image from manufacturers where manufacturerid in ($listID)");

		while($row=Database::fetch_assoc($query))
		{
			$thumbnail=$row['manufacturer_image'];

			if(file_exists(ROOT_PATH.$thumbnail))
			{
				unlink(ROOT_PATH.$thumbnail);
			}
		}
		$command="delete from manufacturers where $whereQuery $addWhere";

		Database::query($command);	

		return true;
	}





}
?>