<?php

function updateProcess($userid)
{
	$send=Request::get('send',false);

	if(!$send)
	{
		throw new Exception('Data not valid.');
		
	}

	$valid=Validator::make(array(
		'send.affiliaterankid'=>'number|min:1|slashes',
		'send.points'=>'number|min:1|slashes',
		'send.reviews'=>'number|min:1|slashes',
		'send.balance'=>'min:1|slashes',
		'send.affiliate_orders'=>'number|min:1|slashes',
		));

	if(!$valid)
	{
		throw new Exception($e->getMessage());
		
	}

	Customers::update($userid,$send);

	AffiliatesRanks::changeRank($userid,$send['affiliaterankid']);
}