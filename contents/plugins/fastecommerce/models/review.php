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
			
			Reviews::remove($id);

			// Reviews::saveCache();

			break;


		case 'publish':

			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			if($owner=='no')
			{
				Alert::make('Page not found');
			}

			Reviews::update($id,array(
				'status'=>'1'
				),"id IN ($listID)");

			// Reviews::saveCache();

			break;

		case 'unpublish':

			$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

			if($owner=='no')
			{
				Alert::make('Page not found');
			}

			Reviews::update($id,array(
				'status'=>'0'
				),"id IN ($listID)");

			// Reviews::saveCache();

			break;

	}
}