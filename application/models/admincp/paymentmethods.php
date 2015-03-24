<?php


function listPaymentmethods()
{
	
	$resultData=array();

	$listFolders=array();

	$query=Database::query("select methodid,title,method_data,foldername,status from payment_methods");

	$num_rows=Database::num_rows($query);

	$folerName='';

	if((int)$num_rows > 0)
	{
		while($row=Database::fetch_assoc($query))
		{
			$folderName=$row['foldername'];

			$listFolders[$folderName]=$row['status'];

		}
	}

	$listDir=Dir::listDir(PMETHOD_PATH);

	// print_r($listDir);die();

	$total=count($listDir);

	for($i=0;$i<$total;$i++)
	{
		Plugins::$setting='no';

		$folderName=$listDir[$i];

		$pluginPath=PMETHOD_PATH.$folderName.'/';

		require($pluginPath.'index.php');

		$pluginInfo=file($pluginPath.'info.txt');

		$resultData[$i]['title']=$pluginInfo[0];
		$resultData[$i]['author']=$pluginInfo[1];
		$resultData[$i]['version']=$pluginInfo[2];
		$resultData[$i]['summary']=$pluginInfo[3];
		$resultData[$i]['url']=$pluginInfo[4];
		$resultData[$i]['foldername']=$folderName;
		$resultData[$i]['status']=isset($listFolders[$folderName])?$listFolders[$folderName]:'0';
		$resultData[$i]['install']='no';

		$resultData[$i]['setting']=isset(Paymentmethods::$load['setting'])?strtolower(Paymentmethods::$load['setting']):'';	
		
		if(isset($listFolders[$folderName]))
		{
			$resultData[$i]['install']='yes';		
		}

	}
	// print_r($resultData);die();
	return $resultData;
}

?>