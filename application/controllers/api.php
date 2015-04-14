<?php

class api
{

	public function index()
	{

	}

    public function getJson()
    {
        $resultData=Coreapi::parseUri();  

        echo $resultData;die();
    }

    public function getPlugin()
    {
        if(!isset($_REQUEST['dir']))
        {
            Alert::make('Page not found');
        }

        $dirName=trim($_REQUEST['dir']);

        if(!isset($dirName[1]) || preg_match('/\//i', $dirName))
        {
            Alert::make('Page not found');
        }

        $filePath=ROOT_PATH.'contents/plugins/'.$dirName.'/';

        if(isset($_REQUEST['filename']))
        {
            $filePath=$filePath.trim($_REQUEST['filename'])'.php';
        }
        else
        {
            $filePath=ROOT_PATH.'contents/plugins/'.$dirName.'/'.$dirName.'.php';
        }
        
        if(!file_exists($filePath))
        {
            Alert::make('Page not found');
        }

        include($filePath);

        if(isset($_REQUEST['func']))
        {
            $func=trim($_REQUEST['func']);

            $func();
        }
    }


    public function getDownload()
    {
        $resultData=array('error'=>'yes');

        if(!Session::has('userid'))
        {
            echo json_encode($resultData);die();
        }

        if(!$match=Uri::match('\/download\/(\w+)'))
        {
            echo json_encode($resultData);die();
        }

        $method=strtolower($match[1]);

        switch ($method) {
            case 'template':
                $loadData=TemplateStore::download();
                break;
            case 'plugin':
                $loadData=PluginStore::download();
                break;
   
        }

        echo $loadData;
    }

    public function getCart()
    {
        Model::load('api/cart');    

        $loadData=processCart();

        // if($loadData)
        // {
        //  echo 'ERROR';die();
        // }

        
        echo $loadData; die();

    }
	public function getOrders()
	{
        Model::load('api/orders');  	

        $loadData=processOrders();

        // if($loadData)
        // {
        // 	echo 'ERROR';die();
        // }

        
        echo $loadData; die();

	}

    public function getUsers()
    {
        Model::load('api/users');  

        apiUsers(); 

        die();

    }

	public function getLang()
	{
        Model::load('api/lang');  

        $data=processLang();


        echo $data;

        die();

	}
	
}
?>