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
			
			TaxRates::removeCache($id);

			TaxRates::remove($id);

			

			// TaxRates::saveCache();

			break;


	}
}

function insertProcess()
{
	$valid=Validator::make(array(
		'send.title'=>'min:1',
		'send.type'=>'min:1',
		'send.amount'=>'min:1',
		));

	if(!$valid)
	{
		throw new Exception(Validator::getMessage());
	}

	$send=Request::get('send');

	$countries=Request::get('countries');

	$send['countries']=serialize($countries);

	if(!$id=TaxRates::insert($send))
	{
		throw new Exception(Database::$error);
		
	}

	TaxRates::saveCache($id);

}

function updateProcess($id)
{
	$valid=Validator::make(array(
		'send.title'=>'min:1',
		'send.type'=>'min:1',
		'send.amount'=>'min:1',
		));

	if(!$valid)
	{
		throw new Exception(Validator::getMessage());
	}

	$send=Request::get('send');

	$countries=Request::get('countries');

	$send['countries']=serialize($countries);

	if(!TaxRates::update($id,$send))
	{
		throw new Exception(Database::$error);
	}

	TaxRates::saveCache($id);

}
