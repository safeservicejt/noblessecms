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
			
			Discounts::remove($id);

			Discounts::saveCache();

			break;


		case 'publish':

			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			if($owner=='no')
			{
				Alert::make('Page not found');
			}

			Discounts::update($id,array(
				'status'=>'1'
				),"id IN ($listID)");

			Discounts::saveCache();

			break;

		case 'unpublish':

			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			if($owner=='no')
			{
				Alert::make('Page not found');
			}

			Discounts::update($id,array(
				'status'=>'pending'
				),"id IN ($listID)");

			Discounts::saveCache();

			break;

	}
}

function insertProcess()
{
	$valid=Validator::make(array(
		'send.percent'=>'min:1',
		'send.date_discount'=>'min:1',
		'send.date_enddiscount'=>'min:1',
		'send.status'=>'min:1',
		));

	if(!$valid)
	{
		throw new Exception(Validator::getMessage());
	}

	$send=Request::get('send');

	if(!$id=Discounts::insert($send))
	{
		throw new Exception(Database::$error);
		
	}

	Discounts::saveCache();

}

function updateProcess($id)
{
	$valid=Validator::make(array(
		'send.percent'=>'min:1',
		'send.date_discount'=>'min:1',
		'send.date_enddiscount'=>'min:1',
		'send.status'=>'min:1',
		));

	if(!$valid)
	{
		throw new Exception(Validator::getMessage());
	}

	$send=Request::get('send');


	if(!Discounts::update($id,$send))
	{
		throw new Exception(Database::$error);
	}

	Discounts::saveCache();

}
