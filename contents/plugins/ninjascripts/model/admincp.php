<?php

function saveDataProcess($fileName,$fileData='')
{
	if(!isset($fileName[1]))
	{
		throw new Exception('Data not valid.');
		
	}

	$fileData=trim($fileData);

	Cache::saveKey('ninjascripts/'.Database::getPrefix().$fileName,$fileData);
}

?>