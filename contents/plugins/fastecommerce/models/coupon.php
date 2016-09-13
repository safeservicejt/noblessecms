<?php


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

			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			if($owner=='no')
			{
				Alert::make('Page not found');
			}
			
			// Coupons::remove($id);

			Coupons::saveCache();

			break;


		case 'publish':

			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			if($owner=='no')
			{
				Alert::make('Page not found');
			}

			Coupons::update($id,array(
				'status'=>'1'
				),"id IN ($listID)");

			Coupons::saveCache();

			break;

		case 'unpublish':

			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			if($owner=='no')
			{
				Alert::make('Page not found');
			}

			Coupons::update($id,array(
				'status'=>'0'
				),"id IN ($listID)");

			Coupons::saveCache();

			break;

	}
}

function insertProcess()
{
	$valid=Validator::make(array(
		'send.type'=>'min:1',
		'send.amount'=>'min:1',
		'send.date_start'=>'min:1',
		'send.date_end'=>'min:1',
		'send.freeshipping'=>'min:1',
		));

	if(!$valid)
	{
		throw new Exception(Validator::getMessage());
	}

	$send=Request::get('send');

	if(!$id=Coupons::insert($send))
	{
		throw new Exception(Database::$error);
		
	}

	Coupons::saveCache();

}

function updateProcess($id)
{
	$valid=Validator::make(array(
		'send.type'=>'min:1',
		'send.amount'=>'min:1',
		'send.date_start'=>'min:1',
		'send.date_end'=>'min:1',
		'send.freeshipping'=>'min:1',
		));

	if(!$valid)
	{
		throw new Exception(Validator::getMessage());
	}

	$send=Request::get('send');


	if(!Coupons::update($id,$send))
	{
		throw new Exception(Database::$error);
	}

	Coupons::saveCache();

}
