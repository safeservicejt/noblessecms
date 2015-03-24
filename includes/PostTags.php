<?php

class PostTags
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

		$field="tagid,tag_title,postid";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by tagid desc';

		$result=array();
		
		$command="select $selectFields from post_tags $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		// Load dbcache

		$loadCache=DBCache::get($queryCMD);

		if($loadCache!=false)
		{
			return $loadCache;
		}

		// end load

		$query=Database::query($queryCMD);

		if(isset(Database::$error[5]))
		{
			return false;
		}		
		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				if(isset($row['tag_title']))
				{
					$row['url']=Url::tag($row['tag_title']);
				}
				
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		// Save dbcache
		DBCache::make(md5($queryCMD),$result);
		// end save

		return $result;
		
	}	

	public function render($inputData=array())
	{

		if(!$loadData=self::get($inputData))
		{
			return false;
		}

		$tags='';

		$total=count($loadData);



		for($i=0;$i<$total;$i++)
		{
			$tags=$tags.$loadData[$i]['tag_title'].", ";
		}

		$tags=substr($tags, 0,strlen($tags)-2);

		return $tags;
	}
	public function insert($inputData=array())
	{

		$inputData['tag_title']=strtolower($inputData['tag_title']);

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Database::query("insert into post_tags($insertKeys) values($insertValues)");

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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"postid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";
			
		$command="delete from post_tags where $whereQuery $addWhere";

		Database::query($command);		

		return true;
	}

}
?>