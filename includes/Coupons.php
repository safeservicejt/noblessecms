<?php

class Coupons
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

		$field="couponid,coupon_title,coupon_type,coupon_code,amount,freeshipping,date_start,date_end,date_added,limitperuser,limituse,status";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();
		
		$command="select $selectFields from coupons $whereQuery";

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
				if(isset($row['coupon_title']))
				{
					$row['coupon_title']=String::decode($row['coupon_title']);
				}
				if(isset($row['date_added']))
				{
					$row['date_added']=Render::dateFormat($row['date_added']);						
				}

				if(isset($row['amount']) && isset($row['coupon_type']) && $row['coupon_type']=='money')
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

		return $result;
		
	}	

	public function insert($inputData=array())
	{
		if(isset($inputData['coupon_title']))
		{
			$inputData['coupon_title']=String::encode($inputData['coupon_title']);
		}		

		if(isset($inputData['amount']) && isset($inputData['coupon_type']) && $inputData['coupon_type']=='money')
		{
			$post['amount']=Currency::insertPrice($post['amount']);
		}
		

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Database::query("insert into coupons($insertKeys) values($insertValues)");

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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"couponid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from coupons where $whereQuery $addWhere";

		Database::query($command);	

		return true;
	}

	public function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{
		if(isset($post['coupon_title']))
		{
			$post['coupon_title']=String::encode($post['coupon_title']);
		}		
		
		if(isset($post['amount']) && isset($post['coupon_type']) && $post['coupon_type']=='money')
		{
			$post['amount']=Currency::insertPrice($post['amount']);

			// $inputData['amountFormat']=$getData['format'];
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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"couponid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update coupons set $setUpdates where $whereQuery $addWhere");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>