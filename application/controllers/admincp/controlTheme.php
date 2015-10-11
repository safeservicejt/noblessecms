<?php

class controlTheme
{
	public function index()
	{
      
		$post=array('alert'=>'');

		Model::load('admincp/theme');

		if($match=Uri::match('\/theme\/(\w+)'))
		{
			if(method_exists("controlTheme", $match[1]))
			{	
				$method=$match[1];

				$this->$method();

				die();
			}
			
		}

		if($match=Uri::match('\/activate\/(\w+)'))
		{
			$theName=$match[1];

			try {
				
				Theme::setActivate($theName);

				$post['alert']='<div class="alert alert-success">Change theme success</div>';

				Redirect::to(System::getAdminUrl().'theme');

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['listThemes']=Theme::get();

		$post['theme']=Theme::getDefault();

		System::setTitle('Theme list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('themeList',$post);

		View::make('admincp/footer');

	}


	public function edit()
	{
		if(!$match=Uri::match('\/edit\/(\w+)'))
		{
			Redirect::to(System::getAdminUrl());
		}

		$themeName=$match[1];

      	if(!Domain::isAllowTheme($themeName))
      	{
      		Alert::make('You dont have permission to access this page.');
      	}


		$thePath=THEMES_PATH.$themeName.'/';

		if(!is_dir($thePath))
		{
			Redirect::to(System::getAdminUrl());
		}

		$subPath=Request::get('path','');

		if(preg_match('/\.\./i', $subPath))
		{
			// Alert::make('You can not do this action.');

			$subPath=dirname($subPath);
		}

		$thePath.=$subPath;

		$queryPath=$thePath;

		$pageData=array();

		if(preg_match('/.*?\.\w+/i', $subPath))
		{
			if(!preg_match('/(\w+)\/\w+\.\w+/i', $subPath,$match))
			{
				$subPath=dirname($subPath);
			}
			else
			{
				$subPath=$match[1];
			}
			

			$pageData['file']['name']=basename($queryPath);

			$pageData['file']['data']=file_get_contents($queryPath);

			$queryPath=dirname($queryPath);

			if(Request::has('btnSave'))
			{
				$savePath=$queryPath.'/'.$pageData['file']['name'];

				$saveData=trim(Request::get('send.file_content',''));

				File::create($savePath,$saveData);

				$pageData['file']['data']=file_get_contents($savePath);
			}
		}		

		$listFiles=Dir::all($queryPath);

		if(isset($listFiles[0])=='.')
		{
			unset($listFiles[0]);
		}
		if(isset($listFiles[1])=='..')
		{
			unset($listFiles[1]);
		}

		sort($listFiles);


		$pageData['listFiles']=$listFiles;

		$pageData['themeName']=$themeName;

		$pageData['themePath']=THEMES_PATH.$themeName.'/';

		$pageData['thisPath']=$queryPath;	

		$pageData['subPath']=$subPath.'/';



		// print_r($pageData['listFiles']);die();

		System::setTitle('Edit theme '.$themeName.' - '.ADMINCP_TITLE);

		View::make('admincp/head',array());

		self::makeContents('themeEdit',$pageData);

		View::make('admincp/footer');

	}
	
	public function setting()
	{

		if(!$match=Uri::match('\/setting\/(\w+)'))
		{
			Redirect::to(System::getAdminUrl());
		}

		if($matchCtr=Uri::match('\/setting\/(\w+)\/controller\/(\w+)'))
		{
			$this->controller();

			die();
		}

		$theName=$match[1];

      	if(!Domain::isAllowTheme($themeName))
      	{
      		Alert::make('You dont have permission to access this page.');
      	}

		$post['title']=ucfirst($theName);

		$thePath=THEMES_PATH.$theName.'/';

		if(!is_dir($thePath))
		{
			Redirect::to(System::getAdminUrl());
		}

		$info=$thePath.'setting.php';

		if(!file_exists($info))
		{
			Redirect::to(System::getAdminUrl());
		}

		$post['filePath']=$info;

		System::setTitle('Setting theme '.$theName.' - '.ADMINCP_TITLE);

		View::make('admincp/head',array());

		self::makeContents('themeSetting',$post);

		View::make('admincp/footer');		
	}

	public function controller()
	{
		$post=array();

		if($matchCtr=Uri::match('\/setting\/(\w+)\/controller\/(\w+)'))
		{
			$controllerName=$matchCtr[2];

			$themeName=$matchCtr[1];

	      	if(!Domain::isAllowTheme($themeName))
	      	{
	      		Alert::make('You dont have permission to access this page.');
	      	}

			$path=THEMES_PATH.$themeName.'/cp/controller/control'.ucfirst($controllerName).'.php';

			if(!file_exists($path))
			{
				Alert::make('Controller <b>'.$controllerName.'</b> of theme '.$themeName.' not found.');
			}

			define("THEME_CP_PATH", THEMES_PATH.$themeName.'cp/');

			$post['file']=$path;

			$post['themename']=$themeName;

			View::make('admincp/head',array('title'=>'Setting theme '.$themeName.' - '.ADMINCP_TITLE));

			self::makeContents('themeControl',$post);

			View::make('admincp/footer');				
		}		
	}

	public function import()
	{
      	if(Domain::isOtherDomain())
      	{
      		Alert::make('You dont have permission to access this page.');
      	}
		
		$post=array('alert'=>'');

		if(Request::has('btnSend'))
		{
			try {
				
				importProcess();

				$post['alert']='<div class="alert alert-success">Import theme success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}		
		}

		View::make('admincp/head',array('title'=>'Import theme - '.ADMINCP_TITLE));

		self::makeContents('themeImport',$post);

		View::make('admincp/footer');		
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>