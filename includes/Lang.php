<?php

class Lang
{
	/*
	Lang::setPath(ROOT_PATH.'contents/plugins/fastecommerce/lang/');

	Lang::set('en');

	$text=Lang::get('admincp/login.title');
	
	$text=Lang::get('admincp/index');

	echo Lang::get('home.homepage@topNotify');
	
	*/
	private static $lang=array();

	public static $data=array();

	private static $totalRow=0;

    public static $loadPath = '';

    
    public static function setPath($path)
    {
        $path=!isset($path[2])?LANG_PATH:$path;

        self::$loadPath=$path;
    }

    public static function resetPath()
    {
        self::$loadPath=LANG_PATH;
    }
    
    public static function getPath()
    {
        $path=!isset(self::$loadPath[2])?LANG_PATH:self::$loadPath;

        self::$loadPath=$path;

        return $path;
    }

    public static function getWithPath($keyName,$path)
    {
    	// self::setPath($path);

    	$result=self::get($keyName,array(),$path);

    	// self::resetPath();

    	return $result;
    }

    public static function set($lang)
    {
    	// App::setLocale($lang);
    }

	public static function get($keyName,$addOns=array(),$newPath='')
	{
		if(!isset($keyName[1]))
		{
			return false;
		}

		$dirName='en';

		$fileName='';

		$fieldName='';

		$childName='';

		$langPath=isset($newPath[5])?$newPath:self::getPath();

		$langPath=$langPath.$dirName.'/';


		$loadData=self::parseName($keyName);

		$fileName=$loadData['fileName'];

		$fieldName=$loadData['fieldName'];

		if(isset($loadData['childName']))
		{
			$childName=$loadData['childName'];
		}

		if(!isset(self::$data[$fileName]))
		{
			$langPath=$langPath.$fileName.'.php';

			if(!file_exists($langPath))
			{
				Log::warning('Language '.ucfirst($fileName).' not exists in system.');

				return false;
			}

			include($langPath);	

			// if(!isset($lang))
			// {
			// 	// Alert::make('The language '.ucfirst($lang).' not exists inside system.');
			
			// 	Log::warning('The language '.$fileName.' not exists inside system.');

			// 	return false;			
			// }		

			if(isset($fieldName[1]) && !isset($lang[$fieldName]))
			{
				// Alert::make('The field '.ucfirst($fieldName).' not exists inside language '.ucfirst($fileName));

				Log::warning('The field '.ucfirst($fieldName).' not exists inside language '.ucfirst($fileName));

				return false;			
			}		

			self::$data[$fileName]=$lang;		
		}
		else
		{
			$lang=self::$data[$fileName];
		}

		self::$totalRow=count($lang);

		if($fieldName=='')
		{
			return $lang;
		}

		$totalAddons=count($addOns);

		if($totalAddons > 0 && !is_array($lang[$fieldName]))
		{
			$keyNames=array_keys($addOns);

			for($i=0;$i<$totalAddons;$i++)
			{
				// $keyName=$keyNames[$i];

				$keyNames[$i]=':'.$keyNames[$i];

				// $lang[$keyName]=$addOns[$keyName];
			}

			$lang[$fieldName]=str_replace(array_keys($addOns), array_values($addOns), $lang[$fieldName]);
		}

		$theText=isset($childName[1])?$lang[$fieldName][$childName]:$lang[$fieldName];

		return $theText;

	}


	public static function has($keyName)
	{
		$dirName='en';

		$fileName='';

		$fieldName='';

		$langPath=LANG_PATH.$dirName.'/';

		if((int)self::$totalRow == 0)
		{


			$loadData=self::parseName($keyName);

			$fileName=$loadData['fileName'];

			$fieldName=$loadData['fieldName'];

			$langPath.=$fileName.'.php';

			if(!file_exists($langPath))
			{	
				return false;
			}
		
			include($langPath);	

			if(!isset($lang))
			{
				return false;
			}

			self::$lang=$lang;

			self::$totalRow=count($lang);
		}

		if(!isset(self::$lang[$fieldName]))
		{
			return false;
		}	

		return true;
	}

	public static function choice($keyName,$theLine=0)
	{
		$loadData='';

		if(self::has($keyName))
		{
			$loadData= self::get($keyName);

			if(is_array($loadData) || !preg_match('/\|/i', $loadData))
			{
				return false;
			}

			$parse=explode('|', $loadData);

			if(!isset($parse[$theLine]))
			{
				return false;
			}

			return $parse[$theLine];
		}

		return false;
	}

	public static function parseName($keyName)
	{
		$resultData=array();

		$fileName='';

		$fieldName='';

		$childName='';

		if(!preg_match('/(.*?)\.(\w+)/i', $keyName,$matches))
		{
			$fileName=$keyName;

			$fieldName='';

		}
		else
		{
			if(preg_match('/(\w+)\@(\w+)/i', $keyName,$matchChild))
			{
				$childName=$matchChild[2];
			}

			$fileName=$matches[1];

			$fieldName=$matches[2];			
		}

		$resultData['fileName']=$fileName;

		$resultData['fieldName']=$fieldName;	

		$resultData['childName']=$childName;			

		return $resultData;

	}
}