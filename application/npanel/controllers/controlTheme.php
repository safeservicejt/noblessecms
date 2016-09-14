<?php

class controlTheme
{
	public static function index()
	{
		$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_manage_themes');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}		

		$pageData=array('alert'=>'');
		
		if($match=Uri::match('\/activate\/(\w+)'))
		{
			$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_activate_theme');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}

			$theName=$match[1];

			try {
				
				Theme::setActivate($theName);

				$pageData['alert']='<div class="alert alert-success">Change theme success</div>';

				Redirect::to(System::getAdminUrl().'theme');

			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$pageData['listThemes']=Theme::get();

		$pageData['theme']=Theme::getDefault();

		System::setTitle('Theme list - nPanel');
		
		Views::make('head');

		Views::make('left');

		Views::make('themeList',$pageData);

		Views::make('footer');		
	}	

	public static function edit()
	{
		if(!$match=Uri::match('\/edit\/(\w+)'))
		{
			Redirect::to(System::getAdminUrl());
		}

		$themeName=$match[1];


		$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_edit_theme');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
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

				File::create($savePath,stripslashes(htmlspecialchars_decode($saveData)));

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

		System::setTitle('Edit theme '.$themeName.' - nPanel');
	
		Views::make('head');

		Views::make('left');

		Views::make('themeEdit',$pageData);

		Views::make('footer');

	}

	public static function activate()
	{
		if(!$match=Uri::match('\/activate\/(\w+)'))
		{
			Redirects::to(System::getUrl().'npanel/theme');
		}

		$themeName=$match[1];

		Theme::activate($themeName);

		Redirects::to(System::getUrl().'npanel/theme');
	}

	public static function setting($isPrivate='no')
	{

		if(!$match=Uri::match('setting\/(\w+)'))
		{
			Redirect::to(System::getAdminUrl());
		}

		$theName=$match[1];

		$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_setting_theme');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}

		$pageData['title']=ucfirst($theName);

		$thePath=THEMES_PATH.$theName.'/';

		if(!is_dir($thePath))
		{
			Redirect::to(System::getAdminUrl());
		}

		define('THEME_CP_PATH', $thePath.'cp/');

		define("THEME_VIEW_PATH", $thePath.'cp/views/');
		define("THEME_CONTROLLER_PATH", $thePath.'cp/controllers/');
		define("THEME_MODEL_PATH", $thePath.'cp/models/');

		$indexPath=THEME_CONTROLLER_PATH.'controlHome.php';

	
		if(file_exists($indexPath))
		{
			$controlName='home';

			$methodName='index';

			if($match=Uri::match('theme\/setting\/\w+\/(\w+)'))
			{
				$controlName=$match[1];
			}

			if($match=Uri::match('theme\/setting\/\w+\/(\w+)\/(\w+)'))
			{
				$controlName=$match[1];

				$methodName=$match[2];
			}

			Controllers::load($controlName,$methodName,'contents/themes/'.$theName.'/cp/');
		}
		else
		{
			Alert::make('This theme not support setting page.');
		}

	}

	public static function import()
	{
		$valid=Usergroups::getPermission(Users::getCookieGroupId(),'can_import_theme');

		if($valid!='yes')
		{
			Alert::make('You not have permission to view this page');
		}		

		$pageData=array('alert'=>'');


		System::setTitle('Import theme - nPanel');

		Views::make('head');

		Views::make('left');

		Views::make('themeImport',$pageData);

		Views::make('footer');		
	}

}