<?php

class Affiliate
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

		$field="userid,earned,commission,payment_method,payment_account,cheque,bank_name,bank_branch_number,bank_swift_code,bank_account_name,bank_account_number";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by userid desc';

		$result=array();
		
		$command="select $selectFields from affiliate $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$query=Database::query($queryCMD);
		
		if(isset(Database::$error[5]))
		{
			return false;
		}
		// echo Database::$error;

		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{

				if(isset($row['earned']))
				{
					$getData=Currency::parsePrice($row['earned']);

					$row['earned']=$getData['real'];

					$row['earnedFormat']=$getData['format'];

					// print_r($row);die();
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

	public function loadCache()
	{
		if($match=Uri::match('^affiliate\/(\d+)$'))
		{

			$code=strtolower(trim($match[1]));

			if((int)$code==0)
			{
				Redirect::to(ROOT_URL);
			}

			$_SESSION['affiliateid']=$code;

			Redirect::to(ROOT_URL);
		}		
	}



	public function insert($inputData=array())
	{

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Database::query("insert into affiliate($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{

			return true;		
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
	
	
		$command="delete from affiliate where $whereQuery $addWhere";

		Database::query($command);	

		return true;
	}

	public function update($id,$post=array(),$whereQuery='',$addWhere='')
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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"userid='$id'";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update affiliate set $setUpdates where $whereQuery $addWhere");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>