<?php

class prodImages
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

		$field="productid,image,sort_order";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by productid desc';

		$result=array();
		
		$command="select $selectFields from products_images $whereQuery";

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
				if(isset($row['image']))
				{
					$row['imageUrl']=Render::thumbnail($row['image']);
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

	public function insert($inputData=array())
	{


		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Database::query("insert into products_images($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			
			return true;		
		}

		return false;
	
	}
	public function update($id,$post=array(),$whereQuery='')
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

		Database::query("update products_images set $setUpdates where productid='$id' $whereQuery");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}	
	public function remove($post=array(),$whereQuery='')
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

		$loadData=self::get(array(
			'where'=>"where productid IN ($listID) $whereQuery"
			));

		$totalImages=count($loadData);

		if(isset($loadData[0]['image']))
		for($i=0;$i<$totalImages;$i++)
		{
			// $image=ROOT_PATH.$loadData[$i]['image'];

			$shortPath=$loadData[$i]['image'];

			$fullPath=ROOT_PATH.$shortPath;

			if(file_exists($fullPath))
			{
				unlink($fullPath);

				$fullPath=dirname($fullPath);

				rmdir($fullPath);
			}
		}
		
		$command="delete from products_images where productid in ($listID) $whereQuery";

		Database::query($command);	
		return true;
	}


}
?>