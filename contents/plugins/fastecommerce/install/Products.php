<?php

class Products
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

		$field="id,catid,category_str,title,friendly_url,date_added,views,rating,likes,reviews,orders,points,sku,upc,model,content,shortdesc,image,userid,is_featured,date_featured,require_shipping,brandid,quantity,sort_order,require_minimum,date_available,date_expires,price,sale_price,sale_price_from,sale_price_to,status,type,category_data,brand_data,tag_data,attr_data,attr_str,download_data,image_data,discount_data,weight,shipping_class,is_stock_manage,purchase_note,enable_review,page_title,descriptions,keywords,review_data".$moreFields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by id desc';

		$result=array();

		$dbPrefix=Database::getPrefix();

		$prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;
		
		$command="select $selectFields from ".$prefix."products $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

		$md5Query=md5($queryCMD);

		// $result=array();

		

		if($cache=='yes')
		{
			// Load dbcache
			$loadCache=Cache::loadKey('dbcache/system/products/'.$md5Query,$cacheTime);

			if($loadCache!=false)
			{
				$result=unserialize($loadCache);
				// return $loadCache;
			}

			// end load			
		}
		else
		{
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
												
					$result[]=$row;
				}		
			}
			else
			{
				return false;
			}
		}

		$discountData=array();

		if(isset(Discounts::$data['id']))
		{
			$discountData=Discounts::$data;
		}	

		$todayTime=time();

		$total=count($result);

		for ($i=0; $i < $total; $i++) { 

			$row=$result[$i];

			if(isset($row['sale_price_from']))
			{
				$sale_price_from=strtotime($row['sale_price_from']);

				$sale_price_to=strtotime($row['sale_price_to']);
				
				if((int)$sale_price_from > (int)$todayTime)
				{
					$row['sale_price']=$row['price'];
				}				
			}
		
			if(isset($row['sale_price']))
			{
				$row['discount_price']=$row['sale_price'];
			}

			if(isset($discountData['id']) && isset($row['sale_price']))
			{
				$percent=$discountData['percent'];

				$row['discount_price']=(double)$row['discount_price']-((double)$row['discount_price']*((double)$percent/100));

				$row['price']=$row['sale_price'];

				$row['sale_price']=$row['discount_price'];

			}

			if(isset($row['price']) && isset($row['sale_price']))
			{
				$row['percent_discount']=intval((1-((double)$row['discount_price']/(double)$row['price']))*100);
			}

			if(isset($row['title']))
			{
				$row['title']=String::decode($row['title']);
			}
			
			if(isset($row['shortdesc']))
			{
				$row['shortdesc']=String::decode($row['shortdesc']);
			}
			
			if(isset($row['page_title']))
			{
				$row['page_title']=String::decode($row['page_title']);
			}
			
			if(isset($row['descriptions']))
			{
				$row['descriptions']=String::decode($row['descriptions']);
			}
			
			if(isset($row['keywords']))
			{
				$row['keywords']=String::decode($row['keywords']);
			}
			
			if(isset($row['purchase_note']))
			{
				$row['purchase_note']=String::decode($row['purchase_note']);
			}

			if(isset($row['category_data'][10]))
			{
				$row['category_data']=unserialize($row['category_data']);
			}

			if(isset($row['brand_data'][10]))
			{
				$row['brand_data']=unserialize($row['brand_data']);
			}

			if(isset($row['review_data'][10]))
			{
				$row['review_data']=unserialize($row['review_data']);

				$totalReview=count($row['review_data']);

				if($totalReview < 5)
				{
					for ($i=0; $i < $totalReview; $i++) { 
						$row['review_data'][$i]=isset($row['review_data'][$i])?$row['review_data'][$i]:0;
					}						
				}

			}

			if(isset($row['tag_data'][10]))
			{
				$row['tag_data']=unserialize($row['tag_data']);
			}

			if(isset($row['attr_data'][10]))
			{
				$row['attr_data']=unserialize($row['attr_data']);
			}

			if(isset($row['download_data'][10]))
			{
				$row['download_data']=unserialize($row['download_data']);
			}

			if(isset($row['image_data'][10]))
			{
				$row['image_data']=unserialize($row['image_data']);
			}

			if(isset($row['discount_data'][10]))
			{
				$row['discount_data']=unserialize($row['discount_data']);
			}

			if(isset($row['friendly_url']))
			{
				$row['url']=self::url($row['friendly_url']);
			}

			if(isset($row['image']) && preg_match('/.*?\.(gif|png|jpe?g)/i', $row['image']))
			{
				if(!preg_match('/^http/i', $row['image']))
				{
					$row['imageUrl']=System::getUrl().$row['image'];
				}
				else
				{
					$row['imageUrl']=System::getUrl().'plugins/fastecommerce/images/noimg.jpg';
				}
				
			}

			if(isset($row['content']))
			{
				$row['content']=String::decode($row['content']);

			}

			if(isset($row['weight']))
			{
				$row['weightFormat']=number_format($row['weight']);

			}

			if(isset($row['price']))
			{
				$row['priceFormat']=FastEcommerce::money_format($row['price']);

			}

			if(isset($row['sale_price']))
			{
				$row['sale_priceFormat']=FastEcommerce::money_format($row['sale_price']);

			}



			if(isset($row['views']))
			{
				$row['viewsFormat']=number_format($row['views']);

			}

			if(isset($row['likes']))
			{
				$row['likesFormat']=number_format($row['likes']);

			}

			if(isset($row['reviews']))
			{
				$row['reviewsFormat']=number_format($row['reviews']);

			}

			if(isset($row['orders']))
			{
				$row['ordersFormat']=number_format($row['orders']);

			}

			if(isset($row['points']))
			{
				$row['pointsFormat']=number_format($row['points']);

			}

			if(isset($row['date_added']))
			{
				$row['date_addedFormat']=Render::dateFormat($row['date_added']);	
			}
			

			if($inputData['isHook']=='yes')
			{
				if(isset($row['content']))
				{
					$row['content']=String::decode($row['content']);

					$row['content']=html_entity_decode($row['content']);
					
					$row['content']=Shortcode::loadInTemplate($row['content']);

					$row['content']=Shortcode::load($row['content']);
					
					$row['content']=Shortcode::toHTML($row['content']);
				}
				
			}		

			$result[$i]=$row;	
		}

		// Save dbcache
		Cache::saveKey('dbcache/system/products/'.$md5Query,serialize($result));

		// end save


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
		Database::query("update ".Database::getPrefix()."categories set products=products+$total $addWhere");
	}

	public static function up($addWhere='',$field='',$total=1)
	{
		Database::query("update ".Database::getPrefix()."products set $field=$field+$total $addWhere");
	}

	public static function down($addWhere='',$field='',$total=1)
	{
		Database::query("update ".Database::getPrefix()."products set $field=$field-$total $addWhere");
	}

	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/dbcache/system/products/';

		return $result;
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
				for ($i=0; $i < $totalReview; $i++) { 
					$loadData['review_data'][$i]=isset($loadData['review_data'][$i])?$loadData['review_data'][$i]:0;
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
			
			$loadData['content']=Shortcode::loadInTemplate($loadData['content']);

			$loadData['content']=Shortcode::load($loadData['content']);
			
			$loadData['content']=Shortcode::toHTML($loadData['content']);
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
		// End addons
		// $totalArgs=count($inputData);
		CustomPlugins::load('before_product_insert',$inputData);

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

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";	

		$addMultiAgrs="($insertValues)";	

		Database::query("insert into ".Database::getPrefix()."products($insertKeys) values".$addMultiAgrs);

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$friendly_url=$inputData['friendly_url'].'-'.$id;

			Database::query("update ".Database::getPrefix()."products set friendly_url='".$friendly_url."' where id='$id'");

			$inputData['id']=$id;

			CustomPlugins::load('after_product_insert',$inputData);

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

		CustomPlugins::load('before_product_remove',$post);

		$whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from ".Database::getPrefix()."products where $whereQuery $addWhere";


		$result=array();

		$loadData=self::get(array(
			'cache'=>'no',
			'isHook'=>'no',
			'selectFields'=>'id',
			'where'=>"where  $whereQuery $addWhere"
			));

		if(isset($loadData[0]['id']))
		{
			$total=count($loadData);

			for ($i=0; $i < $total; $i++) { 
				$result[]=$loadData[$i]['id'];
			}

			$listID="'".implode("','",$result)."'";

			ProductTags::remove(array(0),"productid IN ($listID)");

			ProductImages::remove(array(0),"productid IN ($listID)");

			ProductBrands::remove(array(0),"productid IN ($listID)");

			ProductDiscounts::remove(array(0),"productid IN ($listID)");

			ProductDownloads::remove(array(0),"productid IN ($listID)");

			ProductReviews::remove(array(0),"productid IN ($listID)");

			ProductCategories::remove(array(0),"productid IN ($listID)");
			
		}

		Database::query($command);	

		CustomPlugins::load('after_product_remove',$post);

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

		CustomPlugins::load('before_product_update',$listID);
				
		if(isset($post['title']))
		{
			$postTitle=isset($post['addTitle'])?$post['addTitle']:$post['title'];

			$post['title']=String::encode(strip_tags($post['title']));
		}

		if(isset($post['friendly_url']))
		{
			$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where friendly_url='".$post['friendly_url']."' AND id<>'".$listID[0]."'"
				));

			if(isset($loadData[0]['id']))
			{
				return false;
			}

		}

		if(isset($post['content']))
		{
			$post['content']=String::encode($post['content']);
		}

		if(isset($post['keywords']))
		{
			$post['keywords']=String::encode($post['keywords']);
		}

		if(isset($post['descriptions']))
		{
			$post['descriptions']=String::encode($post['descriptions']);
		}

		if(isset($post['page_title']) && isset($post['title']) )
		{
			$post['page_title']=String::encode($post['page_title']);
		}
		elseif(isset($post['title']))
		{
			$post['page_title']=$post['title'];
		}

		if(isset($post['shortdesc']))
		{
			$post['shortdesc']=String::encode($post['shortdesc']);
		}

		if(isset($post['purchase_note']))
		{
			$post['purchase_note']=String::encode($post['purchase_note']);
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

		Database::query("update ".Database::getPrefix()."products set $setUpdates where $whereQuery $addWhere");

		// DBCache::removeDir('system/post');

		// DBCache::removeCache($listIDs,'system/post');



		if(!$error=Database::hasError())
		{
			// self::saveCache();
			CustomPlugins::load('after_product_update',$listID);

			return true;
		}

		return false;
	}


}