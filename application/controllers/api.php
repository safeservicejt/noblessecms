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