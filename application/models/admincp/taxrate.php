<?php

function renderInsert($inputData=array())
{


	if(!isset($inputData[0]))
	{
		return 'worldwide';
	}

	$listCT=implode(',', $inputData);

	return $listCT;
}

function renderEdit($inputData='')
{
	if(!isset($inputData[0]))
	{
		return array('worldwide');
	}

	$listCT=explode(',', $inputData);

	return $listCT;
}


?>