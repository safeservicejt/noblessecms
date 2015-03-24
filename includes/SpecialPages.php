<?php

class SpecialPages
{

	public function exists($inputData=array())
	{



	}
	public function load($inputData=array())
	{

		if(!isset(Plugins::$zoneCaches['special_page']))
		{
			return false;
		}



		$total=count(Plugins::$zoneCaches['special_page']);

		for($i=0;$i<$total;$i++)
		{

			$thePage=Plugins::$zoneCaches['special_page'][$i];

			if((int)$thePage['status']==0)
			{
				continue;
			}

			$folderName=$thePage['foldername'];

			$funcName=$thePage['func'];

			$pageName=isset($thePage['layoutname'])?$thePage['layoutname']:$thePage['name'];

			$filePath=PLUGINS_PATH.$folderName.'/'.$folderName.'.php';

			if(!$matches=Uri::match($pageName))
			{
				continue;
			}

			if(!function_exists($funcName))
			{
				require($filePath);
			}

			$funcName();

			die();
		}

		return false;

	}


}

?>