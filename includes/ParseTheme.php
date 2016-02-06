<?php


/*




*/

class ParseTheme
{
	private static $data=array();

	function __construct()
	{
		$this->data['path']=System::getThemePath();

		$this->data['site_url']=System::getUrl();

		$this->data['theme_url']=System::getThemeUrl();

	}

	public function settingUri($inputData=array())
	{
		/*
		$this->settingUri(array(
		'/'=>'home@index',
		'post'=>'post@index'
		));

		*/

		$this->data['list_uri']=$inputData;
	}

	public function render()
	{
		$curUri=System::getUri();

		$controllerName='home';

		if(preg_match('/^\/?(\w+)/i', $curUri,$match))
		{
			
			$controllerName=$match[1];

			if(isset($this->data['list_uri'][$controllerName]))
			{
				
			}
		}

		$this->controller($controllerName);

		if(!isset($this->data['render_header']))
		{
			$codeHead=Plugins::load('site_header');

			$codeHead=is_array($codeHead)?'':$codeHead;

			$codeFooter=Plugins::load('site_footer');

			$codeFooter=is_array($codeFooter)?'':$codeFooter;

			// print_r($codeHead);die();

			System::defineGlobalVar('site_header',$codeHead);

			System::defineGlobalVar('site_footer',$codeFooter);	
					
			$this->data['render_header']='yes';
		}			
	}

	public function controller($viewName)
	{
		Controller::makeWithPath('theme'.ucfirst($viewName),'index',$this->data['path'].'controller');
	}

	public function model($viewName)
	{
		Model::makeWithPath($viewName,$this->data['path'].'model');
	}

	public function view($viewName,$inputData=array())
	{
		View::makeWithPath($viewName,$inputData,$this->data['path'].'view');
	}

}

?>