<?php

class Paymentmethods
{

	public static $methods=array();

	public static $isInstall='no';

	public static $isUninstall='no';

	public static $folderName='';

	public static $setting='no';

	public static $load=array();

	public function loadMethods()
	{
		if(!$loadData=Cache::loadKey('listPMethods',-1))
		{
			return false;
		}

		$loadData=json_decode($loadData,true);

		$keyNames=array_keys($loadData);

		$total=count($loadData);

		for($i=0;$i<$total;$i++)
		{
			$keyName=$keyNames[$i];

			if((int)$loadData[$keyName]['status']==1)
			{
				self::$methods[$keyName]=$loadData[$keyName];
			}
		}
	}

	public function listMethods()
	{
		$totalMethods=count(self::$methods);

		if($totalMethods==0)
		{
			self::loadMethods();
		}

		$totalMethods=count(self::$methods);

		$keyNames=array_keys(self::$methods);

		$loadData=array();

		for($i=0;$i<$totalMethods;$i++)
		{
			$keyName=$keyNames[$i];

			$loadData[$i]=self::$methods[$keyName];
		}		


		return $loadData;

	}

	public function loadSetting($dirName,$fileName='setting.json')
	{
		$path=ROOT_PATH.'contents/paymentmethods/'.$dirName.'/'.$fileName;

		if(!file_exists($path))
		{
			return false;
		}

		$data=json_decode(file_get_contents($path),true);

		return $data;

	}


	public function load($actionName='',$folderName='',$inputData=array())
	{
		$totalMethods=count(self::$methods);

		if($totalMethods==0)
		{
			self::loadMethods();
		}

		switch ($actionName) {
			case 'methods_assoc':

				return self::$methods;

				break;
			case 'methods_array':

				return self::listMethods();

				break;

			case 'require_form_on_checkout':

				$li=self::require_form();

				return $li;

				break;

			case 'after_click_confirm_check_out':

				$status=self::after_click_confirm_check_out($folderName,$inputData);

				return $status;

				break;
		}
	}

	public function after_click_confirm_check_out($folderName,$inputData=array())
	{
		$totalMethods=count(self::$methods);

		if($totalMethods==0)
		{
			self::loadMethods();
		}

		if(!isset(self::$methods[$folderName]))
		{
			return true;
		}

		$filePath=PMETHOD_PATH.$folderName.'/index.php';

		$func=self::$methods[$folderName]['method_data']['after_click_confirm_check_out'];

		$status=true;

		if(!isset($func[1]))
		{
			return true;
		}

		if(file_exists($filePath))
		{
			if(!function_exists($func))
			{
				require($filePath);
			}

			// Return completed|error|process_page
			$status=$func($inputData);

			return $status;
		}	

		return false;	
	}

	public function require_form()
	{
		$li='';

		$totalMethods=count(self::$methods);

		if($totalMethods==0)
		{
			self::loadMethods();
		}

		$keyNames=array_keys(self::$methods);

		$total=count($keyNames);

		if($total==0)
		{
			return '';
		}

		// echo $total;

		$status=0;

		$func='';

		$filePath='';

		for($i=0;$i<$total;$i++)
		{
			$folderName=$keyNames[$i];

			$func=self::$methods[$folderName]['method_data']['require_form_on_checkout'];

			$status=self::$methods[$folderName]['status'];

			if(!isset($func[1]) || (int)$status==0)
			{
				continue;
			}

			$filePath=PMETHOD_PATH.$folderName.'/index.php';

			if(file_exists($filePath))
			{
				if(!function_exists($func))
				{
					require($filePath);
				}

				$li.='<div class="row paymentForm requireForm_'.$folderName.'"><div class="col-lg-12">'.$func().'</div></div>';
			}
		}

		return $li;

	}

	public function install($funcName='')
	{
		if(self::$isInstall=='no')
		{
			return false;
		}

		$funcName();
	}
	public function systemInstall($folderName)
	{
		if(self::$isInstall=='no')
		{
			return false;
		}

		$methodData=array();

		$require_form=isset(self::$load['require_form_on_checkout'])?self::$load['require_form_on_checkout']:'';

		$after_checkout=isset(self::$load['after_click_confirm_check_out'])?self::$load['after_click_confirm_check_out']:'';

		$methodData['require_form_on_checkout']=$require_form;

		$methodData['after_click_confirm_check_out']=$after_checkout;

		$methodData['title']=self::$load['title'];

		$methodData['foldername']=self::$folderName;

		$methodData=json_encode($methodData);

		$loadData=array(
			'title'=>self::$load['title'],
			'foldername'=>self::$folderName,
			'method_data'=>$methodData,
			'status'=>0

			);

		self::insert($loadData);

		self::saveCache($loadData);
	}


	public function uninstall($funcName='')
	{
		if(self::$isUninstall=='no')
		{
			return false;
		}

		$funcName();
	}
	public function systemUninstall($folderName)
	{
		if(self::$isUninstall=='no')
		{
			return false;
		}

		// $dbName=Multidb::renderDb('payment_methods');

		Database::query("delete from payment_methods where foldername='$folderName'");

		self::removeCache($folderName);
	}

	public function updateMethod($folderName,$status='1')
	{
		if(!isset($folderName[1]))
		{
			return false;
		}

		if(!$loadData=Cache::loadKey('listPMethods',-1))
		{
			return false;
		}

		// $dbName=Multidb::renderDb('payment_methods');

		Database::query("update payment_methods set status='$status' where foldername='$folderName'");		

		$loadData=json_decode($loadData,true);

		$loadData[$folderName]['status']=$status;

		Cache::saveKey('listPMethods',json_encode($loadData));

	}

	public function removeCache($folderName)
	{
		if(!$loadData=Cache::loadKey('listPMethods',-1))
		{
			return true;
		}

		$loadData=json_decode($loadData,true);

		if(isset($loadData[$folderName]))
		{
			unset($loadData[$folderName]);
		}

		$loadData=json_encode($loadData);

		Cache::saveKey('listPMethods',$loadData);

		return true;
	}

	public function saveCache($inputData)
	{
		$loadData='';

		if(!$loadData=Cache::loadKey('listPMethods',-1))
		{
			$loadData=array();
		}
		else
		{
			$loadData=json_decode($loadData,true);
		}

		$folderName=$inputData['foldername'];

		$inputData['method_data']=json_decode($inputData['method_data'],true);

		$loadData[$folderName]=$inputData;

		$loadData=json_encode($loadData);

		Cache::saveKey('listPMethods',$loadData);
	}




	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="methodid,title,foldername,method_data,status";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by methodid desc';

		$result=array();

		// $dbName=Multidb::renderDb('payment_methods');

		$command="select $selectFields from payment_methods $whereQuery $orderBy";

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


		return $result;
		
	}	
	public function insert($inputData=array())
	{


		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		// $dbName=Multidb::getCurrentDb();
		Database::query("insert into payment_methods($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			return $id;		
		}

		return false;
	
	}
	public function remove($post=array())
	{


		if(is_numeric($post))
		{
			$id=$post;

			unset($post);

			$post=array($id);
		}

		$total=count($post);

		$listID="'".implode("','",$post)."'";

		// $dbName=Multidb::renderDb('payment_methods');

		Database::query("delete from payment_methods where methodid in ($listID)");	

		return true;
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

		// $dbName=Multidb::renderDb('payment_methods');

		Database::query("update payment_methods set $setUpdates where methodid='$id'");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>