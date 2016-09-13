<?php

function theList()
{

	$savePath=ROOT_PATH.'contents/plugins/fastecommerce/paymentmethods/';

	$listFolder=Dir::listDir(ROOT_PATH.'contents/plugins/fastecommerce/paymentmethods/');

	$listDB=Payments::get(array(
		'cache'=>'no',
		'limitShow'=>300
		));

	$reList=array();

	$total=count($listDB);

	for ($i=0; $i < $total; $i++) { 
		$foldername=$listDB[$i]['foldername'];

		$reList[$foldername]=$listDB[$i];
	}

	$totalDir=count($listFolder);

	for ($i=0; $i < $totalDir; $i++) { 
		$dirName=$listFolder[$i];

		$dirPath=$savePath.$dirName.'/';

		$dirInfo=array(
			'foldername'=>$dirName,
			'title'=>ucfirst($dirName),
			'version'=>'1.0',
			'status'=>0
			);

		if(file_exists($dirPath.'info.txt'))
		{
			$dataInfo=file($dirPath.'info.txt');

			$dirInfo['title']=$dataInfo[0];
			$dirInfo['version']=$dataInfo[1];
		}

		if(!isset($reList[$dirName]))
		{
			$reList[$dirName]=$dirInfo;
		}
		else
		{
			$reList[$dirName]['title']=$dirInfo['title'];
			$reList[$dirName]['version']=$dirInfo['version'];
		}
	}

	

	return $reList;
}