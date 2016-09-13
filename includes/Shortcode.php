<?php

class Shortcode
{
	public static $listShortCodes=array();

	public static $canFlyAdd='yes';

	public static function load()
	{
		self::$canFlyAdd='yes';

		$savePath=ROOT_PATH.'caches/shortcodes.cache';

		if(file_exists($savePath))
		{
			$loadData=unserialize(file_get_contents($savePath));

			if(is_array($loadData))
			{
				self::$listShortCodes=$loadData;
			}
		}

		$listFiles=Dir::listFiles(ROOT_PATH.'includes/shortcodes/');

		$total=count($listFiles);

		$loadPath=ROOT_PATH.'includes/shortcodes/';

		for ($i=0; $i < $total; $i++) { 

			$filePath=$loadPath.$listFiles[$i];

			if(preg_match('/\.php/i', $filePath))
			{
				include($filePath);
			}
			
		}
	}

	public static function render($inputData='')
	{
		if($inputData=='')
		{
			return $inputData;
		}

		self::$canFlyAdd='no';

		$total=count(self::$listShortCodes);

		if($total > 0)
		{
			$resultSC='';

			$resultData='';

			$replaces=array();

			for ($i=0; $i < $total; $i++) { 

				$resultSC='';

				$resultData='';

				$replaces=array();

				if(!isset(self::$listShortCodes[$i]['funcname']))
				{
					continue;
				}

				$theSC=self::$listShortCodes[$i];

				$filePath=$theSC['path'];

				if(!file_exists($filePath))
				{
					continue;
				}

				if(!function_exists($theSC['funcname']))
				{
					include($filePath);
				}

				$resultSC=self::parseProcess($scName,$inputData);

				$totalResult=count($resultSC);
				
				$replaces=array();

				for($e=0;$e<$totalResult;$e++)
				{
					$resultData=$func($resultSC[$e]);

					$replaces[$resultSC[$e]['real']]=$resultData;
					
					$resultData='';
				}

				
				$inputData=str_replace(array_keys($replaces), array_values($replaces), $inputData);

			}
		}

		return $inputData;
	}

	public static function add($inputData=array())
	{
		if(!isset($inputData['funcname']) || !isset($inputData['name']))
		{
			return false;
		}

		$savePath=ROOT_PATH.'caches/shortcodes.cache';

		$data=debug_backtrace();

		$dirPath=dirname($data[0]['file']).'/';

		$foldername=basename($dirPath);

		$filePath=$dirPath.'shortcodes.php';

		$inputData['path']=isset($inputData['path'][5])?$inputData['path']:$filePath;

		$inputData['foldername']=$foldername;

		$loadData=array();

		if(file_exists($savePath))
		{
			$loadData=unserialize(file_get_contents($savePath));
		}
		
		$loadData[]=$inputData;

		File::create($savePath,serialize($loadData));
		
	}

	public static function flyAdd($inputData=array())
	{
		if(self::$canFlyAdd!='yes' || !isset($inputData['funcname']) || !isset($inputData['name']))
		{
			return false;
		}

		$data=debug_backtrace();

		$dirPath=dirname($data[0]['file']).'/';

		$foldername=basename($dirPath);

		// $filePath=$dirPath.'shortcodes.php';

		$inputData['path']=$data[0]['file'];

		$inputData['foldername']=$foldername;	

		self::$listShortCodes[]=$inputData;	
	}

	public static function removeByFolderName($foldername)
	{
		$savePath=ROOT_PATH.'caches/shortcodes.cache';

		if(file_exists($savePath))
		{
			$loadData=unserialize(file_get_contents($savePath));

			$total=count($loadData);

			for ($i=0; $i < $total; $i++) { 

				if(!isset($loadData[$i]['foldername']))
				{
					continue;
				}

				if($loadData[$i]['foldername']==$foldername)
				{
					unset($loadData[$i]);
				}
			}

			sort($loadData);

			File::create($savePath,serialize($loadData));
		}
	}

	public static function removeByName($scName)
	{
		$savePath=ROOT_PATH.'caches/shortcodes.cache';

		if(file_exists($savePath))
		{
			$loadData=unserialize(file_get_contents($savePath));

			$total=count($loadData);

			for ($i=0; $i < $total; $i++) { 

				if(!isset($loadData[$i]['name']))
				{
					continue;
				}

				if($loadData[$i]['name']==$scName)
				{
					unset($loadData[$i]);
				}
			}

			sort($loadData);

			File::create($savePath,serialize($loadData));
		}
	}


	public static function strip($text='')
	{
		$replaces=array(
			'/\[\w+.*?\].*?\[\/\w+\]/i'=>'',
			'/\[\w+.*?\/\]/i'=>'',
			'/\[\w+.*?\]/i'=>''
			);
		$text=preg_replace(array_keys($replaces), array_values($replaces), $text);		

		return $text;
	}


	public static function parseProcess($scName='',$inputData='')
	{
		$result=array();
		// Check if it is openclose
		if(!preg_match_all('/(\['.$scName.'(.*?)\](.*?)\[\/'.$scName.'\])/is', $inputData,$match))
		{
			// Alone parse process
			if(preg_match_all('/(\['.$scName.'(.*?)\])/i', $inputData,$match))
			{
				$listReal=$match[1];

				$listAttr=$match[2];	
				
				$total=count($listReal);

				for ($i=0; $i < $total; $i++) { 

					$result[$i]['real']=$listReal[$i];

					$result[$i]['attr']=array();

					$attr=$listAttr[$i];

					if(isset($attr[1]))
					{
						// die($attr);
						if(preg_match_all('/(\w+)\=(\'|\"|)(.*?)(\'|\"|)/i', $attr, $matchAttrs))
						{

							$totalAttr=count($matchAttrs[1]);

							for ($j=0; $j < $totalAttr; $j++) { 
								$theKey=$matchAttrs[1][$j];

								$result[$i]['attr'][$theKey]=$matchAttrs[3][$j];
							}
						}
					}

				}							
			}
		}	
		else
		{
			// Openclose parse process

			$listReal=$match[1];

			$listAttr=$match[2];

			$listVal=$match[3];

			$total=count($listReal);

			// print_r($match);die();

			for ($i=0; $i < $total; $i++) { 

				$result[$i]['real']=$listReal[$i];

				$result[$i]['value']=trim($listVal[$i]);

				$result[$i]['attr']=array();

				$attr=$listAttr[$i];

				if(isset($attr[1]))
				{
					// die($attr);
					if(preg_match_all('/(\w+)\=(\'|\"|)(.*?)(\'|\"|)/i', $attr, $matchAttrs))
					{

						$totalAttr=count($matchAttrs[1]);

						for ($j=0; $j < $totalAttr; $j++) { 
							$theKey=$matchAttrs[1][$j];

							$result[$i]['attr'][$theKey]=$matchAttrs[3][$j];
						}
					}
				}

			}

		}

		return $result;
	}



}