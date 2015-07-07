<?php

class MangaCategories
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

		$field="mangaid,catid";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by mangaid desc';

		$result=array();
		
		$command="select $selectFields from manga_categories $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		// Load dbcache

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:15;

		if($cache=='yes')
		{
			// Load dbcache

			$loadCache=DBCache::get($queryCMD,$cacheTime);

			if($loadCache!=false)
			{
				return $loadCache;
			}

			// end load			
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

	public function getLinkByMangaId($mangaid)
	{
		$loadData=Categories::get(array(
			'query'=>"select c.* from categories c, manga_categories mc where mc.mangaid='$mangaid' AND mc.catid=c.catid order by c.title asc"
			));

		$total=count($loadData);

		$li='';

		for ($i=0; $i < $total; $i++) { 

			$li.='<a href="'.$loadData[$i]['url'].'" title="Category '.$loadData[$i]['title'].'"><span class="label label-default">'.$loadData[$i]['title'].'</span></a>, ';
		}

		$li=substr($li,0,strlen($li)-2);

		return $li;

	}

	public function getLink($resultData=array())
	{
		$total=count($resultData);

		$li='';

		for ($i=0; $i < $total; $i++) { 

			if(!isset($resultData[$i]['cattitle']) || !isset($resultData[$i]['friendly_url']))
			{
				continue;
			}

			$theUrl=Categories::url($resultData[$i]);

			$li.=', <a href="'.$theUrl.'">'.$resultData[$i]['cattitle'].'</a>';

		}

		return $li;
	}

	public function insert($inputData=array())
	{

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Database::query("insert into manga_categories($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	
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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"mangaid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update manga_categories set $setUpdates where $whereQuery $addWhere");

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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"mangaid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";
			
		$command="delete from manga_categories where $whereQuery $addWhere";

		Database::query($command);		

		return true;
	}

}
?>