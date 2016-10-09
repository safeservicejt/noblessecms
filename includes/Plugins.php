<?php

/*
	Folder struct:

	- Testplugin:

		+ install.php

		+ uninstall.php

		+ hooks.php

		+ update.php

		+ info.txt
	
	- Folders:

		+ install

		+ controllers

		+ models

		+ views


Plugins::add('before_system_start',array(
	'type'=>'fly',
	'funcname'=>'ac',
	'classname'=>'Pages',
	));
*/

class Plugins
{
	public static $listPlugins=array();

	public static $foldername='';

	public static function get($inputData=array())
	{
		Table::setTable('plugins');

		Table::setFields('id,title,foldername,status');

		$result=Table::get($inputData);

		return $result;
	}

	public static function url($controlName='',$funcName='index')
	{
		$pluginName='';

		if(!$match=Uri::match('plugins\/controller\/(\w+)'))
		{	
			return $pluginName;
		}

		$pluginName=$match[1];

		$url=System::getUrl().'npanel/plugins/controller/'.$pluginName.'/'.$controlName.'/'.$funcName.'/';

		return $url;
	}

	public static function activate($foldername)
	{
		self::update(0,array(
			'status'=>1
			),"foldername='$foldername'");

		PluginMetas::update(0,array(
			'status'=>1
			)," foldername='$foldername'");

		self::saveCacheAll();

		PluginMetas::saveCacheAll();
	}

	public static function deactivate($foldername)
	{
		self::update(0,array(
			'status'=>0
			),"foldername='$foldername'");

		PluginMetas::update(0,array(
			'status'=>0
			),"foldername='$foldername'");

		self::saveCacheAll();		

		PluginMetas::saveCacheAll();
	}

	public static function getDirs($inputData=array())
	{

		$loadData=self::get(array(
			'cache'=>'no'
			));

		$total=count($loadData);

		$dbPlugins=array();

		if(isset($loadData[0]['foldername']))
		for ($i=0; $i < $total; $i++) { 

			$foldername=$loadData[$i]['foldername'];

			$dbPlugins[$foldername]['status']=$loadData[$i]['status'];
			$dbPlugins[$foldername]['installed']=$dbPlugins[$foldername]['status'];

		}

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:1000;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$listDir=Dir::listDir(PLUGINS_PATH);

		$total=count($listDir);

		$resultData=array();

		for($i=$limitPage;$i<$limitShow;$i++)
		{
			if(!isset($listDir[$i]))
			{
				continue;
			}

			$folderName=$listDir[$i];

			$isSetting=0;
			
			$path=PLUGINS_PATH.$folderName.'/';
			$url=PLUGINS_URL.$folderName.'/';
			
			if(!file_exists($path.'info.txt'))
			{
				continue;
			}

			$pluginInfo=file($path.'info.txt');


			if(file_exists($path.'disallow.txt'))
			{
				continue;
			}

			if(file_exists($path.'setting.php'))
			{
				$isSetting=1;
			}

			$resultData[$i]['title']=$pluginInfo[0];
			$resultData[$i]['author']=$pluginInfo[1];
			$resultData[$i]['version']=$pluginInfo[2];
			$resultData[$i]['summary']=isset($pluginInfo[3])?$pluginInfo[3]:'';
			$resultData[$i]['url']=isset($pluginInfo[4])?$pluginInfo[4]:'';
			$resultData[$i]['foldername']=$folderName;
			$resultData[$i]['status']=isset($dbPlugins[$folderName])?$dbPlugins[$folderName]['status']:'0';
			$resultData[$i]['install']=isset($dbPlugins[$folderName])?1:'0';
			$resultData[$i]['setting']=$isSetting;
					

		}
		
		return $resultData;
		
	}
	public static function load($zonename,$inputData=array())
	{
		if(!isset(PluginMetas::$listZone[$zonename]))
		{
			PluginMetas::loadCacheAll();

			if(!isset(PluginMetas::$listZone[$zonename]))
			{
				return false;
			}
		}

		$theZone=PluginMetas::$listZone[$zonename];

		$total=count($theZone);

		for ($i=0; $i < $total; $i++) { 
			if(!isset($theZone[$i]['id']))
			{
				continue;
			}

			$theHook=$theZone[$i];

			$filePath=ROOT_PATH.$theHook['filepath'];

			$callFunc=$theHook['funcname'];

			$callClass=$theHook['classname'];

			switch ($theHook['type']) {

				case 'function':

					if(!function_exists($callFunc) && file_exists($filePath))
					{
						include($filePath);
					}

					$callFunc();

					break;

				case 'class':

					if(!class_exists($callClass) && file_exists($filePath))
					{
						include($filePath);
					}

					$callClass::$callFunc();

					break;

				case 'fly':

					if(class_exists($callClass))
					{
						$callClass::$callFunc();	
					}
									
					break;
			}
		}
	}


	public static function install($foldername)
	{
		self::$foldername=$foldername;

		$folderPath=ROOT_PATH.'contents/plugins/'.$foldername.'/';

		$filePath.=$folderPath.'install.php';

		$loadData=self::get(array(
			'cache'=>'no',
			'where'=>"where foldername='$foldername'"
			));

		if(isset($loadData[0]['foldername']))
		{
			throw new Exception('This plugin have been installed.');			
		}

		$pluginInfo=file($folderPath.'info.txt');

		self::insert(array(
			'title'=>$pluginInfo[0],
			'foldername'=>$foldername
			));

		if(file_exists($filePath))
		{
			include($filePath);
		}

		self::saveCacheAll();

		PluginMetas::saveCacheAll();
	}

	public static function uninstall($foldername)
	{
		self::$foldername=$foldername;

		$folderPath=ROOT_PATH.'contents/plugins/'.$foldername.'/';

		$filePath.=$folderPath.'uninstall.php';

		$pluginInfo=file($folderPath.'info.txt');

		self::remove(0," foldername='$foldername'");

		PluginMetas::remove(0," foldername='$foldername'");

		if(file_exists($filePath))
		{
			include($filePath);
		}

		self::saveCacheAll();

		PluginMetas::saveCacheAll();		
	}

	public static function add($zonename='',$inputData=array())
	{
		$foldername=self::$foldername;

		if(!isset($zonename[2]))
		{
			throw new Exception('Data for add zone not valid.');
			
		}

		$folderPath='contents/plugins/'.$foldername.'/';

		$filePath=$folderPath.'hooks.php';

		$inputData['zonename']=$zonename;

		$inputData['foldername']=!isset($inputData['foldername'])?$foldername:$inputData['foldername'];

		$inputData['funcname']=isset($inputData['funcname'])?$inputData['funcname']:'index';

		$inputData['filepath']=isset($inputData['filepath'])?$inputData['filepath']:$filePath;

		PluginMetas::insert($inputData);		
	}

	public static function insert($inputData=array(),$beforeInsert='',$afterInsert='')
	{
		Table::setTable('plugins');

		$result=Table::insert($inputData,$beforeInsert,$afterInsert);

		return $result;
	}

	public static function update($listID,$updateData=array(),$beforeUpdate='')
	{
		Table::setTable('plugins');

		$result=Table::update($listID,$updateData,$beforeUpdate);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('plugins');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}


	public static function loadCache($id)
	{
		$savePath=ROOT_PATH.'caches/system/plugins/'.$id.'.cache';

		if(!file_exists($savePath))
		{
			self::saveCache($id);

			if(!file_exists($savePath))
			{
				return false;
			}			
		}

		$loadData=unserialize(file_get_contents($savePath));

		return $loadData;

	}
	
	public static function loadCacheAll()
	{
		$savePath=ROOT_PATH.'caches/system/pluginList.cache';

		if(!file_exists($savePath))
		{
			self::saveCacheAll();

			if(!file_exists($savePath))
			{
				return false;
			}			
		}

		$loadData=unserialize(file_get_contents($savePath));

		return $loadData;

	}

	public static function saveCache($id,$inputData=array())
	{
		if((int)$id==0)
		{
			return false;
		}

		$savePath=ROOT_PATH.'caches/system/plugins/'.$id.'.cache';

		$loadData=array();

		$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where id='$id'"
				));	

		if(isset($loadData[0]['id']))
		{
			File::create($savePath,serialize($loadData[0]));
		}
		
	}
	
	public static function saveCacheAll()
	{

		$savePath=ROOT_PATH.'caches/system/pluginList.cache';

		$loadData=array();

		$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where status='1'"
				));	

		if(!isset($loadData[0]['id']))
		{
			$loadData=array();
		}

		File::create($savePath,serialize($loadData));
		
	}

}