<?php

class Post
{
	public static function get($inputData=array())
	{
		Table::setTable('post');

		Table::setFields('id,userid,title,friendly_url,image,category_data,images_data,tag_data,page_title,descriptions,keywords,views,type,status,date_added,likes,shares,allowcomment,content,is_featured,date_featured');

		$result=Table::get($inputData,function($rows,$inputData){

			$total=count($rows);

			for ($i=0; $i < $total; $i++) { 

				if(isset($rows[$i]['friendly_url']))
				{
					$rows[$i]['url']=System::getUrl().'post/'.$rows[$i]['friendly_url'].'.html';
				}

				if(isset($rows[$i]['image']))
				{
					$rows[$i]['imageUrl']=System::getUrl().$rows[$i]['image'];
				}

				if(isset($rows[$i]['title']))
				{
					$rows[$i]['title']=stripslashes($rows[$i]['title']);
				}

				if(isset($rows[$i]['page_title']))
				{
					$rows[$i]['page_title']=stripslashes($rows[$i]['page_title']);
				}

				if(isset($rows[$i]['descriptions']))
				{
					$rows[$i]['descriptions']=stripslashes($rows[$i]['descriptions']);
				}

				if(isset($rows[$i]['keywords']))
				{
					$rows[$i]['keywords']=stripslashes($rows[$i]['keywords']);
				}

				if(isset($rows[$i]['images_data']) && isset($rows[$i]['images_data'][5]))
				{
					$rows[$i]['images_data']=unserialize($rows[$i]['images_data']);
				}

				if(isset($rows[$i]['category_data']) && isset($rows[$i]['category_data'][5]))
				{
					$rows[$i]['category_data']=unserialize($rows[$i]['category_data']);
				}

				if(isset($rows[$i]['tag_data']) && isset($rows[$i]['tag_data'][5]))
				{
					$rows[$i]['tag_data']=unserialize($rows[$i]['tag_data']);
				}

				if(isset($rows[$i]['content']))
				{
					$rows[$i]['content']=stripslashes($rows[$i]['content']);
					
					if($inputData['isHook']=='yes')
					{
						$rows[$i]['content']=Shortcode::render($rows[$i]['content']);
					}
				}



			}

			return $rows;

		});

		return $result;
	}

	public static function insert($inputData=array())
	{
		Table::setTable('post');

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
					'friendly_url'=>Strings::makeFriendlyUrl(strip_tags($inputData['title'])).'-'.$inputData['id']
					));
			}
		});

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('post');

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
		Table::setTable('post');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


	public static function exists($id)
	{
		Table::setTable('post');

		$result=Table::exists($id);

		return $result;
	}

	public static function loadCache($id)
	{
		Table::setTable('post');

		$result=Table::loadCache($id,function($id){
			Post::saveCache($id);
		});

		return $result;
	}

	public static function removeCache($id)
	{
		Table::setTable('post');

		Table::removeCache($id);

	}

	public static function saveCache($listID)
	{
		Table::setTable('post');


		if(!is_array($listID))
		{
			$tmp=$listID;

			$listID=array($tmp);
		}

		$total=count($listID);

		for ($i=0; $i < $total; $i++) { 
			$id=$listID[$i];

			Table::saveCache($id,function($inputData){

				$inputData['category_data']='';

				$inputData['tag_data']='';

				if(isset($inputData['catid']))
				{
					$loadCat=Categories::get(array(
						'cache'=>'no',
						'selectFields'=>'*',
						'where'=>"where id='".$inputData['catid']."'"
						));

					$inputData['category_data']=$loadCat[0];
				}

				$loadTag=PostTags::get(array(
					'cache'=>'no',
					'selectFields'=>'*',
					'where'=>"where postid='".$inputData['id']."'"
					));

				if(isset($loadTag[0]['postid']))
				{
					$inputData['tag_data']=$loadTag;
				}


				return $inputData;

			});			
		}

	}

	public static function updateData($id)
	{
		$inputData=self::get(array(
			'cache'=>'no',
			'isHook'=>'no',
			'selectFields'=>'*',
			'where'=>"where id='$id'"
			));

		if(isset($inputData[0]['id']))
		{
			$updateData=array();

			$loadCat=Categories::get(array(
				'cache'=>'no',
				'selectFields'=>'*',
				'where'=>"where id='".$inputData[0]['catid']."'"
				));

			$updateData['category_data']=serialize($loadCat[0]);

			$loadTag=PostTags::get(array(
				'cache'=>'no',
				'selectFields'=>'*',
				'where'=>"where postid='".$inputData[0]['id']."'"
				));

			if(isset($loadTag[0]['postid']))
			{
				$updateData['tag_data']=serialize($loadTag);
			}			

			self::update($id,$updateData);
		}


	}

	public static function up($field,$num=1,$addWhere='')
	{
		Table::setTable('post');

		Table::up($field,$num,$addWhere);
	}

	public static function down($field,$num=1,$addWhere='')
	{
		Table::setTable('post');

		Table::down($field,$num,$addWhere);
	}

}