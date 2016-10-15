<?php

class Views
{
	public static function return($viewName='',$viewData=array())
	{
		$result=self::make($viewName,$viewData,false,'',true);

		return $result;
	}

	public static function make($viewName='',$viewData=array(),$isTemplate=false,$customPath='',$isReturn=false)
	{
        if (preg_match('/\./i', $viewName)) {
            $viewName = str_replace('.', '/', $viewName);
        }

		$mvcPath='';

		if(!isset($customPath[5]))
		{
			$data=debug_backtrace();  

			$mvcPath=dirname(dirname($data[0]['file'])).'/';

		}
		else
		{
			// $customPath=application/npanel/

			$fullPath=ROOT_PATH.$customPath;

			if(!preg_match('/^.*?\/$/i', $fullPath))
			{
				$fullPath.='/';
			}

			if(!is_dir($fullPath.'controllers/'))
			{
				Alert::make('Controllers dir not exist in'.$fullPath);
			}

			$mvcPath=$fullPath;

		}

		$viewPath=$mvcPath.'views/';

		$filePath=$viewPath.$viewName.'.php';

		if(!is_dir($viewPath))
		{
			Alert::make('View '.$viewName.' not exists in '.$viewPath);
		}

		if(!file_exists($filePath))
		{
			Alert::make('File not exists in '.$filePath);
		}	

		if($isTemplate!=false)
		{
			$newPath=self::parseTemplate($viewPath);

			if($newPath!=false)
			{
				$viewPath=$newPath;
			}
		}
	
        extract(System::$listVar['global']);

        if(isset(System::$listVar[$viewName]))
        {
           extract(System::$listVar[$viewName]); 
        }

        $result='';

		extract($viewData);

		if($isReturn==false)
		{
			include($filePath);	
		}
		else
		{
			$result=include($filePath);
		}
	}

	public static function parseTemplate($filePath='')
	{
		$result=false;

		$savePath=ROOT_PATH.'caches/parseview/'.md5($filePath).'.php';

		$loadData=file_get_contents($filePath);

		// Shortcode parse

		// Template parse

		File::create($savePath,$loadData);

		return $savePath;
	}

	public static function nPanelHeader($viewData=array(),$isTemplate=false)
	{
		self::make('head',$viewData,$isTemplate,'application/npanel/');
		
		self::make('left',$viewData,$isTemplate,'application/npanel/');
	}
	
	
	public static function nPanelFooter($viewData=array(),$isTemplate=false)
	{
		self::make('footer',$viewData,$isTemplate,'application/npanel/');
	}

}