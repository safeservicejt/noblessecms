<?php

class Match
{
	public function getUrls($inputData='')
	{
		$result=array();

		if(preg_match_all('/(https?:\/\/[a-zA-Z0-9_\-\_\=\+\/\.\{\}\(\)\&\$\#\@\*\?\!\;]+)/i', $inputData, $matches))
		{
			$result=$matches[1];
		}

		return $result;
	}

	public function getImages($inputData='')
	{
		$result=array();

		if(preg_match_all('/(https?:\/\/[a-zA-Z0-9_\-\_\=\+\/\.\{\}\(\)\&\$\#\@\*\?\!\;]+\.(gif|png|jpg|jpeg|bmp))/i', $inputData, $matches))
		{
			$result=$matches[1];
		}

		return $result;
	}

	public function getEmails($inputData='')
	{
		$result=array();

		if(preg_match_all('/([a-zA-Z0-9_\_\.]+\@[a-zA-Z0-9_\.]+)/i', $inputData, $matches))
		{
			$result=$matches[1];
		}

		return $result;		
	}
}
?>