<?php

class PostTags
{
	public static function get($inputData=array())
	{
		Table::setTable('post_tags');

		Table::setFields('id,postid,title,friendly_url');

		$result=Table::get($inputData,function($rows,$inputData){

			$total=count($rows);

			for ($i=0; $i < $total; $i++) { 

				if(isset($rows[$i]['friendly_url']))
				{
					$rows[$i]['url']=System::getUrl().'tag/'.$rows[$i]['friendly_url'].'.html';
				}

				if(isset($rows[$i]['title']))
				{
					$rows[$i]['title']=stripslashes($rows[$i]['title']);
				}


			}

			return $rows;

		});

		return $result;
	}

	public static function insert($inputData=array())
	{
		Table::setTable('post_tags');

		$result=Table::insert($inputData,function($insertData){
			if(isset($insertData['title']))
			{
				$insertData['friendly_url']=Strings::makeFriendlyUrl(strip_tags($insertData['title']));
			}

			

			return $insertData;

		});

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('post_tags');

		$result=Table::update($listID,$updateData);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('post_tags');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


}