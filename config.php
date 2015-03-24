<?php

static $root_path = 'D:\wamp\htdocs\project\2015\noblessecms/';
static $root_url = 'http://test.vn/project/2015/noblessecms/';

define("ENCRYPT_SECRET_KEY", "*&^@#&)@#)(*)(@#");

// Root path & url

define("ROOT_PATH", $root_path);

define("ROOT_URL", $root_url);


// Application path & url

define("APP_PATH", $root_path . 'application/');

define("APP_URL", $root_url . 'application/');

define("CONTROLLERS_PATH", APP_PATH . 'controllers/');

define("MODELS_PATH", APP_PATH . 'models/');

define("VIEWS_PATH", APP_PATH . 'views/');

define("CACHES_PATH", APP_PATH . 'caches/');

define("CONTROLLERS_URL", APP_URL . 'controllers/');

define("MODELS_URL", APP_URL . 'models/');

define("VIEWS_URL", APP_URL . 'views/');

define("ADMINCP_URL", ROOT_URL . 'admincp/');

define("USERCP_URL", ROOT_URL . 'usercp/');

define("LANGUAGE", 'en');

define("LANG_URL", APP_URL . 'lang/');

define("LANG_PATH", APP_PATH . 'lang/');

define("INCLUDES_PATH", ROOT_PATH . 'includes/');

define("SYSTEM_VERSION", '1.0');

define("PLUGINS_PATH", ROOT_PATH . 'contents/plugins/');

define("PLUGINS_URL", ROOT_URL . 'contents/plugins/');

define("PMETHOD_PATH", ROOT_PATH . 'contents/paymentmethods/');

define("PMETHOD_URL", ROOT_URL . 'contents/paymentmethods/');

define("THEMES_PATH", ROOT_PATH . 'contents/themes/');

define("THEMES_URL", ROOT_URL . 'contents/themes/');

define("NOBLESSECMS_URL", 'http://test.vn/project/2015/nobleserver/');


// Theme path & url

if(isset($_GET['load']) && preg_match('/^theme\/(\w+)$/', $_GET['load'],$matches))
{
    define('THEME_NAME', $matches[1]);

    $_SESSION['themeName']=THEME_NAME;
}
else
{
    if(isset($_SESSION['themeName']))
    {
     define('THEME_NAME', $_SESSION['themeName']);       
    }
    else
    {
       define('THEME_NAME', 'simplecolor');     
    }
}

// define('THEME_PATH', VIEWS_PATH.'frontend/themes/'.THEME_NAME.'/');

// define('THEME_URL', VIEWS_URL.'frontend/themes/'.THEME_NAME.'/');

define('THEME_PATH', THEMES_PATH.THEME_NAME.'/');

define('THEME_URL', THEMES_URL.THEME_NAME.'/');

define('ADMINCP_TITLE', 'Welcome to Cpanel - Noblesse CMS');

$uri = isset($_GET['load']) ? $_GET['load'] : '';

$_SESSION['start_time']=!isset($_SESSION['start_time'])?time():$_SESSION['start_time'];

//Setting database

// Support DbType: mysqli|sqlserver|pdo|mssql

//Default or you can custom db short name

//Dabatase info

$db['default'] = array(

    "dbtype" => "mysqli",

    "dbhost" => "localhost",

    "dbport" => "3306",

    "dbuser" => "root",

    "dbpassword" => "test",

    "dbname" => "2015_project_noblessecms"

);


/*
//Add more database

//$db['testdb']:  testdb is custom short name of database


$db['testdb'] = array(

    "dbtype" => "sqlserver",

    "dbhost" => "serverName\sqlexpress",

    "dbport" => "3306",

    "dbuser" => "root",

    "dbpassword" => "",

    "dbname" => "noblessecms_db2"

);

$db['blogmssql'] = array(

    "dbtype" => "mssql",

    "dbhost" => "localhost",

    "dbport" => "3306",

    "dbuser" => "root",

    "dbpassword" => "",

    "dbname" => "noblessecms_db2"

);

$db['blog_api'] = array(

    "dbtype" => "pdo",

    "protocol" => "pgsql",

    "dbhost" => "localhost",

    "dbuser" => "root",

    "dbpassword" => "",

    "dbname" => "noblessecms_db2"

);

*/

//Function autoload
/*
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 */

function mainClassess($className) {


    if(file_exists(INCLUDES_PATH . $className . '.php'))
    {
        require INCLUDES_PATH . $className . '.php';       
    }

 
    
}



spl_autoload_register('mainClassess');
// set_error_handler('codemeErrorHandler');

register_shutdown_function('codemeFatalErrorShutdownHandler');

function codemeErrorHandler($code, $message, $file, $line) {

    Log::report($code, $message, $file, $line);
}

function codemeFatalErrorShutdownHandler()
{
  $last_error = error_get_last();
  if ($last_error['type'] === E_ERROR) {
    // fatal error
    codemeErrorHandler(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
  }
}

?>