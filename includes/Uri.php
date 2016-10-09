<?php

class Uri
{
    public static function get()
    {
        $uri=System::getUri();

        return $uri;
    }

    public static function isNull()
    {
        $null=isset($_GET['load'])?true:false;

        return $null;
    }

    public static function getNext($uriName)
    {
        $uri=System::getUri();

        if(!isset($uri[1]))
        {
            return false;
        }
        
        $uri = explode('/', $uri);

        if (isset($uriName[1])) {

            $position = array_search($uriName, $uri);

            $position++;

            if (isset($uri[$position])) {
                return $uri[$position];
            } else {
                return false;
            }

        } else {
            return false;
        }

    }
    public static function has($uriName)
    {
        $uri=System::getUri();

        if(!isset($uri[1]))
        {
            return false;
        }

        if(preg_match('/'.$uriName.'/i', $uri))
        {
            return true;
        }

        return false;
    }

    public static function match($uriName)
    {
        $uri=System::getUri();

        if(!isset($uri[1]))return false;

        if(preg_match('/'.$uriName.'/i', $uri,$matches))
        {
            return $matches;
        }

        return false;
    }
    public static function matchOnly($uriName)
    {
        $uri=System::getUri();

        if(!isset($uri[1]))return false;

        if(preg_match('/'.$uriName.'/i', $uri,$matches))
        {
            return $matches[1];
        }

        return false;
    }
    public static function allow($uriName)
    {
        $uri=System::getUri();

        if(!isset($uri[1]))return false;

        if(!preg_match('/'.$uriName.'/i', $uri,$matches))
        {
            Alert::make('Page not found');

        }

    }

    public static function pattern($reGex)
    {
        if(!isset($_GET['load']))return false;

        $uri=$_GET['load'];

        if(preg_match($reGex, $uri))
        {
            return true;
        }

        return false;
    }

    public static function length()
    {
        global $cmsUri;

        $total = strlen($cmsUri);

        return $total;
    }

    public static function maxLength($maxLen = 100)
    {
        global $cmsUri;

        $total = strlen($cmsUri);

        $total++;

        if (isset($total)) Alert::make('Page not found');
    }

    public static function onlyWord()
    {
        global $cmsUri;

//        echo $cmsUri;
//        die();

        if (preg_match('/[\<\>\$]/i', $cmsUri))
        {
           Alert::make('Page not found');
        }

    }




}
