<?php

class prodPages
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

		$field="productid,pageid";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by productid desc';

		$result=array();
		
		$command="select $selectFields from products_pages $whereQuery";

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


		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Database::query("insert into products_pages($insertKeys) values($insertValues)");

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
		
		if(!isset($post[0][4]))
		{
			return false;
		}


		$total=count($post);

		$listID="'".implode("','",$post)."'";
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"productid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";
			
		$command="delete from products_pages where $whereQuery $addWhere";

		Database::query($command);	
		
		return true;
	}


}
?>