<?php

class controlTheme
{

	public function index()
	{
		if(Uri::has('edit'))
		{
			$this->editTheme();die();
		}
		if(Uri::has('import'))
		{
			$this->importTheme();die();
		}		
		if(Uri::match('\/setting'))
		{
			$this->settingTheme();
			die();
		}
		if(Uri::match('\/run'))
		{
			$this->run();
			die();
		}
		
		$this->listThemes();

	}

	public function importTheme()
	{
		Model::load('admincp/theme');

		$post=array('alert'=>'');

		if(Request::has('btnSend'))
		{
			$post['alert']=importProcess();
		}

		View::make('admincp/head',array('title'=>'Import templates - '.ADMINCP_TITLE));

        $this->makeContents('templateImport',$post);          

        View::make('admincp/footer'); 
	}

	public function editTheme()
	{
		$post=array();

		$post['alert']='';

		Model::load('admincp/theme');

		$themeName=Uri::getNext('edit');

		$scanPath='';

		$post['fileName']='';
		$post['fileSource']='';
		$post['lastDir']='';


		if(Uri::has('path'))
		{

			$matchPath=Uri::match('.*?\/path\/(.*?)$');

			$scanPath=$matchPath[1];

			$post['lastDir']=dirname('admincp/theme/edit/'.$themeName.'/path/'.$scanPath);


			if(!is_dir(THEMES_PATH.$themeName.'/'.$scanPath))
			{
				$post['lastDir']=dirname(dirname('admincp/theme/edit/'.$themeName.'/path/'.$scanPath));
				
				if(Request::has('btnSave'))
				{
					$fileSource=Request::get('fileSource');

					$filePath=THEMES_PATH.$themeName.'/'.$scanPath;

					File::create($filePath,$fileSource);

					$post['alert']='<div class="alert alert-success">Save file changes success.</div>';
				}

				$post['fileName']=basename(THEMES_PATH.$themeName.'/'.$scanPath);

				$post['fileSource']=file_get_contents(THEMES_PATH.$themeName.'/'.$scanPath);

				$scanPath=dirname($scanPath.'/');
			}
		}

		$post['listDir']=Dir::listDir(THEMES_PATH.$themeName.'/'.$scanPath.'/');

		$post['listFiles']=Dir::listFiles(THEMES_PATH.$themeName.'/'.$scanPath.'/');

		$post['themeName']=$themeName;

		$post['scanPath']=$scanPath;

		View::make('admincp/head',array('title'=>'Edit theme - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/editTheme',$post);
        $this->makeContents('editTheme',$post);        

        View::make('admincp/footer');  
	}


	public function listThemes()
	{
		$post=array();

		$post['alert']='';

		Model::load('admincp/theme');


		// print_r(listTheme());die();

	

		if(Uri::has('activate'))
		{
			$themeName=Uri::getNext('activate');

			activateTheme($themeName);

			$post['alert']='<div class="alert alert-success">Activate theme <strong class="text-primary">'.$themeName.'</strong> success.</div>';
		}

		$post['listThemes']=listTheme();

		$post['theme']=themeInfo();

		View::make('admincp/head',array('title'=>'List themes - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/theme',$post);

        $this->makeContents('theme',$post);        

        View::make('admincp/footer');  
	}
	public function settingTheme()
	{
		if(!$match=Uri::match('theme\/setting\/(\w+)'))
		{
			Alert::make('Page not found');
		}


		$post=array();

		$post['alert']='';

		$themeName=Uri::getNext('setting');

		$post['filePath']=THEMES_PATH.$themeName.'/setting.php';

		$post['title']='Setting of theme '.ucfirst($themeName);

		if(!file_exists($post['filePath']))
		{
			$post['alert']='<div class="alert alert-warning">This theme not support setting.</div>';
		}

		View::make('admincp/head',array('title'=>'Theme setting - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/theme',$post);

        $this->makeContents('themeSetting',$post);        

        View::make('admincp/footer');  
	}


    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/nav');
                
        View::make('admincp/left');  
              
        View::make('admincp/startContent');

        View::make('admincp/'.$viewPath,$inputData);

        View::make('admincp/endContent');
         // View::make('admincp/right');

    }	
}



?>