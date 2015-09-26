<?php

class Match
{
	public static function getUrls($inputData='')
	{
		$result=array();

		if(preg_match_all('/(https?:\/\/[a-zA-Z0-9_\-\_\=\+\/\.\{\}\(\)\&\$\#\@\*\?\!\;]+)/i', $inputData, $matches))
		{
			$result=$matches[1];
		}

		return $result;
	}

	public static function getImages($inputData='')
	{
		$result=array();

		if(preg_match_all('/(https?:\/\/[a-zA-Z0-9_\-\_\=\+\/\.\{\}\(\)\&\$\#\@\*\?\!\;]+\.(gif|png|jpg|jpeg|bmp))/i', $inputData, $matches))
		{
			$result=$matches[1];
		}

		return $result;
	}

	public static function getEmails($inputData='')
	{
		$result=array();

		if(preg_match_all('/([a-zA-Z0-9_\-\_\.]+\@[a-zA-Z0-9_\-\.\-]+\.\w+)/i', $inputData, $matches))
		{
			$result=$matches[1];
		}

		return $result;		
	}
}
?>