<?php

class View
{
    public static $loadPath = '';

    public function setPath($path)
    {
        $path=!isset($path[2])?VIEWS_PATH:$path;

        self::$loadPath=$path;
    }

    public function resetPath()
    {
        self::$loadPath=VIEWS_PATH;
    }

    public function getPath()
    {
        $path=!isset(self::$loadPath[2])?VIEWS_PATH:self::$loadPath;

        self::$loadPath=$path;

        return $path;
    }

    public function has($viewName)
    {
       $path = self::getPath() . $viewName . '.php';

       if(!file_exists($path))
       {
            return false;
       }        

       return true;
    }
    
    public function make($viewName = '', $viewData = array(),$fullPath=0)
    {
        if (preg_match('/\./i', $viewName)) {
            $viewName = str_replace('.', '/', $viewName);
        }

        $path = self::getPath() . $viewName . '.php';

        if($fullPath!=0)
        {
            $path = $viewName . '.php';
        }



        if (!file_exists($path)) {
            // ob_end_clean();

            Alert::make('Page '.$path.' not found');
        }

        $total_data = count($viewData);

        if ($total_data > 0) extract($viewData);

        include($path);
    }
    public function themeMake($viewName = '', $viewData = array())
    {
        if (preg_match('/\./i', $viewName)) {
            $viewName = str_replace('.', '/', $viewName);
        }

        $path = THEME_PATH . $viewName . '.php';

        if (!file_exists($path)) {

            ob_end_clean();

            Alert::make('Page not found');

            die();
        }

        $total_data = count($viewData);

        if ($total_data > 0) extract($viewData);

        include($path);
    }



    public function load($viewName = '', $viewData = array())
    {
        self::make($viewName, $viewData);
    }


}

?>