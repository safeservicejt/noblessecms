<?php

class Widgets
{
	/*
	$widgetData=array(
		'page'=>array(
			'top'=array(
				'function_name',
				'function_name',
				'function_name',
				'function_name',
				'function_name'
			)
		)

	);

	Widgets::build(function(){

		Widgets::add('category','right','lastpost',2);

		Widgets::add('category','right','hotpost',1);

		Widgets::add('category','left','oldpost',1);

		Widgets::add('category','left','viewspost',0);

	});



	*/
	public static $widgetData=array();

	public function show($page_name,$layout_name='top')
	{
		$result=self::make($page_name,$layout_name);

		echo $result;
	}

	public function make($page_name,$layout_name='top')
	{
		$themePath=System::getThemePath();

		$filePath=$themePath.'widgets.php';

		if(!isset(self::$widgetData[$page_name][$layout_name]) || !isset(self::$widgetData[$page_name][$layout_name][0][2]))
		{
			return null;
		}

		$total=count(self::$widgetData[$page_name][$layout_name]);

		// if(!function_exists(self::$widgetData[$page_name][$layout_name][0]))
		// {
		// 	include($filePath);
		// }		

		$result='';

		for ($i=0; $i < $total; $i++) { 
			$func=self::$widgetData[$page_name][$layout_name][$i];

			$result.=$func();
		}

		return $result;
	}

	public function load()
	{
		if(!$loadCache=self::loadCache())
		{
			$themePath=System::getThemePath();

			$filePath=$themePath.'widgets.php';

			if(file_exists($filePath))
			{
				include($filePath);
			}				
		}

		self::$widgetData=$loadCache;
	}

	public function get()
	{
		return self::$widgetData;
	}

	public function change($function_name,$inputData=array())
	{
		/*
		$inputData=array(
				'page_name'=>'post',
				'positon'=>'left',
				'sort_order'=>'2',

				'category'=>'post',
				'top'=>'left',
				'1'=>'2'
		);
		*/
		
		
		$themePath=System::getThemePath();

		$filePath=$themePath.'widgets.php';

		if(!function_exists($function_name))
		{
			include($filePath);
		}

		$keyNames=array_keys($inputData);

		$page_name=$keyNames[0];

		$positon=$keyNames[1];

		$sort_order=$keyNames[2];

		self::add($page_name,$positon,$function_name,$sort_order);

		self::saveCache();
		
	}

	public function build($func)
	{
		if(is_object($func))
		{
			$themePath=System::getThemePath();

			$func();

			self::saveCache();
		}

	}

	public function saveCache()
	{
		$themePath=System::getThemePath();

		$filePath=$themePath.'widgets.php';
	
		$fileHash=md5_file($filePath);

		if(!file_exists($themePath.$fileHash.'.cache'))
		{
			File::create($themePath.$fileHash.'.cache',serialize(self::$widgetData));
		}		
	}

	public function loadCache()
	{
		$themePath=System::getThemePath();

		$filePath=$themePath.'widgets.php';
	
		$fileHash=md5_file($filePath);

		if(!file_exists($themePath.$fileHash.'.cache'))
		{
			return false;
		}

		$loadCache=file_get_contents($themePath.$fileHash.'.cache');

		$loadCache=unserialize($loadCache);

		return $loadCache;

	}

	public function addByText($inputData='')
	{
		/*
		page_name|layout_name|order
		page_name|layout_name|order
		*/

		$inputData=trim($inputData);

		$parse=explode("\r\n", $inputData);

		$total=count($parse);

		for ($i=0; $i < $total; $i++) { 

			$theCMD=trim($parse[$i]);

			$parseCMS=explode("|", $theCMD);

			if(!isset($parseCMS[1]))
			{
				continue;
			}

			$sortOrder=isset($parseCMS[2])?$parseCMS[2]:0;

			self::add($parseCMS[0],$parseCMS[1],$sortOrder);

		}

	}


	public function add($pageName,$pageLayout='top',$funcName,$sortOrder=0)
	{
		$sortOrder=(int)$sortOrder;

		$layoutNames=array('top','left','right','bottom');

		if(!in_array($pageLayout, $layoutNames))
		{
			return false;
		}

		if(!isset(self::$widgetData[$pageName][$pageLayout]))
		{
			self::$widgetData[$pageName][$pageLayout][$sortOrder]=$funcName;
		}
		else
		{
			$total=count(self::$widgetData[$pageName][$pageLayout]);


			if($total==0)
			{
				self::$widgetData[$pageName][$pageLayout][$sortOrder]=$funcName;
			}
			else
			{
				if(!isset(self::$widgetData[$pageName][$pageLayout][$sortOrder]))
				{
					self::$widgetData[$pageName][$pageLayout][$sortOrder]=$funcName;
				}
				else
				{
					$nextOrder=(int)$sortOrder+1;

					if(!isset(self::$widgetData[$pageName][$pageLayout][$nextOrder]))
					{
						self::$widgetData[$pageName][$pageLayout][$nextOrder]=$funcName;
					}
					else
					{
						$total=count(self::$widgetData[$pageName][$pageLayout]);

						$left=array_slice(self::$widgetData[$pageName][$pageLayout], 0, $sortOrder);

						$right=array_slice(self::$widgetData[$pageName][$pageLayout], $sortOrder, $total);

						array_push($left, $funcName);

						self::$widgetData[$pageName][$pageLayout]=array_merge($left,$right);
					}
				}
			}

			ksort(self::$widgetData[$pageName][$pageLayout]);

		}

		return true;

	}
}

?>