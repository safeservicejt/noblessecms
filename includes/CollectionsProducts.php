<?php

class CollectionsProducts
{

	public static function get()
	{
		$uri=System::getUri();


		$result=array();

		if(preg_match('/collection\/render\/\d+/i', $uri))
		{
			if(preg_match_all('/(\d+)/i', $uri, $matches))
			{
				$listID=implode(',', $matches[1]);


				$userid=(int)Users::getCookieUserId();

				$hash=self::saveCache($userid,$listID);

				Redirect::to('collection/'.$hash.'.html');
			}
		}
		elseif(preg_match('/collection\/([a-zA-Z0-9_]+)\.html$/i', $uri,$match))
		{
			$hash=$match[1];

			$result=self::loadCache($hash);

			return $result;
		}
		else
		{
			Redirect::to('404page');
		}
	}

	public static function exists($id='')
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/collectionproduct/'.$id.'.cache';

		$result=true;

		if(!file_exists($savePath))
		{
			$result=false;
		}

		return $result;
	}

	public static function loadCache($listHash='')
	{
		$savePath=ROOT_PATH.'contents/fastecommerce/collectionproduct/'.$listHash.'.cache';

		$result=false;

		$loadData=false;

		if(file_exists($savePath))
		{
			$result=unserialize(file_get_contents($savePath));

			$userid=(int)$result['userid'];

			$products=$result['product'];

			$discountData=array();

			if(isset(Discounts::$data['id']))
			{
				$discountData=Discounts::$data;
			}	

			$todayTime=time();			

			$total=count($products);

			$loadData=array();

			for ($i=0; $i < $total; $i++) { 
				$theID=$products[$i];

				$prodData=Products::loadCache($theID);

				if(!$prodData)
				{
					continue;
				}


				if(isset($prodData['sale_price_from']))
				{
					$sale_price_from=strtotime($prodData['sale_price_from']);

					$sale_price_to=strtotime($prodData['sale_price_to']);
					
					if((int)$sale_price_from > (int)$todayTime)
					{
						$prodData['sale_price']=$prodData['price'];
					}				
				}
			
				if(isset($prodData['sale_price']))
				{
					$prodData['discount_price']=$prodData['sale_price'];
				}

				if(isset($discountData['id']) && isset($prodData['sale_price']))
				{
					$percent=$discountData['percent'];

					$prodData['discount_price']=(double)$prodData['discount_price']-((double)$prodData['discount_price']*((double)$percent/100));

					$prodData['price']=$prodData['sale_price'];

					$prodData['sale_price']=$prodData['discount_price'];

				}

				if(isset($prodData['price']) && isset($prodData['sale_price']))
				{
					$prodData['percent_discount']=intval((1-((double)$prodData['discount_price']/(double)$prodData['price']))*100);
				}

				if(isset($prodData['title']))
				{
					$prodData['title']=String::decode($prodData['title']);
				}
				
				if(isset($prodData['shortdesc']))
				{
					$prodData['shortdesc']=String::decode($prodData['shortdesc']);
				}
				
				if(isset($prodData['page_title']))
				{
					$prodData['page_title']=String::decode($prodData['page_title']);
				}
				
				if(isset($prodData['descriptions']))
				{
					$prodData['descriptions']=String::decode($prodData['descriptions']);
				}
				
				if(isset($prodData['keywords']))
				{
					$prodData['keywords']=String::decode($prodData['keywords']);
				}
				
				if(isset($prodData['purchase_note']))
				{
					$prodData['purchase_note']=String::decode($prodData['purchase_note']);
				}

				if(isset($prodData['category_data'][10]))
				{
					$prodData['category_data']=unserialize($prodData['category_data']);
				}

				if(isset($prodData['brand_data'][10]))
				{
					$prodData['brand_data']=unserialize($prodData['brand_data']);
				}

				if(isset($prodData['review_data'][10]))
				{
					$prodData['review_data']=unserialize($prodData['review_data']);

					$totalReview=count($prodData['review_data']);

					if($totalReview < 5)
					{
						for ($k=0; $k < $totalReview; $k++) { 
							$prodData['review_data'][$k]=isset($prodData['review_data'][$k])?$prodData['review_data'][$k]:0;
						}						
					}

				}

				if(isset($prodData['tag_data'][10]))
				{
					$prodData['tag_data']=unserialize($prodData['tag_data']);
				}

				if(isset($prodData['attr_data'][10]))
				{
					$prodData['attr_data']=unserialize($prodData['attr_data']);
				}

				if(isset($prodData['download_data'][10]))
				{
					$prodData['download_data']=unserialize($prodData['download_data']);
				}

				if(isset($prodData['image_data'][10]))
				{
					$prodData['image_data']=unserialize($prodData['image_data']);
				}

				if(isset($prodData['discount_data'][10]))
				{
					$prodData['discount_data']=unserialize($prodData['discount_data']);
				}

				if(isset($prodData['friendly_url']))
				{
					$prodData['url']=System::getUrl().'product/'.$prodData['friendly_url'].'.html';
				}

				if(isset($prodData['image']) && preg_match('/.*?\.(gif|png|jpe?g)/i', $prodData['image']))
				{
					if(!preg_match('/^http/i', $prodData['image']))
					{
						$prodData['imageUrl']=System::getUrl().$prodData['image'];
					}
					else
					{
						$prodData['imageUrl']=System::getUrl().'plugins/fastecommerce/images/noimg.jpg';
					}
					
				}

				if(isset($prodData['content']))
				{
					$prodData['content']=String::decode($prodData['content']);

				}

				if(isset($prodData['weight']))
				{
					$prodData['weightFormat']=number_format($prodData['weight']);

				}

				if(isset($prodData['price']))
				{
					$prodData['priceFormat']=FastEcommerce::money_format($prodData['price']);

				}

				if(isset($prodData['sale_price']))
				{
					$prodData['sale_priceFormat']=FastEcommerce::money_format($prodData['sale_price']);

				}



				if(isset($prodData['views']))
				{
					$prodData['viewsFormat']=number_format($prodData['views']);

				}

				if(isset($prodData['likes']))
				{
					$prodData['likesFormat']=number_format($prodData['likes']);

				}

				if(isset($prodData['reviews']))
				{
					$prodData['reviewsFormat']=number_format($prodData['reviews']);

				}

				if(isset($prodData['orders']))
				{
					$prodData['ordersFormat']=number_format($prodData['orders']);

				}

				if(isset($prodData['points']))
				{
					$prodData['pointsFormat']=number_format($prodData['points']);

				}

				if(isset($prodData['date_added']))
				{
					$prodData['date_addedFormat']=Render::dateFormat($prodData['date_added']);	
				}
				

				if($inputData['isHook']=='yes')
				{
					if(isset($prodData['content']))
					{
						$prodData['content']=String::decode($prodData['content']);

						$prodData['content']=html_entity_decode($prodData['content']);
						
						$prodData['content']=Shortcode::render($prodData['content']);
					}
					
				}					

				$loadData[]=$prodData;
			}

			if($userid>0)
			{
				Cookie::make('affiliateid',$userid,1440*30);
			}
		}
		
		return $loadData;
	}

	public static function url($colHash='')
	{
		$url=System::getUrl().'collection/'.$colHash;

		return $url;
	}

	public static function saveCache($userid=1,$listID='')
	{
		if(!preg_match_all('/(\d+)/i', $listID, $matches))
		{
			return false;
		}

		$inputData=$matches[1];

		sort($inputData);

		$listID=implode(',', $inputData);

		$listHash=md5(trim($listID));

		$savePath=ROOT_PATH.'contents/fastecommerce/collectionproduct/'.$listHash.'.cache';

		if(file_exists($savePath))
		{
			return $listHash;
		}

		$loadUser=Users::exists($userid);

		if(!$loadUser)
		{
			$userid=0;
		}

		$total=count($inputData);

		$result=array();

		for ($i=0; $i < $total; $i++) { 
			$theID=$inputData[$i];

			$loadProd=Products::exists($theID);

			if($loadProd==true)
			{
				$result[]=$theID;
			}
		}

		$insertData=array(
			'userid'=>$userid,
			'product'=>$result
			);

		File::create($savePath,serialize($insertData));	

		return $listHash;
			
	}

	public static function cachePath()
	{
		$result=ROOT_PATH.'application/caches/dbcache/system/collections_products/';

		return $result;
	}	


}