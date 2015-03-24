<?php

class Vouchers
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

		$field="voucherid,code,amount,date_added,status";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();
		
		$command="select $selectFields from gift_vouchers $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

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
				if(isset($row['date_added']))
				{
					$row['date_added']=Render::dateFormat($row['date_added']);						
				}				

				if(isset($row['amount']))
				{
					$getData=Currency::parsePrice($row['amount']);

					$row['amount']=$getData['real'];

					$row['amountFormat']=$getData['format'];
				}
											
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}

		// $result=self::plugin_hook_contact($result);

		return $result;
		
	}	

	public function insert($inputData=array())
	{
		if(isset($inputData['amount']))
		{
			$inputData['amount']=Currency::insertPrice($inputData['amount']);
		}

		$inputData['date_added']=date('Y-m-d h:i:s');
		

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		// Plugins::load('before_insert_contactus',$inputData);

		Database::query("insert into gift_vouchers($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['voucherid']=$id;

			// Plugins::load('after_insert_contactus',$inputData);

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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"voucherid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";
		
		$command="delete from gift_vouchers where $whereQuery $addWhere";	

		Database::query($command);	

		return true;
	}

	public function update($listID,$post=array(),$whereQuery='')
	{	
		if(is_numeric($listID))
		{
			$catid=$listID;

			unset($listID);

			$listID=array($catid);
		}

		$listIDs="'".implode("','",$listID)."'";

		if(isset($post['amount']))
		{
			$post['amount']=Currency::insertPrice($post['amount']);
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
				
		$whereQuery=isset($whereQuery[5])?$whereQuery:"voucherid in ($listIDs)";

		Database::query("update gift_vouchers set $setUpdates where $whereQuery");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>