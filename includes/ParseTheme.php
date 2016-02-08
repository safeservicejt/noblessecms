<?php


/*




*/

class ParseTheme
{
	private static $data=array();

	public function settingUri($inputData=array())
	{
		self::$data['path']=System::getThemePath();

		self::$data['site_url']=System::getUrl();

		self::$data['theme_url']=System::getThemeUrl();

		/*
		self::$settingUri(array(
		'/'=>'home@index',
		'post'=>'post@index'
		));

		*/

		self::$data['list_uri']=$inputData;
	}

	public static function render()
	{
		$curUri=System::getUri();

		$controllerName='home';

		$funcName='index';

		// 'baiviet'=>'post@index'
		if(preg_match('/^\/?(\w+)/i', $curUri,$match))
		{
			$pageName=$match[1];

			if(!isset(self::$data['list_uri'][$pageName]))
			{
				$controllerName=$pageName;
			}
			else
			{
				$cName=trim(self::$data['list_uri'][$pageName]);
				if(preg_match_all('/(\w+)/i', $cName,$matchName))
				{
					$controllerName=$matchName[1][0];

					$funcName=isset($matchName[1][1])?$matchName[1][1]:'index';
				}
			}
		}

		self::controller($controllerName,$funcName);

		
	}

	public static function controller($viewName,$funcName='index')
	{
		Model::loadWithPath($viewName,self::$data['path'].'model/');

		Controller::loadWithPath('theme'.ucfirst($viewName),$funcName,self::$data['path'].'controller/');
	}

	public static function model($viewName)
	{
		Model::loadWithPath($viewName,self::$data['path'].'model/');
	}

	public static function view($viewName,$inputData=array())
	{
		if(!isset(self::$data['render_header']))
		{
			$codeHead=Plugins::load('site_header');

			$codeHead=is_array($codeHead)?'':$codeHead;

			$codeFooter=Plugins::load('site_footer');

			$codeFooter=is_array($codeFooter)?'':$codeFooter;

			System::defineGlobalVar('site_header',$codeHead);

			System::defineGlobalVar('site_footer',$codeFooter);	
					
			self::$data['render_header']='yes';
		}	

		View::makeWithPath($viewName,$inputData,self::$data['path'].'view/');
	}

}

?>