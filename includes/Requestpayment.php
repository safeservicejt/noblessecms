<?php

class Requestpayment
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

		$field="requestid,userid,total_request,date_added,status,comments";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();
		
		$command="select $selectFields from request_payments $whereQuery";

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
				$row['date_added']=Render::dateFormat($row['date_added']);	

				if(isset($row['total_request']))
				{
					$getData=Currency::parsePrice($row['total_request']);

					$row['total_request']=$getData['real'];

					$row['total_requestFormat']=$getData['format'];
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

	public function completed($listID=array())
	{
		if(!isset($listID[0]))
		{
			return false;
		}
		
		$reList="'".implode("','", $listID)."'";

		Database::query("update request_payments set status='1' where requestid IN ($reList)");
	}


	public function insert($inputData=array())
	{
		$inputData['date_added']=date('Y-m-d h:i:s');

		$inputData['comments']=strip_tags($inputData['comments']);

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		// Plugins::load('before_insert_contactus',$inputData);

		Database::query("insert into request_payments($insertKeys) values($insertValues)");

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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"requestid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";
			
		$command="delete from request_payments where $whereQuery $addWhere";

		Database::query($command);		

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

		$keyNames=array_keys($post);

		$total=count($post);

		$setUpdates='';

		for($i=0;$i<$total;$i++)
		{
			$keyName=$keyNames[$i];
			$setUpdates.="$keyName='$post[$keyName]', ";
		}

		$setUpdates=substr($setUpdates,0,strlen($setUpdates)-2);
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"requestid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update request_payments set $setUpdates where $whereQuery $addWhere");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>