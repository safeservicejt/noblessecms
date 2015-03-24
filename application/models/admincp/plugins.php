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

		$shortPath='contents/plugins/'.basename($theFile);

		$targetPath.=$shortPath;

		File::move($sourcePath,$targetPath);

		$sourcePath=dirname($sourcePath);

		rmdir($sourcePath);

		File::unzipModule($targetPath,'yes');
	}

	$alert='<div class="alert alert-success">Success. Import & unzip plugins successful!</div>';

	return $alert;
}

function listControl($foldername,$funcname)
{
	$resultData=array();

	$query=Database::query("select metaid,path,zonename,limit_number,layoutname,layoutposition,pagename,variablename,status from plugins_meta where foldername='$foldername' AND func='$funcname'");

	$num_rows=Database::num_rows($query);

	if((int)$num_rows > 0)
	{
		while($row=Database::fetch_assoc($query))
		{
			$resultData[]=$row;
		}
	}

	return $resultData;
}

function updateControl($foldername,$func,$inputData=array())
{
	// $func=base64_decode($func);

	$query=Database::query("select zonename,metaid,layoutname from plugins_meta where foldername='$foldername' AND func='$func'");

	$num_rows=Database::num_rows($query);

	while($row=Database::fetch_assoc($query))
	{
		Plugins::removeZone($row['zonename'],array('metaid'=>$row['metaid']));

		Cache::removeKey('caches_'.$row['zonename'].'_'.$row['layoutname']);	

		Cache::removeKey('caches_'.$row['zonename']);

	
	}

	Database::query("delete from plugins_meta where foldername='$foldername' AND func='$func'");

	Plugins::$canAddZone='yes';
	Plugins::$folderName=$foldername;

	$total=count($inputData['limit']);

	for($i=0;$i<$total;$i++)
	{
		$limit=$inputData['limit'][$i];
		$layout=$inputData['layout'][$i];
		$position=$inputData['position'][$i];
		$sort_order=$inputData['sort_order'][$i];
		$width=$inputData['width'][$i];
		$height=$inputData['height'][$i];
		$status=($inputData['status'][$i]=='enable')?'1':'0';

		// Database::query("insert into plugins_meta(foldername,zonename,func,limit_number,layoutname,layoutposition,img_width,img_height,pagename,status) values('$foldername','$position','$func','$limit','$layout','$sort_order','$width','$height','$layout','$status')");

		// $metaid=Database::insert_id();

		Plugins::add($position,array('func'=>$func,'layoutname'=>$layout,'pagename'=>$layout,'img_width'=>$width,'img_height'=>$height,'layoutposition'=>$sort_order,'status'=>$status,'foldername'=>$foldername,'limit'=>$limit,'sort_order'=>$sort_order));


	}
}

function listPlugins()
{
	
	$resultData=array();

	$listFolders=array();

	$query=Database::query("select foldername,status from plugins_meta");

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

	$listDir=Dir::listDir(PLUGINS_PATH);

	// print_r($listDir);die();

	$total=count($listDir);

	for($i=0;$i<$total;$i++)
	{
		Plugins::$setting='no';
		Plugins::$control='no';
		Plugins::$controlTitle='no';

		$folderName=$listDir[$i];

		$pluginPath=PLUGINS_PATH.$folderName.'/';

		require($pluginPath.$folderName.'.php');

		$pluginInfo=file($pluginPath.'info.txt');

		$resultData[$i]['title']=$pluginInfo[0];
		$resultData[$i]['author']=$pluginInfo[1];
		$resultData[$i]['version']=$pluginInfo[2];
		$resultData[$i]['summary']=$pluginInfo[3];
		$resultData[$i]['url']=$pluginInfo[4];
		$resultData[$i]['foldername']=$folderName;
		$resultData[$i]['status']=isset($listFolders[$folderName])?$listFolders[$folderName]:'0';
		$resultData[$i]['install']='no';

		$resultData[$i]['control']=strtolower(Plugins::$control);	

		$resultData[$i]['setting']=strtolower(Plugins::$setting);	


		if(isset($listFolders[$folderName]))
		{
			$resultData[$i]['install']='yes';		
		}

	}
	// print_r($resultData);die();
	return $resultData;
}

?>