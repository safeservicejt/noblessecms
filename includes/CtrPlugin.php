<?php


/*

CtrPlugin::settingUri(array(
'/'=>'home@index',
'post'=>'post@index'
));

CtrPlugin::render();

*/

class CtrPlugin
{
	private static $data=array();

	public function settingUri($inputData=array())
	{
		self::$data['path']=THIS_PATH;

		self::$data['list_uri']=$inputData;


		if(preg_match('/\/privatecontroller\/(\w+)\/(\w+)/i', System::getUri(),$match))
		{
			self::$data['plugin']=$match[1];
			self::$data['controller']=$match[2];

		}
		else
		{
			Alert::make('Data not valid.');
		}
	}

	public static function url($controllerName,$funcName='index',$pluginName='')
	{
		$pluginName=isset(self::$data['plugin'])?self::$data['plugin']:$pluginName;

		$url=System::getUrl().'admincp/plugins/privatecontroller/'.$controllerName.'/'.$funcName;

		return $url;
	}


	public static function render()
	{
		$curUri=System::getUri();

		$controllerName='';

		$funcName='index';

		// 'baiviet'=>'post@index'
		if(preg_match('/privatecontroller\/'.self::$data['plugin'].'\/(\w+)/i', $curUri,$match))
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

			if(preg_match('/privatecontroller\/'.self::$data['plugin'].'\/(\w+)\/(\w+)/i', $curUri,$matchFunc))
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
		View::makeWithPath($viewName,$inputData,self::$data['path'].'views/');
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