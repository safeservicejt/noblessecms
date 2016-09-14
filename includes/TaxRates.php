<?php

class TaxRates
{
	public static $data=array();

	public static function get($inputData=array())
	{
		Table::setTable('taxrates');

		Table::setFields('id,title,amount,type,countries');

		$result=Table::get($inputData,function($rows,$inputData){

			$total=count($rows);

			for ($i=0; $i < $total; $i++) { 

				if(isset($rows[$i]['countries']) && isset($rows[$i]['countries'][5]))
				{
					$rows[$i]['countries']=unserialize($rows[$i]['countries']);
				}
				if(isset($rows[$i]['amount']))
				{
					if($rows[$i]['type']=='percent')
					{
						$rows[$i]['amountFormat'].=' %';
					}
					else
					{
						$rows[$i]['amountFormat']=FastEcommerce::money_format($rows[$i]['amount']);
					}
					
				}

			}

			return $rows;

		});

		return $result;
	}

	public static function getTax($country='')
	{
		$loadData=self::loadCache($country);

		self::$data=$loadData;

		$totalMoney=0;

		$loadCart=Cart::loadCache(Http::get('ip'));

		$result=self::cal($loadCart['total']);

		return $result;
	}

	public static function loadCache($countryName='all')
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/countries/';

		$amount=0;

		$loadData=array();

		if(file_exists($savePath.$countryName.'_taxrate.cache'))
		{
			$loadData=unserialize(file_get_contents($savePath.$countryName.'_taxrate.cache'));
		}
		else
		{
			$loadData=unserialize(file_get_contents($savePath.'taxrate.cache'));
		}

		self::$data=$loadData;

		return $loadData;
	}

	public static function removeCache($inputData=array())
	{
		$listID="'".implode("','", $inputData)."'";

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where id IN ($listID)"
			));

		$total=count($loadData);

		$savePath=ROOT_PATH.'contents/fastecommerce/countries/';


		for ($i=0; $i < $total; $i++) { 

			if(!isset($loadData[$i]['id']))
			{
				continue;
			}

			$id=$loadData[$i]['id'];

			$countries=$loadData[$i]['countries'];

			if($countries[0]!='all')
			{
				$totalC=count($countries);

				for ($j=0; $j < $totalC; $j++) { 
					$cName=strtolower($countries[$j]);

					$filePath=$savePath.$cName.'_taxrate.cache';

					if(file_exists($filePath))
					{
						unlink($filePath);
					}

				}
			}	
			else
			{
				$filePath=$savePath.'taxrate.cache';

				if(file_exists($filePath))
				{

					unlink($filePath);
				}
			}
		}


	}

	public static function cal($money=0)
	{
		$result=0;

		if(!isset(self::$data['type']))
		{
			return false;
		}

		if(self::$data['type']=='percent')
		{
			$result=((double)$money*(double)self::$data['amount'])/100;
		}
		else
		{
			$result=(double)self::$data['amount'];
		}

		return $result;
	}

	public static function saveCache($id)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/countries/';

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where id='$id'"
			));

		if(isset($loadData[0]['id']))
		{
			$countries=$loadData[0]['countries'];

			if($countries[0]!='all')
			{
				$total=count($countries);

				for ($i=0; $i < $total; $i++) { 
					$cName=strtolower($countries[$i]);

					$cPath=$savePath.$cName.'_taxrate.cache';

					$saveData=array(
						'type'=>$loadData[0]['type'],
						'amount'=>$loadData[0]['amount'],
						);

					File::create($cPath,serialize($saveData));
				}
			}
			else
			{
				$savePath.='taxrate.cache';

				File::create($savePath,serialize($loadData[0]));
			}

		}
	}

	public static function insert($inputData=array())
	{
		Table::setTable('taxrates');

		$result=Table::insert($inputData,function($inputData){
			if(!isset($inputData['userid']))
			{
				$inputData['userid']=Users::$id;
			}

			if(!isset($inputData['date_added']))
			{
				$inputData['date_added']=date('Y-m-d H:i:s');
			}


			if(isset($inputData['title']))
			{
				$inputData['title']=addslashes($inputData['title']);
			}

			if(!isset($inputData['page_title']) || !isset($inputData['page_title'][5]))
			{
				$inputData['page_title']=$inputData['title'];
			}

			if(isset($inputData['descriptions']))
			{
				$inputData['descriptions']=addslashes($inputData['descriptions']);
			}

			if(isset($inputData['page_title']))
			{
				$inputData['page_title']=addslashes($inputData['page_title']);
			}

			if(isset($inputData['keywords']))
			{
				$inputData['keywords']=addslashes($inputData['keywords']);
			}
			

			return $inputData;

		},function($inputData){
			if(isset($inputData['id']))
			{
				self::update($inputData['id'],array(
					'friendly_url'=>String::makeFriendlyUrl(strip_tags($inputData['title'])).'-'.$inputData['id']
					));
			}
		});

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('taxrates');

		$result=Table::update($listID,$updateData,function($inputData){
			if(isset($inputData['title']))
			{
				$inputData['title']=addslashes($inputData['title']);
			}

			if(isset($inputData['page_title']))
			{
				$inputData['page_title']=addslashes($inputData['page_title']);
			}

			if(isset($inputData['descriptions']))
			{
				$inputData['descriptions']=addslashes($inputData['descriptions']);
			}

			if(isset($inputData['keywords']))
			{
				$inputData['keywords']=addslashes($inputData['keywords']);
			}

			if(isset($inputData['content']))
			{
				$inputData['content']=addslashes($inputData['content']);
			}

			

			return $inputData;
		});

		Post::saveCache($listID);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('taxrates');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}

}