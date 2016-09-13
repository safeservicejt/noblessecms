<?php


function actionShippingRateProcess()
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

			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			if($owner=='no')
			{
				Alert::make('Page not found');
			}
			
			ShippingRates::remove($id);
			ShippingRates::saveAllToCache();	

			break;


		case 'enable':

			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			if($owner=='no')
			{
				Alert::make('Page not found');
			}

			ShippingRates::update($id,array(
				'status'=>'1'
				),"id IN ($listID)");

			ShippingRates::saveAllToCache();

			break;

		case 'disabled':

			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			if($owner=='no')
			{
				Alert::make('Page not found');
			}

			ShippingRates::update($id,array(
				'status'=>'pending'
				),"id IN ($listID)");

			ShippingRates::saveAllToCache();

			break;

	}
}


function insertShippingRateProcess()
{
	$valid=Validator::make(array(
		'send.title'=>'min:1|slashes',
		));

	if(!$valid)
	{
		throw new Exception(Validator::getMessage());
	}

	$send=Request::get('send');

	if(!$id=ShippingRates::insert($send))
	{
		throw new Exception(Database::$error);
		
	}

	ShippingRates::saveCache($id);	
	ShippingRates::saveAllToCache();	
}

function updateShippingRateProcess($id)
{
	$valid=Validator::make(array(
		'send.title'=>'min:1|slashes',
		));

	if(!$valid)
	{
		throw new Exception(Validator::getMessage());
	}

	$send=Request::get('send');

	if(!ShippingRates::update($id,$send))
	{
		throw new Exception(Database::$error);
	}

	ShippingRates::saveCache($id);	
	ShippingRates::saveAllToCache();	
}

