<?php

class controlPlugins
{

	public function index()
	{
		if(Uri::match('\/layouts'))
		{
			$this->layouts();
			die();
		}
		if(Uri::match('\/import'))
		{
			$this->import();
			die();
		}
		
		if(Uri::match('\/install'))
		{
			$this->install();
			die();
		}

		if(Uri::match('\/uninstall'))
		{
			$this->uninstall();
			die();
		}
		if(Uri::match('\/activate'))
		{
			$this->activate();
			die();
		}
		if(Uri::match('\/deactivate'))
		{
			$this->deactivate();
			die();
		}
		if(Uri::match('\/run\/'))
		{
			$this->run();
			die();
		}
		if(Uri::match('\/runc\/'))
		{
			$this->runc();
			die();
		}
		
		if(Uri::match('\/control'))
		{
			$this->control();
			die();
		}

		if(Uri::match('\/setting'))
		{
			$this->setting();
			die();
		}


		$post=array('alert'=>'');

		Model::load('misc');
		Model::load('admincp/plugins');

		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				// removeNews(Request::get('id'));		
			}

		}		

		$curPage=Uri::getNext('pages');

		if($curPage=='page')
		{
			$curPage=Uri::getNext('page');
		}
		else
		{
			$curPage=0;
		}

		// $post['pages']=genPage('plugins',$curPage);

		$post['plugins']=listPlugins();


		View::make('admincp/head',array('title'=>'List plugins - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/newsList',$post);

        $this->makeContents('pluginsList',$post);        

        View::make('admincp/footer'); 		
	}

	public function layouts()
	{
		$post=array('alert'=>'');

		Model::load('misc');

		if(Request::has('btnAdd'))
		{

			$post['alert']='<div class="alert alert-success">Add new layout success.</div>';

			$data=Request::get('send');


			if(!$id=Layouts::add($data))
			{

				$post['alert']='<div class="alert alert-warning">Add new layout error.</div>';
			}

		}

		if(Request::has('btnSave'))
		{
				$post['alert']='<div class="alert alert-success">Edit layout success.</div>';

				// editCategory(array('id'=>Request::get('send.id'),'title'=>Request::get('send.title'),'order'=>Request::get('send.sort_order','0'),'oldimage'=>Request::get('send.oldimage')));

				$id=Uri::getNext('edit');

				$data=array();

				$inputData=array();

				$data=Request::get('send');

				Layouts::update($id,$data);
		}

		$post['showEdit']='no';
		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				Layouts::remove(Request::get('id'));	
			}
		}

		if(Uri::has('edit'))
		{
				$post['showEdit']='yes';

				$id=Uri::getNext('edit');

				$post['id']=$id;

				$data=Layouts::get(array(
					'where'=>"where layoutid='$id'"
					));
				$post['edit']=$data[0];


		}


		$curPage=Uri::getNext('layouts');

		if($curPage=='page')
		{
			$curPage=Uri::getNext('page');
		}
		else
		{
			$curPage=0;
		}

		$post['pages']=genPage('plugins/layouts',$curPage);

		$post['layouts']=Layouts::get(array(
			'limitShow'=>30,
			'limitPage'=>$curPage,
			'orderby'=>'order by layoutname asc'
			));

		View::make('admincp/head',array('title'=>'List layouts - '.ADMINCP_TITLE));

        $this->makeContents('pluginsLayout',$post);        

        View::make('admincp/footer'); 			
	}

	public function run()
	{
		// $fileName=Uri::getNext('run');

		if(!$match=Uri::match('\/run\/(.*?)\/'))
		{
			Alert::make('Page not found');
		}

		$fileName=$match[1];

		$foldername=Uri::getNext($fileName);

		// echo $foldername;die();

		$fileName=base64_decode($fileName);

		if(!preg_match('/\.php$/i', $fileName))
		{
			$fileName.='.php';
		}

		$post=array(
			'foldername'=>$foldername,
			'fileName'=>$fileName
			);

		// die($foldername);
		// echo Render::adminHeader();die();

		// View::make('admincp/head',array('title'=>'Plugin '.$foldername.' - '.ADMINCP_TITLE));

        define("THIS_URL", ROOT_URL.'admincp/plugins/run/'.base64_encode($fileName).'/'.$foldername.'/');

        define("THIS_PATH", ROOT_PATH.'contents/plugins/'.$foldername.'/');

        // $this->makeContents('pluginContent',$post);   


        View::make('admincp/pluginContent',$post);   

        // View::make('admincp/footer'); 
	}
	public function runc()
	{
		$fileName=Uri::getNext('runc');

		if(!$match=Uri::match('\/func\/(.*?)\/'))
		{
			$foldername=Uri::getNext($fileName);
		}
		else
		{
			$foldername=Uri::getNext($match[1]);
		}
		

		// echo $foldername;die();

		$fileName=base64_decode($fileName);

		if(!preg_match('/\.php$/i', $fileName))
		{
			$fileName.='.php';
		}

		$post=array(
			'foldername'=>$foldername,
			'fileName'=>$fileName
			);

		if($match=Uri::match('\/func\/(.*?)\/'))
		{
			$post['func']=base64_decode($match[1]);
		}
		// echo Render::adminHeader();die();

		// View::make('admincp/head',array('title'=>'Plugin '.$foldername.' - '.ADMINCP_TITLE));

        // $this->makeContents('pluginRuncContent',$post);

        define("THIS_URL", ROOT_URL.'admincp/plugins/runc/'.base64_encode($fileName).'/'.$foldername.'/');

        define("THIS_PATH", ROOT_PATH.'contents/plugins/'.$foldername.'/');

        View::make('admincp/pluginRuncContent',$post);           

        // View::make('admincp/footer'); 
	}

	public function control()
	{
		Model::load('admincp/plugins');

		$post=array();

		$foldername=Uri::getNext('control');

		$func=Uri::getNext($foldername);

		$func=base64_decode($func);

		if(!isset($func[2]) || !isset($foldername[2]))
		{
			header("Location: ".ROOT_URL.'admincp/plugins');
		}

		if(Request::has('btnSave'))
		{
			$inputData=array();

			$inputData['limit']=Request::get('limit');
			$inputData['layout']=Request::get('layout');
			$inputData['position']=Request::get('position');
			$inputData['status']=Request::get('status');
			$inputData['sort_order']=Request::get('sort_order');
			$inputData['width']=Request::get('width');
			$inputData['height']=Request::get('height');

			// print_r($inputData);die();

			updateControl($foldername,$func,$inputData);


		}

		// $plugin=file(PLUGINS_PATH.$foldername.'/info.txt');

		$post['foldername']=$foldername;

		// $post['plugin']=$plugin;

		$post['func']=$func;

		$post['plugins']=listControl($foldername,$func);

		$post['layouts']=Layouts::get(array(
			'orderby'=>"order by layoutname asc"
			));

		// print_r($post['plugins']);die();

		View::make('admincp/head',array('title'=>'Control plugin '.$foldername.' - '.ADMINCP_TITLE));

        $this->makeContents('pluginsControl',$post);          

        View::make('admincp/footer'); 
	}
	public function import()
	{
		Model::load('admincp/plugins');

		$post=array('alert'=>'');

		if(Request::has('btnSend'))
		{
			$post['alert']=importProcess();
		}
		
		View::make('admincp/head',array('title'=>'Import plugin - '.ADMINCP_TITLE));

        $this->makeContents('pluginImport',$post);          

        View::make('admincp/footer'); 
	}	
	public function setting()
	{
		// Model::load('admincp/plugins');

		$post=array();

		$foldername=Uri::getNext('setting');

		$func=Uri::getNext($foldername);

		$func=base64_decode($func);

		if(!isset($func[2]) || !isset($foldername[2]))
		{
			header("Location: ".ROOT_URL.'admincp/plugins');
		}

		define("PLUGIN_PATH", PLUGINS_PATH . $foldername .'/');

		define("PLUGIN_URL", PLUGINS_URL . $foldername .'/');

		// $plugin=file(PLUGINS_PATH.$foldername.'/info.txt');

		$filePath=PLUGINS_PATH.$foldername.'/'.$foldername.'.php';

		$post['foldername']=$foldername;
		$post['filePath']=$filePath;

		$post['func']=$func;

		// $post['plugin']=$plugin;
		// print_r($post['plugins']);die();

		View::make('admincp/head',array('title'=>'Setting plugin '.$foldername.' - '.ADMINCP_TITLE));

        $this->makeContents('PluginsSetting',$post);          

        View::make('admincp/footer'); 
	}
	
	public function activate()
	{
		$foldername=Uri::getNext('activate');

		// echo Render::adminHeader();die();

		$query=Database::query("select zonename,metaid from plugins_meta where foldername='$foldername'");

		$num_rows=Database::num_rows($query);

		if((int)$num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				Plugins::updateZone($row['zonename'],$row['metaid'],array('status'=>'1'));	
			}

			Database::query("update plugins_meta set status='1' where foldername='$foldername'");
		}
	
		header("Location: ".ROOT_URL.'admincp/plugins');
	}

	public function deactivate()
	{
		$foldername=Uri::getNext('deactivate');

		// echo $foldername;die();

		$query=Database::query("select zonename,metaid from plugins_meta where foldername='$foldername'");

		$num_rows=Database::num_rows($query);

		if((int)$num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{

				Plugins::updateZone($row['zonename'],$row['metaid'],array('status'=>'0'));	
			}

			Database::query("update plugins_meta set status='0' where foldername='$foldername'");
		}
	
		header("Location: ".ROOT_URL.'admincp/plugins');
	}

	public function install()
	{
		$foldername=Uri::getNext('install');

		// echo $foldername;die();

		$query=Database::query("select metaid from plugins_meta where foldername='$foldername'");

		$num_rows=Database::num_rows($query);

		// echo $num_rows;die();

		if((int)$num_rows == 0)
		{
			$pluginPath=PLUGINS_PATH.$foldername.'/'.$foldername.'.php';

			Plugins::$canAddZone='yes';
			Plugins::$isInstall='yes';

			Plugins::$folderName=$foldername;

			require($pluginPath);

			Database::query("insert into plugins_meta(foldername,zonename,status) values('$foldername','$zonename','0')");
		}

		// Plugins::$canAddZone='no';

		header("Location: ".ROOT_URL.'admincp/plugins');
	}

	public function uninstall()
	{
		$foldername=Uri::getNext('uninstall');

		// echo $foldername;die();

		$pluginPath=PLUGINS_PATH.$foldername.'/'.$foldername.'.php';

		Plugins::$canAddZone='no';
		Plugins::$isUninstall='yes';

		Plugins::$folderName=$foldername;




		// Plugins::$canAddZone='no';

		require($pluginPath);

		Plugins::systemUninstall($foldername);

		header("Location: ".ROOT_URL.'admincp/plugins');
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