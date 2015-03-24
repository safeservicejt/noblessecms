<?php

function processLang()
{
	if(!$matches=Uri::match('api\/lang\/(\w+)'))
	{
		return '';
	}	

	$resultData='';

	$method=trim($matches[1]);

	switch ($method) {
		case 'javascript':
			$resultData=lang::get('frontend/javascript');

			$resultData=json_encode($resultData);
			break;
	}


	return $resultData;

}


?>