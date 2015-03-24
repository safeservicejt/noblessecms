<?php


function processOrders()
{
	if(!$matches=Uri::match('api\/orders\/(\w+)'))
	{
		return '';
	}

	$methodName=$matches[1];

	// print_r($methodName);die();

	switch ($methodName) {

		case 'complete':
			
			// $valid=addProduct();

			if(!$valid)
			{
				return 'ERROR';
			}

			return 'OK';

			break;
		

	}

}

?>