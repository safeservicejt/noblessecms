<?php


function importProcess()
{

	$resultData=File::uploadMultiple('theFile','uploads/tmp/');

	$total=count($resultData);

	for($i=0;$i<$total;$i++)
	{
		$targetPath='';

		$theFile=$resultData[$i];

		$sourcePath=ROOT_PATH.$theFile;

		$shortPath='contents/themes/'.basename($theFile);

		$targetPath.=$shortPath;

		File::unzipModule($targetPath,'yes');

		if(!file_exists($targetPath.'/thumb.jpg'))
		{
			// $listDir=Dir::listDir($targetPath);
			copyNested($targetPath.'/');
		}
		else
		{
			Dir::copy($targetPath,ROOT_PATH.'uploads/tmp/'.$shortPath);
		}
	}


	
}

function copyNested($targetPath='')
{
	$listDir=Dir::listDir($targetPath);

	$totalDir=count($listDir);

	if((int)$totalDir > 0)
	for ($i=0; $i < $totalDir; $i++) { 
		$theDir=$targetPath.$listDir[$i].'/';

		if(!file_exists($theDir.'thumb.jpg'))
		{
			copyNested($theDir);
			continue;
		}

		Dir::copy($theDir,ROOT_PATH.'uploads/tmp/contents/themes/'.$listDir[$i].'/');
	}

}
