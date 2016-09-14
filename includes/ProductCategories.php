<?php

class ProductCategories
{
	public static function get($inputData=array())
	{
		Table::setTable('product_categories');

		Table::setFields('productid,catid,product_title,product_friendly_url,cat_title,cat_friendly_url');

		$inputData['orderby']=!isset($inputData['orderby'])?'order by productid desc':$inputData['orderby'];

		$result=Table::get($inputData);

		return $result;
	}

	public static function insert($inputData=array())
	{
		Table::setTable('product_categories');

		$result=Table::insert($inputData);

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('product_categories');

		$result=Table::update($listID,$updateData);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('product_categories');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}



	public static function add($id,$listCatid=array())
	{
		if(!is_array($listCatid))
		{
			return false;
		}

		$totalCat=count($listCatid);

		if($totalCat == 0)
		{
			return false;
		}

		$loadData=Products::get(array(
			'cache'=>'no',
			'isHook'=>'no',
			'where'=>"where id='$id'"
			));

		if(!isset($loadData[0]['id']))
		{
			return false;
		}

		$listCat="'".implode("','", $listCatid)."'";

		$loadCat=Categories::get(array(
			'cache'=>'no',
			'where'=>"where id IN ($listCat)"
			));

		$category_str='';

		$total=count($loadCat);

		for ($i=0; $i < $total; $i++) { 

			$catid=$loadCat[$i]['id'];

			$category_str.='|'.$catid.'|';

			self::insert(array(
				'catid'=>$catid,
				'productid'=>$id,
				'product_title'=>$loadData[0]['title'],
				'product_friendly_url'=>$loadData[0]['url'],
				'cat_friendly_url'=>$loadCat[$i]['friendly_url'],
				));
		}

		Products::update($id,array(
			'category_str'=>$category_str
			));
	}

}