<?php

class Orders
{
	public static function get($inputData=array())
	{
		Table::setTable('orders');

		Table::setFields('id,date_added,userid,shipping_firstname,shipping_lastname,shipping_company,shipping_address1,shipping_address2,shipping_city,shipping_postcode,shipping_state,shipping_country,shipping_url,shipping_method,shipping_phone,shipping_fax,comment,affiliateid,commission,ip,status,products,vat,before_vat,total,summary');

		$result=Table::get($inputData,function($rows,$inputData){

			$total=count($rows);

			for ($i=0; $i < $total; $i++) { 

				if(isset($rows[$i]['id']))
				{
					$rows[$i]['url']=System::getUrl().'admincp/plugins/privatecontroller/fastecommerce/order/view/'.$rows[$i]['id'];
				}

				if(isset($rows['comment']))
				{
					$rows['comment']=String::decode($rows['comment']);
				}


				if(isset($rows['summary']) && isset($rows['summary'][5]))
				{
					$rows['summary']=unserialize($rows['summary']);

					// die($rows['content']);
				}

				if(isset($rows['products']) && isset($rows['products'][5]))
				{
					$rows['products']=unserialize($rows['products']);

					// die($rows['content']);
				}


			}

			return $rows;

		});

		return $result;
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
		Table::setTable('orders');

		$result=Table::insert($inputData,function($inputData){
	
			if(!isset($inputData['date_added']))
			{
				$inputData['date_added']=date('Y-m-d H:i:s');
			}
			
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

			

			return $inputData;

		});

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('orders');

		$result=Table::update($listID,$updateData,function($inputData){
	
			if(isset($inputData['comment']))
			{
				$inputData['comment']=String::encode($inputData['comment']);
			}
		
			if(isset($inputData['products']))
			{
				$inputData['products']=serialize($inputData['products']);
			}
		
			if(isset($inputData['summary']))
			{
				$inputData['summary']=serialize($inputData['summary']);
			}
		
			return $inputData;
		});

		Post::saveCache($listID);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('orders');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}



}