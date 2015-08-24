<?php

class Model
{
    public static $loadPath = '';

    
    public static function setPath($path)
    {
        $path=!isset($path[2])?MODELS_PATH:$path;

        self::$loadPath=$path;
    }

    public static function resetPath()
    {
        self::$loadPath=MODELS_PATH;
    }
    
    public static function getPath()
    {
        $path=!isset(self::$loadPath[2])?MODELS_PATH:self::$loadPath;

        self::$loadPath=$path;

        return $path;
    }
    public static function loadWithPath($modelName = '', $path)
    {
        self::setPath($path);

        self::load($modelName);

        self::resetPath();
    }    

    public static function load($modelName = '')
    {
        // $path = MODELS_PATH . $modelName . '.php';
        $path = self::getPath() . $modelName . '.php';

        if (!file_exists($path))
        Log::warning('Model <b>' . $modelName . '</b> not exists.');

        include($path);
    }


}

?>