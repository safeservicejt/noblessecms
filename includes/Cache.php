<?php

class Cache
{

    private static $cacheStatus = 'disabled';

    private static $cacheLiveTime = 360;

    public static $cachePath = '';


    public static function setPath($path)
    {
        $path=!isset($path[2])?CACHES_PATH:$path;

        self::$cachePath=$path;
    }

    public static function resetPath()
    {
        self::$cachePath=CACHES_PATH;
    }
    
    public static function getPath()
    {
        $path=!isset(self::$cachePath[2])?CACHES_PATH:self::$cachePath;

        self::$cachePath=$path;

        return $path;
    }
  
    public static function enable($liveTime = 360)
    {
        self::$cacheStatus = 'enable';

        self::$cacheLiveTime = $liveTime;

        self::loadCache();
    }



    public static function savePage($addPath='',$extension='.template')
    {
        $keyName=System::getUri();

        $keyName=isset($keyName[1])?$keyName:'defaultHome';

        $savePath=ROOT_PATH.'application/caches/templates/';



        if(isset($addPath[2]))
        {
            $savePath=ROOT_PATH.'application/caches/'.$addPath;

            if(!is_dir($savePath))
            {
                Dir::create($savePath);
            }
        }     

        if(is_file($savePath.$addPath.$keyName))
        {
            unlink($savePath.$addPath.$keyName);
        }
        // self::setPath($savePath);

        $keyData=ob_get_contents();

        $keyName=md5($keyName);

        $keyData=gzcompress($keyData,5);

        self::saveKey('templates/'.$keyName,serialize($keyData),$extension);

        // self::resetPath();

    }

    public static function loadPage($addPath='',$liveTime=86400,$extension='.template')
    {
        if((int)$liveTime==-1)
        {
            return false;
        }
        
        $keyName=System::getUri();

        $keyName=isset($keyName[1])?$keyName:'defaultHome';

        $keyName=md5($keyName);

        $savePath=ROOT_PATH.'application/caches/templates/';

        if(isset($addPath[2]))
        {
            $savePath=ROOT_PATH.'application/caches/'.$addPath;
        }

        self::setPath($savePath);        

        if(!$loadData=self::loadKey($keyName,$liveTime,$extension))
        {
            return false;
        }

        self::resetPath();

        $loadData=unserialize($loadData);

        $loadData=gzuncompress($loadData);  

        echo $loadData;

        exit(0);
    }

    public static function loadCache()
    {

        $load = isset($_GET['load']) ? $_GET['load'] : 'default_codeme';

        $url = trim($load);

        // $cachePath = CACHES_PATH . md5($url) . '.cache';
        $cachePath = self::getPath() . md5($url) . '.cache';

        if (file_exists($cachePath)) {

            $cacheExpires = time() - filemtime($cachePath);

            if ($cacheExpires <= (int)self::$cacheLiveTime) {
                $cacheData = file_get_contents($cachePath);

                echo $cacheData;

                die();
            }

        }

//        if (self::$cacheStatus == 'enable') {
//            $url = trim($_GET['load']);
//
//            $cachePath = CACHES_PATH . md5($url) . '.cache';
//
//            if (file_exists($cachePath)) {
//
//                $cacheData = file_get_contents($cachePath);
//
//                echo $cacheData;
//
//            }
//
//        }
    }

    // Default timeLive=1 day
    public static function saveKey($keyName,$keyData='',$extension='.cache')
    {
        $f_type='w';
        // $filePath=CACHES_PATH.$keyName.'.cache';

        $filePath=self::getPath().$keyName.$extension;

        if(preg_match('/^(.*?)\/\w+\.\w+$/i', $filePath,$match))
        {
            $path=$match[1];

            Dir::create($path);
        }

        $filePath=self::getPath().$keyName.$extension;

        if(!file_exists($filePath))
        {
            $f_type='x';
        }

        $fp=fopen($filePath,$f_type);

        fwrite($fp,$keyData);

        fclose($fp);
    }

    public static function hasKey($keyName,$timeLive=86400,$extension='.cache')
    {
        $filePath=self::getPath().$keyName.$extension;

        if(!file_exists($filePath))
        {
            return false;
        }
        else
        {
            $cacheExpires = time() - filemtime($filePath);

            if ((int)$timeLive == -1 || $cacheExpires <= (int)$timeLive) {
                return true;

            }

            return false;
        }        


        return false;  
    }

    public static function loadKey($keyName,$timeLive=86400,$extension='.cache')
    {
        // $filePath=CACHES_PATH.$keyName.'.cache';
        $filePath=self::getPath().$keyName.$extension;

        // if(!isset($keyName[2]) || !isset($filePath[2]))
        // {
        //     return false;
        // }

        // if(!preg_match('/.*?\.\w+$/i', $filePath))
        // {
        //     return false;
        // }
        if(preg_match('/\W/i', $keyName) || !preg_match('/.*?\.\w+$/i', $filePath) || !is_file($filePath))
        {
            return false;
        }
        // $cacheExpires = time() - filemtime($filePath);

        $fileTime=filemtime($filePath);

        $cacheExpires = time() - (int)$fileTime;

        if ((int)$timeLive == -1 || $cacheExpires <= (int)$timeLive) {
            $cacheData = file_get_contents($filePath);

            return $cacheData;
        }
        else
        {
            unlink($filePath);
        }

        return false;        
    }
    public static function removeKey($keyName,$extension='.cache')
    {
        // $filePath=CACHES_PATH.$keyName.'.cache';
        $filePath=self::getPath().$keyName.$extension;

        if(!file_exists($filePath))return true;

        unlink($filePath);

        return true;        
    }

    public static function saveCache()
    {

        if (self::$cacheStatus == 'enable') {

            $load = isset($_GET['load']) ? $_GET['load'] : 'default_codeme';

            $url = trim($load);

            // $savePath = CACHES_PATH . md5($url) . '.cache';
            $savePath = self::getPath() . md5($url) . '.cache';

            $viewsData = ob_get_contents();

            ob_end_clean();

            File::create($savePath, $viewsData);

            echo $viewsData;
        }

    }
}

?>