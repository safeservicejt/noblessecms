<?php

function importProcess()
{
	$alert='<div class="alert alert-warning">Error. Choose files agains!</div>';

	$resultData=File::uploadMultiple('theFile','uploads/tmp/');

	if((int)$id <= 0)
	{
		return false;
	}

	$total=count($resultData);

	for($i=0;$i<$total;$i++)
	{
		$targetPath='';

		$theFile=$resultData[$i];

		$sourcePath=ROOT_PATH.$theFile;

		$shortPath='contents/themes/'.basename($theFile);

		$targetPath.=$shortPath;

		File::move($sourcePath,$targetPath);

		$sourcePath=dirname($sourcePath);

		rmdir($sourcePath);

		File::unzipModule($targetPath,'yes');
	}

	$alert='<div class="alert alert-success">Success. Import & unzip themes successful!</div>';

	return $alert;
}
function themeInfo()
{
	$path=ROOT_PATH.'contents/themes/'.THEME_NAME.'/';

	$resultData=array();

	$resultData=file($path.'info.txt');

	$resultData['name']=THEME_NAME;

	return $resultData;
}

function listTheme()
{


	$listDir=Dir::listDir(THEMES_PATH);

	$total=count($listDir);

	$result=array();

	for($i=0;$i<$total;$i++)
	{
		if($listDir[$i]==THEME_NAME)
		{
			continue;
		}
		
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