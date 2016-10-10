<?php

function apiProcess($keyName='')
{
	$result=Media::api($keyName);

	return $result;
}