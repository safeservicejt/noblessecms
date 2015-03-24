<?php

function saveeSetting($post=array())
{
	// print_r($post);die();
	$path=ROOT_PATH.'uploads/setting.data';

	$loadData=file_get_contents($path);

	$loadData=json_decode($loadData,true);

	$total=count($post);

	$keyNames=array_keys($post);

	for($i=0;$i<$total;$i++)
	{
		$theKey=$keyNames[$i];

		$loadData[$theKey]=$post[$theKey];
	}

	$dataSave=json_encode($loadData);

	File::create($path,$dataSave);

	return true;
}


function saveBanner()
{
	if(isset($_FILES['bannerImg']['tmp_name']))
	{
		$fileName=$_FILES['bannerImg']['name'];

		preg_match('/.*?\.(\w+)$/i', $fileName,$matches);

		$imgPath='uploads/banner.'.$matches[1];

		move_uploaded_file($_FILES['bannerImg']['tmp_name'], ROOT_PATH.$imgPath);

		saveeSetting(array('bannerImg'=>$imgPath));
	}
}




?>