<?php

class View
{
    public static $loadPath = '';

    public static $hasCache='no';

    public static function onCache()
    {
        self::$hasCache='yes';
    }

    public static function offCache()
    {
        self::$hasCache='no';
    }

    public static function setPath($path)
    {
        $path=!isset($path[2])?VIEWS_PATH:$path;

        self::$loadPath=$path;
    }
    
    public static function resetPath()
    {
        self::$loadPath=VIEWS_PATH;
    }

    public static function getPath()
    {
        $path=!isset(self::$loadPath[2])?VIEWS_PATH:self::$loadPath;

        self::$loadPath=$path;

        return $path;
    }
    
    public static function makeWithPath($viewName = '', $viewData = array(),$path)
    {
        
        self::setPath($path);

        self::make($viewName,$viewData);

        self::resetPath();
    }
    
    public static function parseWithPath($viewName = '', $viewData = array(),$path,$timeLive=10)
    {
        self::setPath($path);

        self::parse($viewName,$viewData,$timeLive);

        self::resetPath();
    }

    public static function parse($viewName = '', $viewData = array(),$timeLive=10)
    {

        $path = self::getPath() . $viewName . '.php';

        if(!file_exists($path))
        {
            return false;
        }

        $pathMd5=md5($path);

   

        if(!Cache::hasKey('templates/'.$pathMd5,$timeLive,'.php'))
        {

            $fileData=file_get_contents($path);

            $fileData=Shortcode::loadInTemplate($fileData);
            
            $fileData=Shortcode::toHTML($fileData);
            
            $fileData=Shortcode::load($fileData);  
            
            // $fileMd5=md5($fileData);

            Cache::saveKey('templates/'.$pathMd5,$fileData,'.php');              
        }
        
        $path=ROOT_PATH.'application/caches/templates/';

        self::setPath($path); 

        self::make($pathMd5,$viewData);

        self::resetPath();
    }

    public static function make($viewName = '', $viewData = array())
    {
        if (preg_match('/\./i', $viewName)) {
            $viewName = str_replace('.', '/', $viewName);
        }

        // $path = VIEWS_PATH . $viewName . '.php';
        $path = self::getPath() . $viewName . '.php';

        if (!file_exists($path)) {

            Log::warning("View $viewName not exists!");
        }

        if(!$loadCache=self::loadCache($path))
        {
            $total_data = count($viewData);

            if ($total_data > 0) extract($viewData);

            extract(System::$listVar['global']);

            if(isset(System::$listVar[$viewName]))
            {
               extract(System::$listVar[$viewName]); 
            }

            include($path);

            self::saveCache($path);            
        }
        else
        {
            echo $loadCache;
        }
    }

    public static function loadCache($path)
    {
        if(self::$hasCache=='yes')
        {
            $md5Data=md5($path);  

            if($loadCache=Cache::loadKey($md5Data,-1))
            {
                return $loadCache;
            }
        }

        return false;        
    }

    public static function saveCache($path)
    {
        if(self::$hasCache=='yes')
        {
            $viewsData = ob_get_contents();

            ob_end_clean();      
            
            $md5Data=md5($path);  

            Cache::saveKey($md5Data,$viewsData);
        }
    }

    public static function load($viewName = '', $viewData = array())
    {
        self::make($viewName, $viewData);
    }


}
