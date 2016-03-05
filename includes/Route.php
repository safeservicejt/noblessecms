<?php

/*

Place below function in index.php file of plugin which you wanna add route

Route::add('route_name','function_to_run');

Route::get('api', function(){

    Route::get('api/get', function(){

        echo 'ok';
    });
});

Route::get('api', function(){

    Route::post('api/get', function(){

        echo 'ok';
    });
});

Route::getChild('ac',function(){

    echo 'ok'
});


Route::get('ac',function(){
    Controller::loadWithPath('controlIndex','index','contents/themes/cleanvideo/controllers/');
});


*/
class Route
{
    public static $parentRoute='';

    public static $hasParent='no';

    public static $canAdd='no';

    public static $canRemove='no';


    public static function loadFromPlugin()
    {
        $loadData=array();

        if(!isset(Plugins::$listCaches['route']))
        {
            // $loadData=PluginsMeta::get(array(
            //     'where'=>"where zonename='route' AND status='1'",
            //     'cache'=>'no',
            //     'cacheTime'=>30
            //     ));     

            return false;       
        }
        else
        {
            $loadData=Plugins::$listCaches['route'];
        }

        if(isset($loadData[0]['metaid']))
        {
            $total=count($loadData);

            for ($i=0; $i < $total; $i++) { 

                if((int)$loadData[$i]['status']==0)
                {
                    continue;
                }

                $func=$loadData[$i]['func'];

                $foldername=$loadData[$i]['foldername'];

                $pluginPath=PLUGINS_PATH.$foldername.'/index.php';

                if(!function_exists($func))
                {
                    include($pluginPath);
                }

                    $routeName=$loadData[$i]['content'];

                    preg_match('/([^\/].*[^\/?])/i', $routeName,$match);

                    $routeName=$match[1];

                    $routeName=str_replace('/', '\/', $routeName);

                    $uri=System::getUri();

                    if(preg_match('/^'.$routeName.'/i', $uri))
                    {

                        $func();

                        exit;
                    }
                

            }
        }
    }

    public static function add($routeName='',$functionName='',$method='function')
    {
        if(self::$canAdd=='no')
        {
            throw new Exception('You can not add route');
            
        }

        if(!isset($routeName[1]) || !isset($functionName[1]))
        {
            throw new Exception('Data not valid.');
            
        }

        $inputData=array();

        $data=debug_backtrace();    

        $pluginPath=dirname($data[0]['file']).'/';

        $foldername=basename($pluginPath);

        if(!isset($foldername[1]))
        {
            throw new Exception('Folder name not valid.');
        }        

        $inputData['foldername']=$foldername;

        $inputData['func']=$functionName;

        $inputData['zonename']='route';

        $inputData['layoutname']='route';

        $inputData['content']=$routeName;

        $inputData['status']=1;

        PluginsMeta::insert($inputData);

    }

    public static function remove()
    {

        if(self::$canRemove=='no')
        {
            return false;
        }

        $data=debug_backtrace();    

        $pluginPath=dirname($data[0]['file']).'/';

        $foldername=basename($pluginPath);

        if(!isset($foldername[1]))
        {
            throw new Exception('Folder name not valid.');
        }  

        Database::query("delete from plugins_meta where foldername='$foldername'");        
    }

    public static function post($routeName='',$controllerName)
    {
        self::get($routeName,$controllerName,'post');
    }

    public static function insert($routeName='',$controllerName)
    {
        self::get($routeName,$controllerName,'insert');
    }

    public static function delete($routeName='',$controllerName)
    {
        self::get($routeName,$controllerName,'delete');
    }

    public static function update($routeName='',$controllerName)
    {
        self::get($routeName,$controllerName,'update');
    }

    public static function put($routeName='',$controllerName)
    {
        self::get($routeName,$controllerName,'put');
    }

    public static function pop($routeName='',$controllerName)
    {
        self::get($routeName,$controllerName,'pop');
    }

    public static function getChild($routeName='',$controllerName)
    {
        $_GET['load'].='/'.$routeName;

        self::get($routeName,$controllerName);
    }

    public static function get($routeName='',$controllerName,$method='get')
    {
        $uri=System::getUri();
        
        $varObject = '';

        $subFunc='index';

        $loadData=array();

        if($method!='get')
        {
            switch ($method) {
                case 'post':
                    $loadData=$_POST;
                    break;
                case 'put':
                    $loadData=$_PUT;
                    break;
                case 'pop':
                    $loadData=$_POP;
                    break;
                case 'delete':
                    $loadData=$_DELETE;
                    break;
                case 'insert':
                    $loadData=$_INSERT;
                    break;
                case 'update':
                    $loadData=$_UPDATE;
                    break;

            }            

            $total=count($loadData);

            if($total==0)
            {
                Alert::make('Page not found');
            }
        }
        
        if(isset($routeName[1]))
        {

            if(!stristr('\/', $routeName))
            {
                $routeName=str_replace('/', '\/', $routeName);               
            }

            if(isset($uri) && !preg_match('/'.$routeName.'/i', $uri))
            {
                return false;
            }
  
        }

        if(isset($uri) && !is_object($controllerName) && preg_match('/(.*?)\@(\w+)/i', $controllerName,$matches))
        {
            $controllerName=$matches[1];

            $subFunc=$matches[2];
        }

        if (is_object($controllerName)) {

            $controllerName();

        }          
        else
        {
            Controller::load($controllerName,$subFunc);
        }
        
        die();

    }
}