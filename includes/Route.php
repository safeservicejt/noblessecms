<?php

/*

Place below function in index.php file of plugin which you wanna add route

Route::add('route_name','function_to_run');

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

                    $routeName=$loadData[$i]['content'];

                    preg_match('/([^\/].*[^\/?])/i', $routeName,$match);

                    $routeName=$match[1];

                    $routeName=str_replace('/', '\/', $routeName);

                    $uri=System::getUri();

                    if(preg_match('/'.$routeName.'/i', $uri))
                    {
                        $func();

                        exit;
                    }
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

    public static function get($routeName='',$controllerName)
    {
        $uri=System::getUri();
        
        $varObject = '';



        // if(!isset($controllerName[1]))
        // {
        //     // Alert::make('Page not found');

        //     return false;
        // }

        $subFunc='index';


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

        if(isset($uri) && preg_match('/(.*?)\@(\w+)/i', $controllerName,$matches))
        {
            $controllerName=$matches[1];

            $subFunc=$matches[2];
        }

        if (is_object($controllerName)) {

            (object)$varObject = $controllerName;

            $controllerName = '';

            $varObject();

        }          
        else
        {
            Controller::load($controllerName,$subFunc);
        }
        
        die();

    }
}

?>