<?php

class Theme
{

    public function loadShortCode()
    {
        $path=THEME_PATH.'functions.php';

        if(!file_exists($path))
        {
            return false;
        }

        try {

            require($path);

        } catch (Exception $e) {

            throw new Exception("Error while require functions of theme ".THEME_NAME);

        }

    }

    public function controller($controlName = '', $funcName = 'index')
    {  
        $funcOfController = '';

        if (preg_match('/(\w+)\@(\w+)/i', $controlName, $matchesName)) {
            $controlName = $matchesName[1];

            $funcOfController = $matchesName[2];

            $funcName = $funcOfController;
        }

        $path = THEME_PATH . 'controller/' . $controlName . '.php';


        if (!file_exists($path)) Alert::make('Controller <b>'.$controlName.'</b> not exists.');

        include($path);

    }
    public function model($modelName = '')
    {
        $path = THEME_PATH . 'model/' . $modelName . '.php';

        if (!file_exists($path)) Alert::make('Model <b>' . $modelName . '</b> not exists.');

        include($path);
    }
    public function view($viewName = '', $viewData = array())
    {
        if (preg_match('/\./i', $viewName)) {
            $viewName = str_replace('.', '/', $viewName);
        }

        $path = THEME_PATH . 'view/' . $viewName . '.php';

        if (!file_exists($path)) {
            Alert::make('Page '.$viewName.' is not found');
        }

        $total_data = count($viewData);

        if ($total_data > 0) extract($viewData);

        include($path);
    }

    public function viewHas($viewName = '', $viewData = array())
    {
        if (preg_match('/\./i', $viewName)) {
            $viewName = str_replace('.', '/', $viewName);
        }

        $path = THEME_PATH . 'view/' . $viewName . '.php';

        if (!file_exists($path)) {
            return false;
        }

        return true;
    }

    public function load($viewName = '', $viewData = array())
    {
        if (preg_match('/\./i', $viewName)) {
            $viewName = str_replace('.', '/', $viewName);
        }

        $path = THEME_PATH . $viewName . '.php';

        if (!file_exists($path)) {
            Alert::make('Page not found');
        }

        $total_data = count($viewData);

        if ($total_data > 0) extract($viewData);

        include($path);
    }

    
    
	
}

?>