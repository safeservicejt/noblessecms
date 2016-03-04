<?php

class Cronjobs
{
	//Cronjobs::add(ROOT_PATH.'ac.php','autoPostProcess',5,'minutes')

	public static function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="cronid,timenumber,timetype,timeinterval,last_update,jobdata,date_added,status";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by cronid desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;

		$command="select $selectFields from ".$prefix."cronjobs $whereQuery $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$query=Database::query($queryCMD);

		$inputData['isHook']=isset($inputData['isHook'])?$inputData['isHook']:'yes';
		
		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				if(isset($row['jobdata']))
				{
					$row['jobdata']=String::jsonToArray($row['jobdata']);
				}

				$row['date_addedFormat']=Render::dateFormat($row['date_added']);	
											
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}

		// print_r($result);die();

		return $result;
		
	}	

	public static function url($id=0)
	{
		$url=Url::cronjob($id);

		return $url;
	}

	public static function run()
	{
		$loadData=self::get();	


		$total=count($loadData);

		if(!isset($loadData[0]['cronid']))
		{
			return false;
		}	


		for($i=0;$i<$total;$i++)
		{
			if(!self::isReady($loadData[$i]))
			{
				// return false;
				continue;
			}

			self::runCron($loadData[$i]);	

			self::updateActive($loadData[$i]['cronid']);
		}
	}
	public static function runSingle($id)
	{
		$thisTime=date('Y-m-d H:i:s');

		$loadData=self::get(array(
			'where'=>"where cronid='$id'"
			));

		if(!isset($loadData[0]['cronid']))
		{
			return false;
		}

		if(!self::isReady($loadData[0]))
		{
			return false;
		}

		self::runCron($loadData[0]);

		self::updateActive($id);
	}

	public static function runCron($loadData)
	{
		$jobData=$loadData['jobdata'];

		$path=$jobData['path'];

		$func=$jobData['func'];

		if(!preg_match('/.*?\.php/i', $path))
		{
			return false;
		}

		if(!file_exists($path))
		{
			self::remove(array($loadData['cronid']));
			
			return false;
		}

		include($path);

		if(isset($func[1]) && function_exists($func))
		{
			$func();
		}
	}

	public static function isReady($loadData)
	{
		$timeNumber=strtotime($loadData['last_update']);

		$thisTime=time();

		$timeInterval=(int)$loadData['timeinterval']*60;

		$tmp=(int)$thisTime-(int)$timeInterval;

		if((int)$tmp < (int)$timeNumber)
		{
			return false;
		}

		return true;
	}

	public static function isExists($command)
	{
	    $cronjob_exists=false;

	    exec('crontab -l', $crontab);


	    if(isset($crontab)&&is_array($crontab)){

	        $crontab = array_flip($crontab);

	        if(isset($crontab[$command])){

	            $cronjob_exists=true;

	        }

	    }
	    return $cronjob_exists;
	}

	public static function addLine($command)
	{
	    if(is_string($command)&&!empty($command)&&self::isExists($command)===FALSE){

	        //add job to crontab
	        exec('echo -e "`crontab -l`\n'.$command.'" | crontab -', $output);

	    }

	    return $output;		
	}

	public static function updateActive($id)
	{
		$thisTime=date('Y-m-d H:i:s');

		self::update($id,array('last_update'=>$thisTime));
	}

	public static function add($filePath,$fileFunc='',$timeInterval=5,$timeType='minutes')
	{
		$data=array(
				'path'=>$filePath,
				'func'=>$fileFunc
				);

		$loadData=self::get(array(
			'where'=>"where jobdata='".json_encode($data)."'"
			));

		if(isset($loadData[0]['cronid']))
		{
			return false;
		}

		$timeType=($timeType=='min')?'minutes':$timeType;
		$timeType=($timeType=='mins')?'minutes':$timeType;
		$timeType=($timeType=='hour')?'hours':$timeType;
		$timeType=($timeType=='day')?'days':$timeType;
		$timeType=($timeType=='month')?'months':$timeType;
		$timeType=($timeType=='year')?'years':$timeType;


		$timeDB=array('minutes','hours','days','months','years');

		if(!in_array($timeType, $timeDB))
		{
			return false;
		}

		$insertData=array(
			'timenumber'=>$timeInterval,
			'timetype'=>$timeType,
			'timeinterval'=>0,
			'jobdata'=>array(
				'path'=>$filePath,
				'func'=>$fileFunc
				)
			);

		$totalTime=$timeInterval;


		switch ($timeType) {
			case 'hours':
				$totalTime=(int)$timeInterval*60;
				break;
			case 'days':
				$totalTime=((int)$timeInterval*60)*24;
				break;
			case 'months':
				$totalTime=(((int)$timeInterval*60)*24)*30;
				break;
			case 'years':
				$totalTime=((((int)$timeInterval*60)*24)*30)*365;
				break;

		}

		$insertData['timeinterval']=$totalTime;

		$insertData['jobdata']=json_encode($insertData['jobdata']);

		// print_r($insertData);die();

		if(!$id=self::insert($insertData))
		{
			return false;
		}

		return $id;

	}

	public static function deleteFromPlugin($pluginName='')
	{
		Database::query("delete from ".Database::getPrefix()."cronjobs where jobdata LIKE '%/$pluginName/%'");
		Database::query("delete from ".Database::getPrefix()."cronjobs where jobdata LIKE '%\\$pluginName\%'");

	}

	public static function delete($filePath,$fileFunc='')
	{
		$data=array(
				'path'=>$filePath,
				'func'=>$fileFunc
				);

		$data=json_encode($data);

		Database::query("delete from ".Database::getPrefix()."cronjobs where jobdata='$data'");
	}
	
	public static function insert($inputData=array())
	{

		$inputData['date_added']=date('Y-m-d H:i:s');

		$inputData['last_update']=date('Y-m-d H:i:s');

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";



		Database::query("insert into ".Database::getPrefix()."cronjobs($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			return $id;		
		}

		return false;
	
	}
	public static function remove($post=array(),$whereQuery='',$addWhere='')
	{
		if(is_numeric($post))
		{
			$id=$post;

			unset($post);

			$post=array($id);
		}

		$total=count($post);

		$listID="'".implode("','",$post)."'";
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"cronid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("delete from ".Database::getPrefix()."cronjobs where $whereQuery $addWhere");	

		return true;
	}

	public static function update($id,$post=array(),$whereQuery='',$addWhere='')
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

		$whereQuery=isset($whereQuery[5])?$whereQuery:" cronid='$id'";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update ".Database::getPrefix()."cronjobs set $setUpdates where $whereQuery $addWhere");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}