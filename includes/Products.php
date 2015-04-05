<?php

class Products
{
	private static $productData=array();
	private static $productid=0;

	private static $discount=0;


	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="productid,title,model,sku,quantity,image,price,points,minimum,sort_order,manufacturerid,date_added,viewed,status,customerid,is_featured,date_featured,attributes,date_discount,date_enddiscount,is_shipping,quantity_discount,price_discount,keywords,friendly_url,content,upc,date_available";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added asc';

		$result=array();
		
		$command="select $selectFields from products $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

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
				if(isset($row['content']))
				{
					$row['content']=String::decode($row['content']);
				}				
				if(isset($row['title']))
				{
					$row['title']=String::decode($row['title']);
				}				
				if(isset($row['keywords']))
				{
					$row['keywords']=String::decode($row['keywords']);
				}		
						
				if(isset($row['image']))
				{
					$row['imageUrl']=Render::thumbnail($row['image']);
				}

				$row['date_added']=isset($row['date_added'])?Render::dateFormat($row['date_added']):'';
				
				if(isset($row['productid']) && isset($row['friendly_url']))
				{
					$row['url']=Url::product($row);						
				}


				$row['image']=isset($row['image'])?ROOT_URL.$row['image']:'';

				if(isset($row['price']))
				{
					$row['price']=self::thePrice($row);	

					$row['isDiscount']=self::$discount;		

					$getData=Currency::parsePrice($row['price']);

					$row['price']=$getData['real'];

					$row['priceFormat']=$getData['format'];
				}


				if(isset($inputData['isHook']) && $inputData['isHook']=='yes')
				{
					$row['content']=isset($row['content'])?Shortcode::load($row['content']):'';
				}
											
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}


		if(isset($inputData['isHook']) && $inputData['isHook']=='yes')
		{

			$result=self::plugin_hook_prod($result);

		}
		return $result;
		
	}

	public function isDiscount($row=array())
	{
		if(!isset($row['date_discount']) || !isset($row['date_enddiscount']))
		{
			return false;
		}

		$today=time();

		$startDiscount=(is_null($row['date_discount']))?strtotime($row['date_discount']):'';

		$endDiscount=(is_null($row['date_enddiscount']))?strtotime($row['date_enddiscount']):'';

		if($startDiscount!='' && $endDiscount!='' && $startDiscount >= $today && $endDiscount <= $startDiscount)
		{
			return true;
		}		

		return false;
	}

	public function thePrice($row=array())
	{
		self::$discount=0;

		$today=time();

		$startDiscount=(isset($row['date_discount']) && is_null($row['date_discount']))?strtotime($row['date_discount']):'';

		$endDiscount=(isset($row['date_enddiscount']) && is_null($row['date_enddiscount']))?strtotime($row['date_enddiscount']):'';

		$priceDiscount=isset($row['price_discount'])?$row['price_discount']:0;

		$price=isset($row['price'])?$row['price']:0;

		if($startDiscount!='' && $endDiscount!='' && $startDiscount >= $today && $endDiscount <= $startDiscount)
		{
			self::$discount=1;

			$price=$priceDiscount;
		}

		return $price;
	}

	private function plugin_hook_prod($inputData=array())
	{

		if(isset(Plugins::$zoneCaches['process_product_title']))
		{

			$totalPost=count($inputData);

			$totalPlugin=count(Plugins::$zoneCaches['process_product_title']);

			for($i=0;$i<$totalPlugin;$i++)
			{
				$plugin=Plugins::$zoneCaches['process_product_title'][$i];

				$foldername=$plugin[$i]['foldername'];

				$func=$plugin[$i]['func'];

				$pluginPath=PLUGINS_PATH.$foldername.'/'.$foldername.'.php';

				if(!file_exists($pluginPath))
				{
					continue;
				}

				if(!function_exists($func))
				{
					require($pluginPath);
				}
				$tmpStr='';
				for($j=0;$j<$totalPost;$j++)
				{
					$tmpStr=$func($inputData[$j]['title']);

					if(isset($tmpStr[1]))
					{
						$inputData[$j]['title']=$tmpStr;
					}				
				}

			}			
		}


		if(isset(Plugins::$zoneCaches['process_product_content']))
		{

			$totalPlugin=count(Plugins::$zoneCaches['process_product_content']);

			for($i=0;$i<$totalPlugin;$i++)
			{
				$plugin=Plugins::$zoneCaches['process_product_content'][$i];

				$foldername=$plugin[$i]['foldername'];

				$func=$plugin[$i]['func'];

				$pluginPath=PLUGINS_PATH.$foldername.'/'.$foldername.'.php';

				if(!file_exists($pluginPath))
				{
					continue;
				}

				if(!function_exists($func))
				{
					require($pluginPath);
				}
				$tmpStr='';
				for($j=0;$j<$totalPost;$j++)
				{
					$tmpStr=$func($inputData[$j]['content']);	

					if(isset($tmpStr[1]))
					{
						$inputData[$j]['content']=$tmpStr;
					}							
				}

			}			
		}

		return $inputData;
	}

	public function url($row=array())
	{
		return Url::product($row);
	}

	public function categories($id)
	{
		$resultData=array();

		// $query=Database::query("select pc.catid,c.cattitle from products_categories pc,categories c where pc.catid=c.catid AND pc.productid='$id'");

		$query=Database::query("select catid,cattitle from categories where catid IN (select catid from products_categories where productid='$id')");

		$total=Database::num_rows($query);

		if((int)$total > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				$resultData[]=$row;
			}
			
		}

		return $resultData;
	}
	public function downloads($id)
	{
		$resultData=array();

		$query=Database::query("select downloadid,title,filename,date_added,remaining from downloads where downloadid IN (select downloadid from products_downloads where productid='$id')");

		$total=Database::num_rows($query);

		if((int)$total > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				$resultData[]=$row;
			}
		}

		return $resultData;
	}
	public function images($id)
	{
		$resultData=prodImages::get(array(
			'where'=>"where productid='$id'",
			'orderby'=>"order by sort_order asc"
			));

		return $resultData;
	}
	public function pages($id)
	{
		$resultData=array();

		$query=Database::query("select pageid,title from pages where pageid IN (select pageNodeid from products_pages where productid='$id')");

		$total=Database::num_rows($query);

		if((int)$total > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				$resultData[]=$row;
			}
		}

		return $resultData;
	}

	public function tags($id)
	{
		$resultData=prodTags::get(array(
			'where'=>"where productid='$id'"
			));

		return $resultData;
	}

	public function update($id,$post=array(),$whereQuery='',$addWhere='')
	{

		if(isset($post['content']))
		{
			$post['content']=Shortcode::toBBcode($post['content']);
			
			$post['content']=strip_tags($post['content']);
			
			$post['content']=String::encode($post['content']);
		}
		if(isset($post['title']))
		{
			$post['title']=String::encode($post['title']);
		}				
		if(isset($post['keywords']))
		{
			$post['keywords']=String::encode($post['keywords']);
		}	
		if(isset($post['price']))
		{
			$post['price']=Currency::insertPrice($post['price']);
		}

		if(is_numeric($listID))
		{
			$catid=$listID;

			unset($listID);

			$listID=array($catid);
		}

		$listIDs="'".implode("','",$listID)."'";

		// print_r($post);die();
		$keyNames=array_keys($post);

		$total=count($post);

		$setUpdates='';

		for($i=0;$i<$total;$i++)
		{
			$keyName=$keyNames[$i];
			$setUpdates.="$keyName='$post[$keyName]', ";
		}

		$setUpdates=substr($setUpdates,0,strlen($setUpdates)-2);

		$whereQuery=isset($whereQuery[5])?$whereQuery:"productid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";
		
		Database::query("update products set $setUpdates where $whereQuery $addWhere");

		// echo "update products set $setUpdates where productid='$id'";die();

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


	public function insert($inputData=array())
	{
		if(isset($inputData['content']))
		{
			$inputData['content']=Shortcode::toBBcode($inputData['content']);

			$inputData['content']=strip_tags($inputData['content']);

			$inputData['content']=String::encode($inputData['content']);
		}

		$inputData['friendly_url']=String::encode(Url::makeFriendly($inputData['title']));
		
		if(isset($inputData['title']))
		{
			$inputData['title']=String::encode($inputData['title']);
		}				
		if(isset($inputData['keywords']))
		{
			$inputData['keywords']=String::encode($inputData['keywords']);
		}	
		if(isset($inputData['price']))
		{
			$inputData['price']=Currency::insertPrice($inputData['price']);
		}

		$inputData['date_added']=date('Y-m-d h:i:s');

		$userNodeid=Session::get('userid');

		$inputData['customerid']=$userNodeid;
		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Plugins::load('before_insert_product',$inputData);

		Database::query("insert into products($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			Database::query("update $dbName set sort_order='$id' where productid='$nodeid'");	

			$inputData['productid']=$id;
			
			Plugins::load('after_insert_product',$inputData);

			return $id;		
		}

		return false;
	
	}

	public function insertDownloads($id,$listDownloads=array())
	{

		if(!isset($listDownloads[0]))
		{
			return false;
		}

		$total=count($listDownloads);

		if(isset($listDownloads[0][4]))
		for($i=0;$i<$total;$i++)
		{
			$downloadid=$listDownloads[$i];

			prodDownloads::insert(array(
				'productid'=>$id,
				'downloadid'=>$downloadid
				));
		}

	}
	public function insertPages($id,$listDownloads=array())
	{

		if(!isset($listDownloads[0]))
		{
			return false;
		}

		$total=count($listDownloads);

		if(isset($listDownloads[0][4]))
		for($i=0;$i<$total;$i++)
		{
			$downloadid=$listDownloads[$i];

			prodPages::insert(array(
				'productid'=>$id,
				'pageid'=>$downloadid
				));					
		}

	}

	public function insertTags($id,$strTags)
	{
		if(!isset($strTags[1]))
		{
			return false;
		}	
		$listTags=explode(",",$strTags);

		$total=count($listTags);
		
		if(isset($listDownloads[0][4]))
		for($i=0;$i<$total;$i++)
		{
			$tag=$listTags[$i];

			prodTags::insert(array(
				'productid'=>$id,
				'tag_title'=>$tag
				));		
		}

	}


	public function insertImages($id,$keyName='images')
	{
		$resultData=File::uploadMultiple($keyName,'uploads/images/');

		if(!isset($resultData[0][4]))
		{
			return false;
		}

		$total=count($resultData);

		for($i=0;$i<$total;$i++)
		{
			$theFile=$resultData[$i];

			$insertData=array(
				'productid'=>$id,
				'image'=>$theFile,
				'sort_order'=>$i
				);

			prodImages::insert($insertData);
		}		
	}

	public function insertThumbnail($id,$method='frompc',$keyName='pcThumbnail')
	{
		switch ($method) {
			case 'frompc':

				if(preg_match('/.*?\.\w+/i', $_FILES[$keyName]['name']))
				{
					if(!$previewImg=File::upload('pcThumbnail','uploads/images/'))
					{
						$alert='<div class="alert alert-warning">Error. Upload image error!</div>';

						return $alert;
					}				
				}

				break;

			case 'fromurl':

				$imgUrl=Request::get($keyName,'');

				if(isset($imgUrl[4]))
				{
					if(!$previewImg=File::uploadFromUrl($imgUrl,'uploads/images/'))
					{
						$alert='<div class="alert alert-warning">Error. Upload image error!</div>';

						return $alert;
					}				
				}

				break;
		}

		$updateData=array();

		$updateData['image']=$previewImg;

		Products::update($id,$updateData);

	}


	public function insertCategories($id,$listCatid)
	{
		if(!isset($listCatid[0]))
		{
			return false;
		}		
		$total=count($listCatid);


		for($i=0;$i<$total;$i++)
		{
			$catid=$listCatid[$i];

			Database::query("insert into products_categories(productid,catid) values('$id','$catid')");

			Multidb::increasePost();							
		}

	}

	public function remove($post=array())
	{
		if(is_numeric($post))
		{
			$id=$post;

			unset($post);

			$post=array($id);
		}

		if(!isset($post[0][4]))
		{
			return false;
		}

		$total=count($post);

		$listID="'".implode("','",$post)."'";		

		$command="select orderid from orders_products where productid in ($listID)";

		$query=Database::query($query);

		$num_rows=Database::num_rows($query);

		if((int)$num_rows == 0)
		{
			for($i=0;$i<$total;$i++)
			{

				$theID=$post[$i];

				$loadData=self::get(array(
					'where'=>"where productid='$theID'"
					));

				if(!isset($loadData[0]['productid']))
				{
					continue;
				}

				if(isset($loadData[0]['image'][4]))
				{
					$fullPath=ROOT_PATH.$loadData[0]['image'];

					$listDir=Dir::all($fullPath);

					if(!isset($listDir[0]) && file_exists($fullPath))
					{
						unlink($fullPath);

						$fullPath=dirname($fullPath);

						rmdir($fullPath);
					}
				}
			}
			
			prodCategories::remove($post);

			prodDownloads::remove($post);

			prodImages::remove($post);

			prodPages::remove($post);

			prodTags::remove($post);
			
			$command="delete from products where productid IN ($listID)";

			Database::query($command);	
		}

		
	}





}


?>