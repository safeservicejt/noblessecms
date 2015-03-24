<?php

function listTheme()
{


	$listDir=Dir::listDir(THEMES_PATH);

	$total=count($listDir);

	$result=array();

	for($i=0;$i<$total;$i++)
	{
		$path=THEMES_PATH.$listDir[$i].'/';
		$url=THEMES_URL.$listDir[$i].'/';


		$result[$listDir[$i]]=file($path.'info.txt');

		$result[$listDir[$i]]['thumbnail']=$url.'thumb.jpg';

	}

	return $result;
}

function activateTheme($themeName)
{
	$configData=file_get_contents(ROOT_PATH.'config.php');

	$configData=preg_replace('/define\(\'THEME_NAME\', \'(\w+)\'\)/i', "define('THEME_NAME', '$themeName')", $configData);

	File::create(ROOT_PATH.'config.php',$configData);


}


?>