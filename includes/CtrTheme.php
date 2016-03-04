<?php


/*

CtrTheme::settingUri(array(
'/'=>'home@index',
'post'=>'post@index'
));

CtrTheme::render();

*/

class CtrTheme
{
	private static $data=array();

	public function settingUri($inputData=array())
	{
		self::$data['path']=THEME_CP_PATH;

		self::$data['list_uri']=$inputData;

		self::$data['controller']='home';

		if(preg_match('/\/privatesetting\/(\w+)/i', System::getUri(),$match))
		{
			self::$data['theme']=$match[1];
		}
		else
		{
			Alert::make('Data not valid.');
		}

		if(preg_match('/\/privatesetting\/(\w+)\/(\w+)/i', System::getUri(),$match))
		{
			self::$data['theme']=$match[1];
			self::$data['controller']=$match[2];
		}

	}

	public static function url($controllerName,$funcName='index',$pluginName='')
	{
		$pluginName=isset(self::$data['theme'])?self::$data['theme']:$pluginName;

		$url=System::getUrl().'admincp/theme/privatesetting/'.$pluginName.'/'.$controllerName.'/'.$funcName;

		return $url;
	}


	public static function render()
	{
		$curUri=System::getUri();

		$controllerName='home';

		$funcName='index';

		// 'baiviet'=>'post@index'
		if(preg_match('/privatesetting\/'.self::$data['theme'].'\/(\w+)/i', $curUri,$match))
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

					$funcName=isset($matchName[1][1])?$matchName[1][1]:$funcName;
				}
			}


			if(preg_match('/privatesetting\/'.self::$data['theme'].'\/(\w+)\/(\w+)/i', $curUri,$matchFunc))
			{
				$funcName=$matchFunc[2];
			}			
		}

		if($controllerName=='')
		{
			Alert::make('We not allow run null controller');
		}

		self::controller($controllerName,$funcName);

		
	}

	public static function controller($viewName,$funcName='index')
	{
		Model::loadWithPath($viewName,self::$data['path'].'model/');

		Controller::loadWithPath('control'.ucfirst($viewName),$funcName,self::$data['path'].'controller/');
	}

	public static function model($viewName)
	{
		Model::loadWithPath($viewName,self::$data['path'].'model/');
	}

	public static function view($viewName,$inputData=array())
	{
		View::makeWithPath($viewName,$inputData,self::$data['path'].'view/');
	}

	public static function admincpHeader($inputData=array())
	{
		View::make('admincp/head',$inputData=array());
	}

	public static function admincpFooter($inputData=array())
	{
		View::make('admincp/footer',$inputData=array());
	}

	public static function admincpLeft($inputData=array())
	{
		View::make('admincp/left',$inputData=array());
	}

}

?>