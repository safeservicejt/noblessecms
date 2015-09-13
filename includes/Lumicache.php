<?php

/*
Document:

Remove file cached.

*/

class Lumicache
{


	public static function removeFiles($cachePath,$inputData)
	{

		// $filePath=CACHES_PATH.'dbcache/'.$cachePath;

		$listID=array();

		if(is_array($inputData))
		{
			$listID=$inputData;
		}
		else
		{
			if(!isset($inputData[1]))
			{
				return false;
			}

			if(preg_match_all('/(\w+)/i', $inputData, $matches))
			{
				$listID=$inputData[1];
			}
		}

		$total=count($listID);

		for ($i=0; $i < $total; $i++) { 
			$tmpPath='dbcache/'.$cachePath.$listID[$i];

			Cache::removeKey($tmpPath);
		}


	}
}
?>