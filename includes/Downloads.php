
<?php

class Downloads
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

		$field="downloadid,title,filename,remaining,date_added,isreaded";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();


		$command="select $selectFields from downloads $whereQuery $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$query=Database::query($command);
		
		if(isset(Database::$error[5]))
		{
			return false;
		}

		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				$row['date_added']=isset($row['date_added'])?Render::dateFormat($row['date_added']):'';
				
				if(isset($row['downloadid']) && isset($row['title']))
				{
					$row['url']=Url::download($row);						
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

	public function getFile($downloadid)
	{
		$loadData=self::get(array(
			'where'=>"where downloadid='$downloadid'"
			));

		if(!isset($loadData[0]['downloadid']))
		{
			return false;
		}

		Response::download(ROOT_PATH.$loadData[0]['filename']);
	}

	public function uploadFileFromUrl($fileUrl='')
	{
		$valid=Validator::make(array(
			'send.title'=>'min:2|slashes',
			'send.remaining'=>'number|slashes'
			));

		if(!$valid)
		{
			return false;
		}	
		
		if(preg_match('/.*?\.\w+/i', $fileUrl))
		{
			$post=array(
				'title'=>Request::get('send.title'),
				'remaining'=>Request::get('send.remaining','99999')
				);

			if(!$downloadid=self::insert($post))
			{
				return false;
			}

			$fileName=basename($fileUrl);

			$newName=String::randNumber(10);

			preg_match('/.*?\.(\w+)/i', $fileName,$matches);

			$newName=$newName.'.'.$matches[1];

			$shortDir='uploads/files/'.$downloadid;

			mkdir(ROOT_PATH.$shortDir);

			$shortPath=$shortDir.'/'.$fileName;

			$fileData=Http::getDataUrl($fileUrl);

			File::create(ROOT_PATH.$shortPath,$fileData);

			$post=array(
				'filename'=>$shortPath
				);

			self::update($downloadid,$post);

			$resultData=array(
				'path'=>$shortPath,
				'downloadid'=>$downloadid
				);

			return $resultData;
		}

		return false;			
	}

	public function uploadFile($keyName='theFile')
	{
		$valid=Validator::make(array(
			'send.title'=>'min:2|slashes',
			'send.remaining'=>'number|slashes'
			));

		if(!$valid)
		{
			return false;
		}	
		
		if(preg_match('/.*?\.\w+/i', $_FILES[$keyName]['name']))
		{
			$post=array(
				'title'=>Request::get('send.title'),
				'remaining'=>Request::get('send.remaining','999999')
				);

			if(!$downloadid=self::insert($post))
			{
				return false;
			}

			$fileName=$_FILES[$keyName]['name'];

			$newName=String::randNumber(10);

			preg_match('/.*?\.(\w+)/i', $fileName,$matches);

			$newName=$newName.'.'.$matches[1];

			$shortDir='uploads/files/'.$downloadid;

			mkdir(ROOT_PATH.$shortDir);

			$shortPath=$shortDir.'/'.$fileName;

			move_uploaded_file($_FILES[$keyName]['tmp_name'], ROOT_PATH.$shortPath);

			$post=array(
				'filename'=>$shortPath
				);

			self::update($downloadid,$post);

			$resultData=array(
				'path'=>$shortPath,
				'downloadid'=>$downloadid
				);

			return $resultData;
		}

		return false;			
	}


	public function insert($inputData=array())
	{
		if(!isset($inputData['filename'][4]))
		{
			return false;
		}
				
		$inputData['date_added']=date('Y-m-d h:i:s');
		

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Database::query("insert into downloads($insertKeys) values($insertValues)");

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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"downloadid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="select filename from downloads where downloadid in ($listID)";

		$query=Database::query($command);

		if(isset(Database::$error[5]))
		{
			return false;
		}

		while($row=Database::fetch_assoc($query))
		{
			$filepath=$row['filename'];

			if(isset($filepath[4]) && file_exists(ROOT_PATH.$filepath))
			{
				unlink(ROOT_PATH.$filepath);

				$dirpath=dirname(ROOT_PATH.$filepath);

				rmdir($dirpath);
			}
		}
		
		$command="delete from downloads where $whereQuery $addWhere";

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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"downloadid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update downloads set $setUpdates where $whereQuery $addWhere");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>