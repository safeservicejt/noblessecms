<?php

class controlPaymentmethods
{

	public function index()
	{
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

		if(Uri::match('\/setting'))
		{
			$this->setting();
			die();
		}


		$post=array('alert'=>'');

		Model::load('misc');
		Model::load('admincp/paymentmethods');

		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				// removeNews(Request::get('id'));		
			}

		}		

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		// $post['pages']=genPage('plugins',$curPage);

		$post['methods']=listPaymentmethods();


		View::make('admincp/head',array('title'=>'List payment methods - '.ADMINCP_TITLE));


        $this->makeContents('pmethodList',$post);        

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
			header("Location: ".ADMINCP_URL.'paymentmethods');
		}

		define("PAYMENTMETHOD_PATH", PMETHOD_PATH . $foldername .'/');

		define("PAYMENTMETHOD_URL", PMETHOD_URL . $foldername .'/');

		// $plugin=file(PLUGINS_PATH.$foldername.'/info.txt');

		$filePath=PMETHOD_PATH.$foldername.'/index.php';

		$post['foldername']=$foldername;
		$post['filePath']=$filePath;

		$post['func']=$func;

		// $query=Database::query("select title from payment_methods where foldername='$foldername'");

		// $num_rows=Database::num_rows($query);

		// if((int)$num_rows==0)
		// {
		// 	Alert::make('Page not found');
		// }

		$loadData=Paymentmethods::get(array(
			'where'=>"where foldername='$foldername'"
			));

		if(!isset($loadData[0]['methodid']))
		{
			Alert::make('Page not found');
		}		

		// $row=Database::fetch_assoc($query);

		$row=$loadData[0];

		$methodTitle=$row['title'];

		$post['title']=$methodTitle;

		View::make('admincp/head',array('title'=>$methodTitle.' - '.ADMINCP_TITLE));

        $this->makeContents('PMethodSetting',$post);          

        View::make('admincp/footer'); 
	}
	
	public function activate()
	{
		$foldername=Uri::getNext('activate');

		Paymentmethods::updateMethod($foldername,'1');
	
		header("Location: ".ADMINCP_URL.'paymentmethods');
	}

	public function deactivate()
	{
		$foldername=Uri::getNext('deactivate');

		Paymentmethods::updateMethod($foldername,'0');
	
		header("Location: ".ADMINCP_URL.'paymentmethods');
	}

	public function install()
	{
		$foldername=Uri::getNext('install');

		$loadData=Paymentmethods::get(array(
			'where'=>"where foldername='$foldername'"
			));

		if(!isset($loadData[0]['methodid']))
		{
			$pluginPath=PMETHOD_PATH.$foldername.'/index.php';

			Paymentmethods::$isInstall='yes';

			Paymentmethods::$folderName=$foldername;

			if(file_exists($pluginPath))
			{
				require($pluginPath);	

				Paymentmethods::systemInstall($foldername);							
			}
		}

		header("Location: ".ADMINCP_URL.'paymentmethods');
	}

	public function uninstall()
	{
		$foldername=Uri::getNext('uninstall');

		// echo $foldername;die();

		$pluginPath=PMETHOD_PATH.$foldername.'/index.php';

		Paymentmethods::$isUninstall='yes';

		Paymentmethods::$folderName=$foldername;

		Paymentmethods::systemUninstall($foldername);

		if(file_exists($pluginPath))
		{
			require($pluginPath);				
		}

		header("Location: ".ADMINCP_URL.'paymentmethods');
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