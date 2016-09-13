<?php

/*
	Order status: Draft | Pending | Approved | Shipping | Canceled | Refund | Completed



*/

class Orders
{

	public static function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$moreFields=isset($inputData['moreFields'])?','.$inputData['moreFields']:'';

		$field="id,date_added,userid,shipping_firstname,shipping_lastname,shipping_company,shipping_address1,shipping_address2,shipping_city,shipping_postcode,shipping_state,shipping_country,shipping_url,shipping_method,shipping_phone,shipping_fax,comment,affiliateid,commission,ip,status,products,vat,before_vat,total,summary".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by id desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;
		
		$command="select $selectFields from ".$prefix."orders $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);

		if($cache=='yes')
		{
			// Load dbcache
			$loadCache=Cache::loadKey('dbcache/system/orders/'.$md5Query,$cacheTime);

			if($loadCache!=false)
			{
				$loadCache=unserialize($loadCache);
				return $loadCache;
			}

			// end load			
		}



		$query=Database::query($queryCMD);
		

		if(isset(Database::$error[5]))
		{
			return false;
		}

		$inputData['isHook']=isset($inputData['isHook'])?$inputData['isHook']:'yes';
	

		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				if(isset($row['comment']))
				{
					$row['comment']=String::decode($row['comment']);
				}


				if(isset($row['summary']) && isset($row['summary'][5]))
				{
					$row['summary']=unserialize($row['summary']);

					// die($row['content']);
				}

				if(isset($row['products']) && isset($row['products'][5]))
				{
					$row['products']=unserialize($row['products']);

					// die($row['content']);
				}

				if(isset($row['date_added']))
				{
					$row['date_addedFormat']=Render::dateFormat($row['date_added']);	
				}

				if(isset($row['id']))
				{
					$row['url']=self::url($row['id']);
				}
									
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		// Save dbcache
		Cache::saveKey('dbcache/system/orders/'.$md5Query,serialize($result));

		// end save


		return $result;
		
	}

	public static function url($id)
	{
		$url=System::getUrl().'admincp/plugins/privatecontroller/fastecommerce/order/view/'.$id;

		return $url;
	}

	public static function upToCategories($addWhere,$total=1)
	{
		Database::query("update ".Database::getPrefix()."categories set orders=orders+$total $addWhere");
	}

	public static function insertProcess()
	{
		$ip=Http::get('ip');

		$loadCart=Cart::$cartData;

		$paymentMethod=$loadCart['payment_method'];

		try {
			Payments::callProcess($paymentMethod,'before_confirm_order');
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

		/*
		Insert order
		*/


		/*
		Insert order
		*/

		try {
			Payments::callProcess($paymentMethod,'after_confirm_order');
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

	}


	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/dbcache/system/orders/';

		return $result;
	}	

	public static function exists($id)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/order/'.$id.'.cache';

		if(!file_exists($savePath))
		{
			return false;
		}

		return true;		
	}
	
	public static function loadCache($id)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/order/'.$id.'.cache';

		$result=false;

		if(file_exists($savePath))
		{
			$result=unserialize(file_get_contents($savePath));
		}
		else
		{
			self::saveCache($id);

			if(!file_exists($savePath))
			{
				$result=false;
			}
			else
			{
				$result=unserialize(file_get_contents($savePath));
			}
		}

		if(is_array($result['products']))
		{
			$totalProd=count($result['products']);

			$listKey=array_keys($result['products']);

			for ($i=0; $i < $totalProd; $i++) { 
				$prodID=$listKey[$i];

				$prodData=Products::loadCache($prodID);

				if(!$prodData)
				{
					continue;
				}

				$result['products'][$prodID]['download_data']=$prodData['download_data'];
			}			
		}


		return $result;
	}

	public static function saveCache($id)
	{
		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where id='$id'"
			));

		if(isset($loadData[0]['id']))
		{
			$loadProd=OrderProducts::get(array(
				'cache'=>'no',
				'where'=>"where orderid='$id'"
				));

			if(isset($loadProd[0]['orderid']))
			{
				$totalProd=count($loadProd);

				for ($i=0; $i < $totalProd; $i++) {

					$productid=$loadProd[$i]['productid'];

					$loadData[0]['products'][$productid]=Products::loadCache($productid);

				}
			}

			$savePath=ROOT_PATH.'contents/fastecommerce/order/'.$id.'.cache';

			File::create($savePath,serialize($loadData[0]));
		}
	}

	public static function saveCacheByProductID($id,$inputID=array())
	{
		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where id='$id'"
			));

		if(isset($loadData[0]['id']))
		{
			$totalProd=count($inputID);

			for ($i=0; $i < $totalProd; $i++) {

				$productid=$inputID[$i];

				$loadData[0]['products'][$productid]=Products::loadCache($productid);
			}

			$savePath=ROOT_PATH.'contents/fastecommerce/order/'.$id.'.cache';

			File::create($savePath,serialize($loadData[0]));
		}
	}

	public static function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);
		CustomPlugins::load('before_order_insert',$inputData);

		$addMultiAgrs='';

		$inputData['date_added']=date('Y-m-d H:i:s');

		if(isset($inputData['summary']))
		{
			$inputData['summary']=serialize($inputData['summary']);
		}

		if(isset($inputData['products']))
		{
			$inputData['products']=serialize($inputData['products']);
		}

		if(isset($inputData['comment']))
		{
			$inputData['comment']=String::encode($inputData['comment']);
		}


		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";	

		$addMultiAgrs="($insertValues)";	

		Database::query("insert into ".Database::getPrefix()."orders($insertKeys) values".$addMultiAgrs);

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['id']=$id;

			CustomPlugins::load('after_order_insert',$inputData);

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

		CustomPlugins::load('before_order_remove',$post);

		$whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from ".Database::getPrefix()."orders where $whereQuery $addWhere";


		$result=array();


		Database::query($command);	

		CustomPlugins::load('after_order_remove',$post);

		// DBCache::removeDir('system/post');

		// DBCache::removeCache($listID,'system/post');

		return true;
	}

	public static function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{

		if(is_numeric($listID))
		{
			$catid=$listID;

			unset($listID);

			$listID=array($catid);
		}

		$listIDs="'".implode("','",$listID)."'";	

		CustomPlugins::load('before_order_update',$listID);
				
	
		if(isset($post['comment']))
		{
			$post['comment']=String::encode($post['comment']);
		}
	
		if(isset($post['products']))
		{
			$post['products']=serialize($post['products']);
		}
	
		if(isset($post['summary']))
		{
			$post['summary']=serialize($post['summary']);
		}
	
				
		$keyNames=array_keys($post);

		$total=count($post);

		$setUpdates='';

		for($i=0;$i<$total;$i++)
		{
			$keyName=$keyNames[$i];
			$setUpdates.="$keyName='$post[$keyName]', ";
		}

		$setUpdates=substr($setUpdates,0,strlen($setUpdates)-2);
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update ".Database::getPrefix()."orders set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/post');

		// DBCache::removeCache($listIDs,'system/post');



		if(!$error=Database::hasError())
		{
			// self::saveCache();
			CustomPlugins::load('after_order_update',$listID);

			return true;
		}

		return false;
	}


}