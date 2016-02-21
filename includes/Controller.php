<?php

class Controller
{
    public static $loadPath = '';
    
    public static function setPath($path)
    {
        $path=!isset($path[2])?CONTROLLERS_PATH:$path;

        self::$loadPath=$path;
    }
    
    public static function resetPath()
    {
        self::$loadPath=CONTROLLERS_PATH;
    }

    public static function getPath()
    {
        $path=!isset(self::$loadPath[2])?CONTROLLERS_PATH:self::$loadPath;

        self::$loadPath=$path;

        return $path;
    }
    
    public static function loadWithPath($controlName = '', $funcName = 'index', $path)
    {
        self::setPath($path);

        self::load($controlName,$funcName);

        self::resetPath();
    }

    public static function load($controlName = '', $funcName = 'index')
    {  
        // $funcOfController = '';

        if (preg_match('/(\w+)\@(\w+)/i', $controlName, $matchesName)) {
            $controlName = $matchesName[1];

            // $funcOfController = $matchesName[2];

            $funcName = $matchesName[2];
        }

        // $path = CONTROLLERS_PATH . $controlName . '.php';
        $path = self::getPath() . $controlName . '.php';


        if (!file_exists($path))
        {
            Response::headerCode(404);

            Log::warning('Controller <b>'.$controlName.'</b> not exists.');

        }

        include($path);

        if(preg_match('/.*?\/(\w+)$/i',$controlName,$matches))
        {
            $controlName=$matches[1];
        }

        $load = new $controlName();

        if (!isset($funcName[0])) $funcName = 'index';

        // $funcName=($funcName=='index')?$funcName:'get'.ucfirst($funcName);

        if (!method_exists($load, $funcName)) 
        {
            Response::headerCode(404);     
                  
            Log::warning('Function <b>'.$funcName.'</b> not exists inside controller <b>'.$controlName.'</b> .');

        }

        $load->$funcName();

    }




}

?>