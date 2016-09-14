<?php

class ProductImages
{
	public static function get($inputData=array())
	{
		Table::setTable('product_images');

		Table::setFields('id,productid,image,sort_order');

		$result=Table::get($inputData,function($rows,$inputData){

			$total=count($rows);

			for ($i=0; $i < $total; $i++) { 

				if(isset($rows[$i]['image']))
				{
					$rows[$i]['url']=System::getUrl().$rows[$i]['image'];
				}



			}

			return $rows;

		});

		return $result;
	}

	public static function add($id,$inputName='images')
	{
		$loadData=Products::get(array(
			'cache'=>'no',
			'where'=>"where id='$id'"
			));

		if(!isset($loadData[0]['id']))
		{
			return false;
		}
	
		$result=File::uploadMultiple($inputName,'uploads/files/',$loadData[0]['title']);

		if(is_array($result))
		{
			$total=count($result);

			for ($i=0; $i < $total; $i++) { 

				self::insert(array(
					'productid'=>$id,
					'image'=>$result[$i],
					'sort_order'=>$i
					));
				
			}
		}	
	}

	public static function up($addWhere='',$field='',$total=1)
	{
		Database::query("update product_images set $field=$field+$total $addWhere");
	}

	public static function down($addWhere='',$field='',$total=1)
	{
		Database::query("update product_images set $field=$field-$total $addWhere");
	}	

	public static function insert($inputData=array())
	{
		Table::setTable('product_images');

		$result=Table::insert($inputData);

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('product_images');

		$result=Table::update($listID,$updateData);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('product_images');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}



}