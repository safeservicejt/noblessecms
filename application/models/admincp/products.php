<?php

function editInfo($id)
{
	$resultData=array();

	$loadData=Products::get(array(
		'where'=>"where productid='$id'",
		'isHook'=>'no'
		));

	$resultData['data']=$loadData[0];

	$resultData['categories']=Products::categories($id);

	$resultData['pages']=Products::pages($id);

	$resultData['images']=Products::images($id);	

	$resultData['downloads']=Products::downloads($id);	

	$resultData['tags']='';

	if(isset($loadData[0]['manufacturerid'][4]))
	{
		$loadManu=Manufacturers::get(array(
			'where'=>"where manufacturerid='".$loadData[0]['manufacturerid']."'"
			));		

		if(isset($loadManu[0]['manufacturerid']))
		{
			$resultData['data']['manufacturer_title']=$loadManu[0]['manufacturer_title'];
		}
	}

	$loadTags=Products::tags($id);

	if(isset($loadTags[0]['productid']))
	{
		$li='';

		$total=count($loadTags);

		for($i=0;$i<$total;$i++)
		{
			$li.=$loadTags[$i]['tag_title'].', ';
		}

		$li=substr($li, 0,strlen($li)-2);

		$resultData['tags']=$li;		
	}	

	return $resultData;
}

function updateProcess($id)
{

	$valid=Validator::make(array(
		'send.title'=>'min:3|slashes',
		'send.keywords'=>'slashes',
		'tags'=>'slashes',
		'send.manufacturerid'=>'slashes',
		'send.points'=>'slashes',
		'send.model'=>'slashes',
		'send.sku'=>'slashes',
		'send.upc'=>'slashes',
		'send.price'=>'slashes',
		'send.quantity'=>'slashes',
		'send.minimum'=>'slashes',
		'send.date_available'=>'slashes',
		'send.is_shipping'=>'slashes',
		'send.status'=>'slashes',
		'send.quantity_discount'=>'slashes',
		'send.price_discount'=>'slashes',
		'send.date_discount'=>'slashes',
		'send.date_enddiscount'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error. Save changes error!");
		
	}

	// print_r(Request::get('tags'));die();

	$uploadIMGMethod=Request::get('uploadIMGMethod');

	$uploadFileMethod=Request::get('uploadFileMethod');

	$data=Request::get('send');

	if(!Products::update($id,$data))
	{
		throw new Exception("Error. ".Database::$error);
	}

	$loadData=Products::get(array(
		'where'=>"where productid='$id'"
		));

	$previewImg='';

	switch ($uploadIMGMethod) {
		case 'frompc':

			if(preg_match('/.*?\.\w+/i', $_FILES['pcThumbnail']['name']))
			{
				if(!$previewImg=File::upload('pcThumbnail','uploads/images/'))
				{
					throw new Exception("Error. Upload image error!");
				}				
			}

			break;

		case 'fromurl':

			$imgUrl=Request::get('urlThumbnail','');

			if(isset($imgUrl[4]))
			{
				if(!$previewImg=File::uploadFromUrl($imgUrl,'uploads/images/'))
				{
					throw new Exception("Error. Upload image error!");
				}				
			}

			break;
	}

	$updateData=array();

	if(isset($previewImg[4]))
	{
		$filePath=ROOT_PATH.$loadData[0]['image'];

		if(file_exists($filePath))
		{
			unlink($filePath);

			$filePath=dirname($filePath);

			rmdir($filePath);
		}

		$updateData['image']=$previewImg;

		Products::update($id,$updateData);		
	}	

	prodCategories::remove($id);
	
	prodDownloads::remove($id);

	prodTags::remove($id);

	prodPages::remove($id);

	prodImages::remove($id);

	Products::insertCategories($id,Request::get('catid'));

	Products::insertDownloads($id,Request::get('downloadid'));

	Products::insertTags($id,Request::get('tags'));

	Products::insertPages($id,Request::get('pageid'));

	Products::insertImages($id);
}
function insertProcess()
{

	$valid=Validator::make(array(
		'send.title'=>'min:3|slashes',
		'send.keywords'=>'slashes',
		'tags'=>'slashes',
		'send.manufacturerid'=>'slashes',
		'send.points'=>'slashes',
		'send.model'=>'slashes',
		'send.sku'=>'slashes',
		'send.upc'=>'slashes',
		'send.price'=>'slashes',
		'send.quantity'=>'slashes',
		'send.minimum'=>'slashes',
		'send.date_available'=>'slashes',
		'send.is_shipping'=>'slashes',
		'send.status'=>'slashes',
		'send.quantity_discount'=>'slashes',
		'send.price_discount'=>'slashes',
		'send.date_discount'=>'slashes',
		'send.date_enddiscount'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error. Add new product error!");
		
	}

	// print_r(Request::get('tags'));die();

	$uploadIMGMethod=Request::get('uploadIMGMethod');

	$uploadFileMethod=Request::get('uploadFileMethod');

	$data=Request::get('send');

	$data['status']=1;

	if(!$id=Products::insert($data))
	{
		throw new Exception("Error. ".Database::$error);
	}


	$previewImg='';

	switch ($uploadIMGMethod) {
		case 'frompc':

			if(preg_match('/.*?\.\w+/i', $_FILES['pcThumbnail']['name']))
			{
				if(!$previewImg=File::upload('pcThumbnail','uploads/images/'))
				{

					throw new Exception("Error. Upload image error!");
					
				}				
			}

			break;

		case 'fromurl':

			$imgUrl=Request::get('urlThumbnail','');

			if(isset($imgUrl[4]))
			{
				if(!$previewImg=File::uploadFromUrl($imgUrl,'uploads/images/'))
				{
					throw new Exception("Error. Upload image error!");
				}				
			}

			break;
	}

	$updateData=array();

	$updateData['image']=$previewImg;

	Products::update($id,$updateData);

	Products::insertCategories($id,Request::get('catid'));

	Products::insertDownloads($id,Request::get('downloadid'));

	Products::insertTags($id,Request::get('tags'));

	Products::insertPages($id,Request::get('pageid'));

	Products::insertImages($id);

	return $alert;
}

function actionProcess()
{
	$action=Request::get('action');

	$id=Request::get('id');

	if((int)$id <= 0)
	{
		return false;
	}

	$listID="'".implode("','",$id)."'";

	switch ($action) {
		case 'delete':
			Products::remove($id);
			break;

		case 'publish':
			Products::update($listID,array(
				'status'=>1
				),"productid IN ($listID)");
			break;
		case 'unpublish':
			Products::update($listID,array(
				'status'=>0
				),"productid IN ($listID)");
			break;
		case 'setFeatured':
			Products::update($listID,array(
				'is_featured'=>1,
				'date_featured'=>date('Y-m-d h:i:s')
				),"productid IN ($listID)");
			break;
		case 'unsetFeatured':
			Products::update($listID,array(
				'is_featured'=>0
				),"productid IN ($listID)");
			break;
		
	}
}

function searchProcess($txtKeyword)
{

	$curPage=Uri::getNext('news');

	if($curPage=='page')
	{
		$curPage=Uri::getNext('page');
	}
	else
	{
		$curPage=0;
	}

	$resultData=array();

	$resultData['pages']=genPage('news',$curPage);	

	$txtKeyword=trim($txtKeyword);

	Request::make('txtKeyword',$txtKeyword);

	$valid=Validator::make(array(
		'txtKeyword'=>'min:1|slashes'
		));

	if(!$valid)
	{
		$resultData['products']='';

		$resultData['pages']='';

		return $resultData;
	}

	if(preg_match('/^(\w+)\:(.*?)$/i', $txtKeyword,$matches))
	{
		$method=strtolower($matches[1]);

		$keyword=strtolower(trim($matches[2]));

		$method=($method=='productid')?'id':$method;
		$method=($method=='cat')?'category':$method;
		$method=($method=='pricebf')?'pricebefore':$method;
		$method=($method=='priceeq')?'priceequal':$method;
		$method=($method=='priceaf')?'priceafter':$method;

		switch ($method) {
			case 'id':
			$resultData['products']=Products::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where productid='$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'before':
			$resultData['products']=Products::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_added < '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'after':
			$resultData['products']=Products::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_added > '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'on':
			$resultData['products']=Products::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_added = '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;

			case 'pricebefore':
			$resultData['products']=Products::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where price < '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'priceafter':
			$resultData['products']=Products::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where price > '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'priceequal':
			$resultData['products']=Products::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where price='$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'quantitybefore':
			$resultData['products']=Products::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where quantity < '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'quantityafter':
			$resultData['products']=Products::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where quantity > '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'quantityequal':
			$resultData['products']=Products::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where quantity = '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'discounton':
			$resultData['products']=Products::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_discount >= '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'model':
			$resultData['products']=Products::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where model = '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'sku':
			$resultData['products']=Products::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where sku = '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'upc':
			$resultData['products']=Products::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where upc = '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'minimum':
			$resultData['products']=Products::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where minimum = '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'status':
			$resultData['products']=Products::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where status = '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'pricediscount':
			$resultData['products']=Products::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where price_discount = '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;

		}
		// print_r($matches);die();
	}
	else
	{
		$txtKeyword=String::encode($txtKeyword);

		preg_match('/"(.*?)"/i', $txtKeyword,$matches);

		$txtKeyword=$matches[1];
		
		$resultData['products']=Products::get(array(
			'limitShow'=>20,			
			'limitPage'=>$curPage,
			'where'=>"where title LIKE '%$txtKeyword%'",
			'orderby'=>'order by date_added desc',
			'isHook'=>'no'
			));	
	}

	// print_r($txtKeyword);die();

	return $resultData;
}

function topProdViews($limitShow=10)
{
    if($loadData=Cache::loadKey('topProdViews',300))
    {
        return $loadData;
    }

    $li='';

    $loadData=Products::get(array(
        'limitShow'=>$limitShow,
        'orderby'=>'order by viewed desc'
        ));

    $total=count($loadData);

    if(isset($loadData[0]['title']))
    {
        for($i=0;$i<$total;$i++)
        {

            $li.='
                    <!-- tr -->
                    <tr>
                    <td>'.ucfirst($loadData[$i]['title']).'</td>
                    <td class="text-right">'.$loadData[$i]['viewed'].'</td>
                    </tr>
                    <!-- tr -->

            ';
        }       
    }
    else
    {
        $li='
                    <!-- tr -->
                    <tr>
                    <td colspan="2">There are not have any views.</td>
                    </tr>
                    <!-- tr -->

        ';
    }

    Cache::saveKey('topProdViews',$li);
    
	return $li;
}
function lastSales($limitShow=10)
{
    if($loadData=Cache::loadKey('lastSales',300))
    {
        return $loadData;
    }	

    $li='';

	$command="select productid,quantity,price from orders_products $whereQuery";

	$command.=" order by date_added desc limit 0,$limitShow";
	
    $query=Database::query($command);

    $total=Database::num_rows($query);

    if((int)$total > 0)
    {
    	$listID='';

    	$loadData=array();

        while($row=Database::fetch_assoc($query))
        {
        	$listID="'".$row['productid']."', ";

        	$loadData=$row;
        }  

        $listID=substr($listID, 0,strlen($listID)-2);

        $loadProd=Products::get(array(
        	'where'=>"where productid IN ($listID)"
        	));     

        $total=count($loadProd);

        $totalOD=count($loadData);

        $resultData=array();

        for($i=0;$i<$total;$i++)
        {
        	for($j=0;$j<$totalOD;$j++)
        	{
        		if($loadProd[$i]['productid']==$loadData[$j]['productid'])
        		{
        			$resultData[$i]=$loadData[$j];

        			$resultData[$i]['title']=$loadProd[$i]['title'];
        		}
        	}
        }

        $total=count($resultData);

        for($i=0;$i<$total;$i++)
        {
        	$getData=Currency::parsePrice($resultData[$i]['price']);

        	$resultData[$i]['title']=String::decode($resultData[$i]['title']);

            $li.='
                    <!-- tr -->
                    <tr>
                    <td>'.$resultData[$i]['title'].'</td>
                    <td>'.$resultData[$i]['quantity'].'</td>
                     <td class="text-right">'.$getData['format'].'</td>

                    </tr>
                    <!-- tr -->

            ';
        }
    }
    else
    {
        $li='
                    <!-- tr -->
                    <tr>
                    <td colspan="2">There are not have any sales.</td>
                    </tr>
                    <!-- tr -->

        ';
    }

    Cache::saveKey('lastSales',$li);

	return $li;
}

function genProdImages($id)
{
	$selectImages=prodImages::get(array(
		'where'=>"where productid='$id'",
		'orderby'=>'order by sort_order asc'
		));

	$total=count($selectImages);

	$li='';
	for($i=0;$i<$total;$i++)
	{

		$li.='

	<!-- Row -->
		<div class="row" style="margin-top:20px;">
			<div class="col-lg-2">
			<img src="'.ROOT_URL.$selectImages[$i]['image'].'" class="img-responsive" />
			</div>
			<div class="col-lg-6">
				<span>'.$selectImages[$i]['image'].'</span>
			</div>
			<div class="col-lg-2">
							    <div class="input-group">
							      <input type="text" id="ipSortOrder" class="form-control" value="'.$selectImages[$i]['sort_order'].'" placeholder="Sort order">
							      <span class="input-group-btn">
							        <button class="btn btn-info" data-image="'.$selectImages[$i]['image'].'" id="btnSortOrder" type="button">Save</button>
							      </span>
							    </div><!-- /input-group -->									
			</div>

			<div class="col-lg-1">
				<button type="button" id="btnRemove" data-prodid="'.$id.'" data-image="'.$selectImages[$i]['image'].'" class="btn btn-danger">Remove</button>
			</div>
		</div>
		<!-- End row -->

		';
	}

	return $li;
}


?>