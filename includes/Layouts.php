<?php

class Layouts
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

		$field="layoutid,layoutname";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by layoutid desc';

		$result=array();

		$command="select $selectFields from layouts $whereQuery $orderBy";

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

		Cache::saveKey('listLayouts',json_encode($result));

		// $result=self::plugin_hook_page($result);

		return $result;
		
	}

	public function has($layoutName)
	{
		if(!isset(GlobalCMS::$layouts[$layoutName]))
		{
			if($loadData=Cache::loadKey('listLayouts',-1))
			{
				return false;
			}

			$loadData=json_decode($loadData,true);

			if(!isset($loadData[$layoutName]))
			{
				return false;
			}
		}

		return true;

	}

	public function add($post=array())
	{
		$title=trim($post['layoutname']);

		if(!isset($title[1]))return false;

		$title=addslashes($title);

		// Plugins::load('before_insert_page',$post);

		Database::query("insert into layouts(layoutname) values('$title')");

		$error=Database::$error;

		if(isset($error[5]))
		{
			return false;
		}

		$id=Database::insert_id();

		$post['layoutid']=$id;

		Cache::removeKey('listLayouts');

		self::get();
		
		// Plugins::load('after_insert_page',$post);

		return $id;		
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

		Database::query("update layouts set $setUpdates where layoutid='$id'");

		if(!$error=Database::hasError())
		{

			Cache::removeKey('listLayouts');			
			return true;

		}

		return false;
	}	

	public function remove($post=array())
	{


		if(is_numeric($post))
		{
			$catid=$post;

			unset($post);

			$post=array($catid);
		}

		$total=count($post);

		$listID="'".implode("','",$post)."'";

		Database::query("delete from layouts where layoutid in ($listID)");		

		Cache::removeKey('listLayouts');
		
		self::get();		
		// Database::query("delete from products_pages where pageid in ($listID)");		

		return true;
	}	
}
?>