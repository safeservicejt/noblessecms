<?php

class Products
{
	public static function get($inputData=array())
	{
		Table::setTable('products');

		Table::setFields('id,catid,category_str,title,friendly_url,date_added,views,rating,likes,reviews,orders,points,sku,upc,model,content,shortdesc,image,userid,is_featured,date_featured,require_shipping,brandid,quantity,sort_order,require_minimum,date_available,date_expires,price,sale_price,sale_price_from,sale_price_to,status,type,category_data,brand_data,tag_data,attr_data,attr_str,download_data,image_data,discount_data,weight,shipping_class,is_stock_manage,purchase_note,enable_review,page_title,descriptions,keywords,review_data');

		$result=Table::get($inputData,function($rows,$inputData){

			$discountData=array();

			if(isset(Discounts::$data['id']))
			{
				$discountData=Discounts::$data;
			}	

			$todayTime=time();

			$total=count($rows);

			for ($i=0; $i < $total; $i++) { 

				if(isset($rows[$i]['sale_price_from']))
				{
					$sale_price_from=strtotime($rows[$i]['sale_price_from']);

					$sale_price_to=strtotime($rows[$i]['sale_price_to']);
					
					if((int)$sale_price_from > (int)$todayTime)
					{
						$rows[$i]['sale_price']=$rows[$i]['price'];
					}				
				}
			
				if(isset($rows[$i]['sale_price']))
				{
					$rows[$i]['discount_price']=$rows[$i]['sale_price'];
				}

				if(isset($discountData['id']) && isset($rows[$i]['sale_price']))
				{
					$percent=$discountData['percent'];

					$rows[$i]['discount_price']=(double)$rows[$i]['discount_price']-((double)$rows[$i]['discount_price']*((double)$percent/100));

					$rows[$i]['price']=$rows[$i]['sale_price'];

					$rows[$i]['sale_price']=$rows[$i]['discount_price'];

				}

				if(isset($rows[$i]['price']) && isset($rows[$i]['sale_price']))
				{
					$rows[$i]['percent_discount']=intval((1-((double)$rows[$i]['discount_price']/(double)$rows[$i]['price']))*100);
				}

				if(isset($rows[$i]['title']))
				{
					$rows[$i]['title']=String::decode($rows[$i]['title']);
				}
				
				if(isset($rows[$i]['shortdesc']))
				{
					$rows[$i]['shortdesc']=String::decode($rows[$i]['shortdesc']);
				}
				
				if(isset($rows[$i]['page_title']))
				{
					$rows[$i]['page_title']=String::decode($rows[$i]['page_title']);
				}
				
				if(isset($rows[$i]['descriptions']))
				{
					$rows[$i]['descriptions']=String::decode($rows[$i]['descriptions']);
				}
				
				if(isset($rows[$i]['keywords']))
				{
					$rows[$i]['keywords']=String::decode($rows[$i]['keywords']);
				}
				
				if(isset($rows[$i]['purchase_note']))
				{
					$rows[$i]['purchase_note']=String::decode($rows[$i]['purchase_note']);
				}

				if(isset($rows[$i]['category_data'][10]))
				{
					$rows[$i]['category_data']=unserialize($rows[$i]['category_data']);
				}

				if(isset($rows[$i]['brand_data'][10]))
				{
					$rows[$i]['brand_data']=unserialize($rows[$i]['brand_data']);
				}

				if(isset($rows[$i]['review_data'][10]))
				{
					$rows[$i]['review_data']=unserialize($rows[$i]['review_data']);

					$totalReview=count($rows[$i]['review_data']);

					if($totalReview < 5)
					{
						for ($k=0; $k < $totalReview; $k++) { 
							$rows[$k]['review_data'][$k]=isset($rows[$k]['review_data'][$k])?$rows[$k]['review_data'][$k]:0;
						}						
					}

				}

				if(isset($rows[$i]['tag_data'][10]))
				{
					$rows[$i]['tag_data']=unserialize($rows[$i]['tag_data']);
				}

				if(isset($rows[$i]['attr_data'][10]))
				{
					$rows[$i]['attr_data']=unserialize($rows[$i]['attr_data']);
				}

				if(isset($rows[$i]['download_data'][10]))
				{
					$rows[$i]['download_data']=unserialize($rows[$i]['download_data']);
				}

				if(isset($rows[$i]['image_data'][10]))
				{
					$rows[$i]['image_data']=unserialize($rows[$i]['image_data']);
				}

				if(isset($rows[$i]['discount_data'][10]))
				{
					$rows[$i]['discount_data']=unserialize($rows[$i]['discount_data']);
				}

				if(isset($rows[$i]['friendly_url']))
				{
					$rows[$i]['url']=System::getUrl().'product/'.$rows[$i]['friendly_url'].'.html';
				}

				if(isset($rows[$i]['image']) && preg_match('/.*?\.(gif|png|jpe?g)/i', $rows[$i]['image']))
				{
					if(!preg_match('/^http/i', $rows[$i]['image']))
					{
						$rows[$i]['imageUrl']=System::getUrl().$rows[$i]['image'];
					}
					else
					{
						$rows[$i]['imageUrl']=System::getUrl().'plugins/fastecommerce/images/noimg.jpg';
					}
					
				}

				if(isset($rows[$i]['content']))
				{
					$rows[$i]['content']=String::decode($rows[$i]['content']);

				}

				if(isset($rows[$i]['weight']))
				{
					$rows[$i]['weightFormat']=number_format($rows[$i]['weight']);

				}

				if(isset($rows[$i]['price']))
				{
					$rows[$i]['priceFormat']=FastEcommerce::money_format($rows[$i]['price']);

				}

				if(isset($rows[$i]['sale_price']))
				{
					$rows[$i]['sale_priceFormat']=FastEcommerce::money_format($rows[$i]['sale_price']);

				}



				if(isset($rows[$i]['views']))
				{
					$rows[$i]['viewsFormat']=number_format($rows[$i]['views']);

				}

				if(isset($rows[$i]['likes']))
				{
					$rows[$i]['likesFormat']=number_format($rows[$i]['likes']);

				}

				if(isset($rows[$i]['reviews']))
				{
					$rows[$i]['reviewsFormat']=number_format($rows[$i]['reviews']);

				}

				if(isset($rows[$i]['orders']))
				{
					$rows[$i]['ordersFormat']=number_format($rows[$i]['orders']);

				}

				if(isset($rows[$i]['points']))
				{
					$rows[$i]['pointsFormat']=number_format($rows[$i]['points']);

				}

				if(isset($rows[$i]['date_added']))
				{
					$rows[$i]['date_addedFormat']=Render::dateFormat($rows[$i]['date_added']);	
				}
				

				if($inputData['isHook']=='yes')
				{
					if(isset($rows[$i]['content']))
					{
						$rows[$i]['content']=String::decode($rows[$i]['content']);

						$rows[$i]['content']=html_entity_decode($rows[$i]['content']);
						
						$rows[$i]['content']=Shortcode::render($rows[$i]['content']);
					}
					
				}		

			}

			return $rows;

		});

		return $result;
	}

	public static function addReview($prodID,$userid,$rating,$content)
	{
		$id=Reviews::insert(array(
			'productid'=>$prodID,
			'content'=>$content,
			'rating'=>$rating,
			'userid'=>$userid

			));

		if(!$id)
		{
			return false;
		}

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where id='$prodID'"
			));

		if(!is_array($loadData['review_data']))
		{
			$loadData['review_data']=unserialize($loadData['review_data']);
		}

		$sumRating=0;

		for ($i=0; $i < 6; $i++) { 
			$loadData['review_data'][$i]=isset($loadData['review_data'][$i])?$loadData['review_data'][$i]:0;

			$sumRating=(int)$sumRating+(int)$loadData['review_data'][$i];
		}

		$loadData['review_data'][$rating]=isset($loadData['review_data'][$rating])?$loadData['review_data'][$rating]:0;

		$loadData['review_data'][$rating]=(int)$loadData['review_data'][$rating]+1;

		$sumRating=intval($sumRating/5);

		self::update($prodID,array(
			'review_data'=>serialize($loadData['review_data']),
			'rating'=>$sumRating
			));

		self::saveCache($prodID);

		return $id;
	}

	public static function getPublish($inputData=array())
	{
		if(!isset($inputData['where']))
		{
			$inputData['where']="where status='published' AND quantity > '0'";
		}
		else
		{
			$inputData['where'].=" AND status='published' AND quantity > '0'";
		}
	}

	public static function addAttr($id=0,$attr_name=array(),$attr_values=array())
	{
		if((int)$id==0)
		{
			return false;
		}

		$result=array();

		$total=count($attr_name);

		$attr_str='';

		if($total > 0)
		{
			for ($i=0; $i < $total; $i++) { 

				if(!isset($attr_name[$i][1]))
				{
					continue;
				}
				
				$theName=trim($attr_name[$i]);

				$theVal=$attr_values[$i];

				$split=explode('|', $theVal);

				$result[$i]['name']=$theName;

				$result[$i]['values']=$split;

				$totalVal=count($split);

				for ($v=0; $v < $totalVal; $v++) { 
					$attr_str.='|'.strtolower($theName).':'.strtolower($split[$v]).'|';
				}
				
			}			
		}

		self::update($id,array(
			'attr_data'=>serialize($result),
			'attr_str'=>trim($attr_str)
			));		

	}

	public static function addThumbnail($id,$inputName='thumbnail')
	{
		if(Request::hasFile($inputName))
		{
			if(Request::isImage($inputName))
			{
				$loadData=self::get(array(
					'cache'=>'no',
					'where'=>"where id='$id'"
					));

				if(!isset($loadData[0]['id']))
				{
					return false;
				}

				$image=File::upload($inputName,'uploads/files/',$loadData[0]['title']);

				self::update($id,array(
					'image'=>$image
					));
			}
		}	
	}

	public static function addDownload($id,$inputName='downloads')
	{
		if(preg_match('/.*?\.\w+$/i', $_FILES[$inputName]['name'][0]))
		{
			$result=File::uploadMultiple($inputName,'uploads/downloads/');

			self::update($id,array(
				'download_data'=>serialize($result)
				));				
		}

	}

	public static function updateDownload($id,$inputName='downloads')
	{
		if(preg_match('/.*?\.\w+$/i', $_FILES[$inputName]['name'][0]))
		{
			$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where id='$id'"
				));

			if(isset($loadData[0]['id']))
			{
				$downloads=$loadData[0]['download_data'];

				$total=count($downloads);

				for ($i=0; $i < $total; $i++) { 
					$filePath=ROOT_PATH.$downloads[$i];

					if(file_exists($filePath))
					{
						unlink($filePath);
					}
				}
			}

			$result=File::uploadMultiple($inputName,'uploads/downloads/');

			self::update($id,array(
				'download_data'=>serialize($result)
				));				
		}

	}

	public static function updateData($id=0)
	{
		if((int)$id==0)
		{
			return false;
		}

		$prodData=self::get(array(
			'cache'=>'no',
			'where'=>"where id='$id'"
			));

		if(!isset($prodData[0]['id']))
		{
			return false;
		}

		$updateData=array();

		$loadData=ProductCategories::get(array(
			'cache'=>'no',
			'where'=>"where productid='$id'"
			));

		if(isset($loadData[0]['productid']))
		{
			$updateData['category_data']=serialize($loadData);

			$loadData=array();
		}

		$loadData=ProductTags::get(array(
			'cache'=>'no',
			'where'=>"where productid='$id'"
			));

		if(isset($loadData[0]['productid']))
		{
			$updateData['tag_data']=serialize($loadData);

			$loadData=array();
		}

		$loadData=ProductImages::get(array(
			'cache'=>'no',
			'where'=>"where productid='$id'",
			'orderby'=>'order by sort_order asc'
			));

		if(isset($loadData[0]['productid']))
		{
			$updateData['image_data']=serialize($loadData);

			$loadData=array();
		}

		$loadData=Brands::get(array(
			'cache'=>'no',
			'where'=>"where id='".$prodData[0]['brandid']."'"
			));

		if(isset($loadData[0]['id']))
		{
			$updateData['brand_data']=serialize($loadData);

			$loadData=array();
		}


		self::update($id,$updateData);

	}

	public static function updateImages($id=0)
	{
		if((int)$id==0)
		{
			return false;
		}

		$prodData=self::get(array(
			'cache'=>'no',
			'where'=>"where id='$id'"
			));

		if(!isset($prodData[0]['id']))
		{
			return false;
		}

		$updateData=array();

		$loadData=ProductImages::get(array(
			'cache'=>'no',
			'where'=>"where productid='$id'"
			));

		if(isset($loadData[0]['productid']))
		{
			$updateData['image_data']=serialize($loadData);

			$loadData=array();
		}	

		self::update($id,$updateData);
	}

	public static function url($friendly_url='')
	{
		$url=System::getUrl().'product/'.$friendly_url.'.html';

		return $url;
	}

	public static function upToCategories($addWhere,$total=1)
	{
		Database::query("update categories set products=products+$total $addWhere");
	}

	public static function up($addWhere='',$field='',$total=1)
	{
		Database::query("update products set $field=$field+$total $addWhere");
	}

	public static function down($addWhere='',$field='',$total=1)
	{
		Database::query("update products set $field=$field-$total $addWhere");
	}

	public static function exists($id)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/product/'.$id.'.cache';

		if(!file_exists($savePath))
		{
			return false;
		}

		return true;		
	}

	public static function removeCache($listID=array())
	{
		$listID=!is_array($listID)?array($listID):$listID;

		$total=count($listID);

		for ($i=0; $i < $total; $i++) { 
			$id=$listID[$i];

			$savePath=ROOT_PATH.'contents/fastecommerce/product/'.$id.'.cache';

			if(file_exists($savePath))
			{
				unlink($savePath);
			}

		}
	}

	public static function loadCache($id)
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/product/'.$id.'.cache';

		if(!file_exists($savePath))
		{
			self::saveCache($id);

			if(!file_exists($savePath))
			{
				return false;
			}
		}

		$loadData=unserialize(file_get_contents($savePath));

		if(!is_array($loadData['attr_data']))
		{
			$loadData['attr_data']=unserialize($loadData['attr_data']);
		}
		
		$discountData=array();

		if(isset(Discounts::$data['id']))
		{
			$discountData=Discounts::$data;
		}	

		$todayTime=time();


		if(isset($loadData['sale_price_from']))
		{
			$sale_price_from=strtotime($loadData['sale_price_from']);

			$sale_price_to=strtotime($loadData['sale_price_to']);
			
			if((int)$sale_price_from > (int)$todayTime)
			{
				$loadData['sale_price']=$loadData['price'];
			}				
		}
	
		if(isset($loadData['sale_price']))
		{
			$loadData['discount_price']=$loadData['sale_price'];
		}

		if(isset($discountData['id']) && isset($loadData['sale_price']))
		{
			$percent=$discountData['percent'];

			$loadData['discount_price']=(double)$loadData['discount_price']-((double)$loadData['discount_price']*((double)$percent/100));

			$loadData['price']=$loadData['sale_price'];

			$loadData['sale_price']=$loadData['discount_price'];

		}

		if(isset($loadData['price']) && isset($loadData['sale_price']))
		{
			$loadData['percent_discount']=intval((1-((double)$loadData['discount_price']/(double)$loadData['price']))*100);
		}

		if(isset($loadData['title']))
		{
			$loadData['title']=String::decode($loadData['title']);
		}
		
		if(isset($loadData['shortdesc']))
		{
			$loadData['shortdesc']=String::decode($loadData['shortdesc']);
		}
		
		if(isset($loadData['page_title']))
		{
			$loadData['page_title']=String::decode($loadData['page_title']);
		}
		
		if(isset($loadData['descriptions']))
		{
			$loadData['descriptions']=String::decode($loadData['descriptions']);
		}
		
		if(isset($loadData['keywords']))
		{
			$loadData['keywords']=String::decode($loadData['keywords']);
		}
		
		if(isset($loadData['purchase_note']))
		{
			$loadData['purchase_note']=String::decode($loadData['purchase_note']);
		}

		if(isset($loadData['category_data'][10]))
		{
			$loadData['category_data']=unserialize($loadData['category_data']);
		}

		if(isset($loadData['brand_data'][10]))
		{
			$loadData['brand_data']=unserialize($loadData['brand_data']);
		}

		if(isset($loadData['review_data'][10]))
		{
			$loadData['review_data']=unserialize($loadData['review_data']);

			$totalReview=count($loadData['review_data']);

			if($totalReview < 5)
			{
				for ($k=0; $k < $totalReview; $k++) { 
					$loadData['review_data'][$k]=isset($loadData['review_data'][$k])?$loadData['review_data'][$k]:0;
				}						
			}

		}

		if(isset($loadData['tag_data'][10]))
		{
			$loadData['tag_data']=unserialize($loadData['tag_data']);
		}

		if(isset($loadData['attr_data'][10]))
		{
			$loadData['attr_data']=unserialize($loadData['attr_data']);
		}

		if(isset($loadData['download_data'][10]))
		{
			$loadData['download_data']=unserialize($loadData['download_data']);
		}

		if(isset($loadData['image_data'][10]))
		{
			$loadData['image_data']=unserialize($loadData['image_data']);
		}

		if(isset($loadData['discount_data'][10]))
		{
			$loadData['discount_data']=unserialize($loadData['discount_data']);
		}

		if(isset($loadData['friendly_url']))
		{
			$loadData['url']=self::url($loadData['friendly_url']);
		}

		if(isset($loadData['image']) && preg_match('/.*?\.(gif|png|jpe?g)/i', $loadData['image']))
		{
			if(!preg_match('/^http/i', $loadData['image']))
			{
				$loadData['imageUrl']=System::getUrl().$loadData['image'];
			}
			else
			{
				$loadData['imageUrl']=System::getUrl().'plugins/fastecommerce/images/noimg.jpg';
			}
			
		}

		if(isset($loadData['content']))
		{
			$loadData['content']=String::decode($loadData['content']);

		}

		if(isset($loadData['weight']))
		{
			$loadData['weightFormat']=number_format($loadData['weight']);

		}

		if(isset($loadData['price']))
		{
			$loadData['priceFormat']=FastEcommerce::money_format($loadData['price']);

		}

		if(isset($loadData['sale_price']))
		{
			$loadData['sale_priceFormat']=FastEcommerce::money_format($loadData['sale_price']);

		}



		if(isset($loadData['views']))
		{
			$loadData['viewsFormat']=number_format($loadData['views']);

		}

		if(isset($loadData['likes']))
		{
			$loadData['likesFormat']=number_format($loadData['likes']);

		}

		if(isset($loadData['reviews']))
		{
			$loadData['reviewsFormat']=number_format($loadData['reviews']);

		}

		if(isset($loadData['orders']))
		{
			$loadData['ordersFormat']=number_format($loadData['orders']);

		}

		if(isset($loadData['points']))
		{
			$loadData['pointsFormat']=number_format($loadData['points']);

		}

		if(isset($loadData['date_added']))
		{
			$loadData['date_addedFormat']=Render::dateFormat($loadData['date_added']);	
		}
		

		if(isset($loadData['content']))
		{
			$loadData['content']=String::decode($loadData['content']);

			$loadData['content']=html_entity_decode($loadData['content']);

			$loadData['content']=Shortcode::render($loadData['content']);
		}
		return $loadData;

	}

	public static function saveCache($id,$inputData=array())
	{
		if((int)$id==0)
		{
			return false;
		}

		$savePath=ROOT_PATH.'contents/fastecommerce/product/'.$id.'.cache';

		if(isset($inputData['id']))
		{
			$loadData=array();

			$loadData[0]=$inputData;
		}
		else
		{
			$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where id='$id'"
				));			
		}

		if(isset($loadData[0]['id']))
		{
			File::create($savePath,serialize($loadData[0]));
		}
		
	}

	public static function insert($inputData=array())
	{
		Table::setTable('products');

		$result=Table::insert($inputData,function($inputData){

			if(!isset($inputData['title']))
			{
				return false;
			}

			if(!isset($inputData['userid']))
			{
				$inputData['userid']=Users::getCookieUserId();
			}

			$addMultiAgrs='';

			$inputData['date_added']=date('Y-m-d H:i:s');

			$postTitle=isset($inputData['addTitle'])?$inputData['addTitle']:$inputData['title'];

			if(!isset($inputData['friendly_url']))
			{
				$inputData['friendly_url']=String::makeFriendlyUrl(strip_tags($postTitle));

			}
			
			$inputData['title']=String::encode(strip_tags($inputData['title']));

			if(isset($inputData['content']))
			{
				$inputData['content']=String::encode($inputData['content']);
			}

			if(isset($inputData['keywords']))
			{
				$inputData['keywords']=String::encode($inputData['keywords']);
			}

			if(isset($inputData['descriptions']))
			{
				$inputData['descriptions']=String::encode($inputData['descriptions']);
			}

			if(isset($inputData['page_title']) && isset($inputData['page_title'][2]))
			{
				$inputData['page_title']=String::encode($inputData['page_title']);
			}
			else
			{
				$inputData['page_title']=$inputData['title'];
			}

			if(isset($inputData['shortdesc']))
			{
				$inputData['shortdesc']=String::encode($inputData['shortdesc']);
			}

			if(isset($inputData['purchase_note']))
			{
				$inputData['purchase_note']=String::encode($inputData['purchase_note']);
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
		Table::setTable('products');

		$result=Table::update($listID,$updateData,function($inputData){

			if(isset($inputData['title']))
			{
				$postTitle=isset($inputData['addTitle'])?$inputData['addTitle']:$inputData['title'];

				$inputData['title']=String::encode(strip_tags($inputData['title']));
			}

			if(isset($inputData['content']))
			{
				$inputData['content']=String::encode($inputData['content']);
			}

			if(isset($inputData['keywords']))
			{
				$inputData['keywords']=String::encode($inputData['keywords']);
			}

			if(isset($inputData['descriptions']))
			{
				$inputData['descriptions']=String::encode($inputData['descriptions']);
			}

			if(isset($inputData['page_title']) && isset($inputData['title']) )
			{
				$inputData['page_title']=String::encode($inputData['page_title']);
			}
			elseif(isset($inputData['title']))
			{
				$inputData['page_title']=$inputData['title'];
			}

			if(isset($inputData['shortdesc']))
			{
				$inputData['shortdesc']=String::encode($inputData['shortdesc']);
			}

			if(isset($inputData['purchase_note']))
			{
				$inputData['purchase_note']=String::encode($inputData['purchase_note']);
			}

			return $inputData;
		});


		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('products');

		$result=Table::remove($inputIDs,$whereQuery);

		$listID="'".implode("','", $inputIDs)."'";

		ProductTags::remove(array(0),"productid IN ($listID)");

		ProductImages::remove(array(0),"productid IN ($listID)");

		ProductBrands::remove(array(0),"productid IN ($listID)");

		ProductDiscounts::remove(array(0),"productid IN ($listID)");

		ProductDownloads::remove(array(0),"productid IN ($listID)");

		ProductReviews::remove(array(0),"productid IN ($listID)");

		ProductCategories::remove(array(0),"productid IN ($listID)");


		return $result;
	}



}