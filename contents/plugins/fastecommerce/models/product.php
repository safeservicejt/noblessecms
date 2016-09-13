<?php


function actionProcess()
{
	$action=Request::get('action');

	$id=Request::get('id');

	$listID="'".implode("','",$id)."'";

	switch ($action) {
		case 'delete':

			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			if($owner=='no')
			{
				$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_remove_product');

				if($valid!='yes')
				{
					throw new Exception('You not have permission on this action.');
				}

				$total=count($id);

				$userid=Users::getCookieUserId();

				for ($i=0; $i < $total; $i++) { 

					$theID=$id[$i];

					$loadData=Products::get(array(
						'cache'=>'no',
						'where'=>"where id='$theID' AND userid='$userid'"
						));

					if(!isset($loadData[0]['id']))
					{
						unset($id[$i]);
					}

				}

				sort($id);
			}
			
			Products::removeCache($id);
			Reviews::removeCache($id);
			break;


		case 'publish':

			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			if($owner=='no')
			{
				$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_update_product');

				if($valid!='yes')
				{
					throw new Exception('You not have permission on this action.');
				}

				$total=count($id);

				$userid=Users::getCookieUserId();

				for ($i=0; $i < $total; $i++) { 

					$theID=$id[$i];

					$loadData=Products::get(array(
						'cache'=>'no',
						'where'=>"where id='$theID' AND userid='$userid'"
						));

					if(!isset($loadData[0]['id']))
					{
						unset($id[$i]);
					}

				}

				sort($id);
			}

			Products::update($id,array(
				'status'=>'publish'
				),"id IN ($listID)");

			$total=count($id);

			for ($i=0; $i < $total; $i++) { 
				Products::saveCache($id[$i]);
			}

			break;

		case 'unpublish':

			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			if($owner=='no')
			{
				$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_update_product');

				if($valid!='yes')
				{
					throw new Exception('You not have permission on this action.');
				}

				$total=count($id);

				$userid=Users::getCookieUserId();

				for ($i=0; $i < $total; $i++) { 

					$theID=$id[$i];

					$loadData=Products::get(array(
						'cache'=>'no',
						'where'=>"where id='$theID' AND userid='$userid'"
						));

					if(!isset($loadData[0]['id']))
					{
						unset($id[$i]);
					}

				}

				sort($id);
			}

			Products::update($id,array(
				'status'=>'pending'
				),"id IN ($listID)");

			$total=count($id);

			for ($i=0; $i < $total; $i++) { 
				Products::saveCache($id[$i]);
			}

			break;

		case 'setFeatured':

			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			if($owner=='no')
			{
				$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_update_product');

				if($valid!='yes')
				{
					throw new Exception('You not have permission on this action.');
				}

				$total=count($id);

				$userid=Users::getCookieUserId();

				for ($i=0; $i < $total; $i++) { 

					$theID=$id[$i];

					$loadData=Products::get(array(
						'cache'=>'no',
						'where'=>"where id='$theID' AND userid='$userid'"
						));

					if(!isset($loadData[0]['id']))
					{
						unset($id[$i]);
					}

				}

				sort($id);
			}

			Products::update($id,array(
				'is_featured'=>1,
				'date_featured'=>date('Y-m-d H:i:s')
				),"id IN ($listID)");

			$total=count($id);

			for ($i=0; $i < $total; $i++) { 
				Products::saveCache($id[$i]);
			}
			break;

		case 'unsetFeatured':

			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			if($owner=='no')
			{
				$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_update_product');

				if($valid!='yes')
				{
					throw new Exception('You not have permission on this action.');
				}

				$total=count($id);

				$userid=Users::getCookieUserId();

				for ($i=0; $i < $total; $i++) { 

					$theID=$id[$i];

					$loadData=Products::get(array(
						'cache'=>'no',
						'where'=>"where id='$theID' AND userid='$userid'"
						));

					if(!isset($loadData[0]['id']))
					{
						unset($id[$i]);
					}

				}

				sort($id);
			}

			Products::update($id,array(
				'is_featured'=>0
				),"id IN ($listID)");

			$total=count($id);

			for ($i=0; $i < $total; $i++) { 
				Products::saveCache($id[$i]);
			}
			
			break;
	}
}

function insertProcess()
{
	$valid=Validator::make(array(
		'send.price'=>'min:1',
		'send.quantity'=>'min:1',
		'send.weight'=>'min:1',
		'send.shipping_class'=>'min:1',
		));

	if(!$valid)
	{
		throw new Exception(Validator::getMessage());
	}

	$send=Request::get('send');

	$send['title']=ucwords($send['title']);

	$is_stock_manage=trim(Request::get('is_stock_manage',0));

	$send['quantity']=((int)$is_stock_manage==0)?999999:$send['quantity'];

	if((int)$is_stock_manage==1 && (int)$send['quantity']==0)
	{
		$send['quantity']=99999;
	}

	if(isset($send['sale_price']) && (double)$send['sale_price']<=0)
	{
		$send['sale_price']=$send['price'];
	}

	$send['enable_review']=isset($send['enable_review'])?$send['enable_review']:0;
	
	$send['status']=isset($send['status'])?$send['status']:'pending';

	$send['rating']=5;

	if(!$id=Products::insert($send))
	{
		throw new Exception(Database::$error);
		
	}

	Products::addThumbnail($id,'thumbnail');

	ProductImages::add($id,'images');

	Products::addAttr($id,Request::get('attr_name',''),Request::get('attr_values',''));

	ProductTags::add($id,Request::get('tags',''));

	$tagFriendy=String::makeFriendlyUrl(strip_tags(Request::get('tags','')));

	ProductTags::saveCache($tagFriendy);

	ProductCategories::add($id,Request::get('catid',array()));	

	Products::addDownload($id,'downloads');

	Products::updateData($id);

	Products::saveCache($id);

	Redirect::to(CtrPlugin::url('product','edit').$id);

}

function updateProcess($id)
{
	$valid=Validator::make(array(
		'send.price'=>'min:1',
		'send.quantity'=>'min:1',
		'send.weight'=>'min:1',
		'send.shipping_class'=>'min:1',
		));

	if(!$valid)
	{
		throw new Exception(Validator::getMessage());
	}

	$send=Request::get('send');

	$send['title']=ucwords($send['title']);

	$is_stock_manage=trim(Request::get('is_stock_manage',0));

	$send['quantity']=((int)$is_stock_manage==0)?999999:$send['quantity'];

	if((int)$is_stock_manage==1 && (int)$send['quantity']==0)
	{
		$send['quantity']=99999;
	}

	if(isset($send['sale_price']) && (double)$send['sale_price']<=0)
	{
		$send['sale_price']=$send['price'];
	}
	
	$send['enable_review']=isset($send['enable_review'])?$send['enable_review']:0;
	
	$send['status']=isset($send['status'])?$send['status']:'pending';

	if(!Products::update($id,$send))
	{
		throw new Exception(Database::$error);
	}

	if(isset($_FILES['thumbnail']['tmp_name']) && preg_match('/.*?\.\w+$/i', $_FILES['thumbnail']['name']))
	{
		Products::addThumbnail($id,'thumbnail');
	}
	
	if(isset($_FILES['images']['tmp_name'][0]) && preg_match('/.*?\.\w+$/i', $_FILES['images']['name'][0]))
	{
		ProductImages::remove(array($id));

		ProductImages::add($id,'images');
	}
	else
	{
		$images=Request::get('images',array());

		$total=count($images);

		for ($i=0; $i < $total; $i++) { 
			$theID=$images[$i];

			ProductImages::update($theID,array(
				'sort_order'=>$i
				));
		}		
	}

	Products::addAttr($id,Request::get('attr_name',''),Request::get('attr_values',''));

	$tags=Request::get('tags','');

	if(isset($tags[2]))
	{
		ProductTags::remove($id);

		ProductTags::add($id,$tags);
	}
	
	ProductCategories::remove($id);

	ProductCategories::add($id,Request::get('catid',array()));

	Products::updateDownload($id,'downloads');

	Products::updateData($id);

	Products::saveCache($id);

}
