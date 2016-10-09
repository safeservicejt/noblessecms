<?php

$isHttp=isset($_SERVER['HTTPS'])?$_SERVER['HTTPS']:'';

$beforeUrl=($isHttp=='on')?'https://':'http://';

static $root_path = 'D:/wamp/htdocs/project/cms/';
static $root_url = 'test.vn/project/cms';

$root_url=$beforeUrl.$root_url.'/';

define("ENCRYPT_SECRET_KEY", "JTqigQPOlmnTEiDrjIyL");

define("ROOT_PATH", $root_path);

define("ROOT_URL", $root_url);

define("APP_PATH", $root_path . 'application/');

define("APP_URL", $root_url . 'application/');

define("CACHES_PATH", ROOT_PATH . 'caches/');

define("CONTROLLERS_URL", APP_URL . 'controllers/');

define("MODELS_URL", APP_URL . 'models/');

define("VIEWS_URL", APP_URL . 'views/');

define("LANGUAGE", 'en');

define("LANG_URL", APP_URL . 'lang/');

define("LANG_PATH", APP_PATH . 'lang/');

define("INCLUDES_PATH", ROOT_PATH . 'includes/');

define("THEME_NAME", 'colornews');

define("PREFIX", '');

define("THEMES_URL", ROOT_URL.'contents/themes/');

define("THEMES_PATH", ROOT_PATH.'contents/themes/');

define("PLUGINS_PATH", ROOT_PATH.'contents/plugins/');

define("PLUGINS_URL", ROOT_URL.'contents/plugins/');

define("API_URL", ROOT_URL.'api/');


$cmsUri = isset($_GET['load']) ? $_GET['load'] : '';

//Setting database

// Support DbType: mysqli|sqlserver|pdo|mssql

//Default or you can custom db short name
$db['default'] = array(

    "dbtype" => "mysqli",

    "dbhost" => "localhost",

    "dbport" => "3306",

    "dbuser" => "root",

    "dbpassword" => "",

    "dbname" => "2016_test"

);


/*
//Add more database

//$db['testdb']:  testdb is custom short name of database


$db['testdb'] = array(

    "dbtype" => "sqlserver",

    "dbhost" => "localhost",

    "dbport" => "3306",

    "dbuser" => "root",

    "dbpassword" => "",

    "dbname" => "2016_test"

);

$db['mongodb'] = array(

    "dbtype" => "mongodb",

    "dbhost" => "localhost",

    "dbname" => "2016_test"

);

$db['blogmssql'] = array(

    "dbtype" => "mssql",

    "dbhost" => "localhost",

    "dbport" => "3306",

    "dbuser" => "root",

    "dbpassword" => "",

    "dbname" => "2016_test"

);

$db['blog_api'] = array(

    "dbtype" => "pdo",

    "protocol" => "pgsql",

    "dbhost" => "localhost",

    "dbuser" => "root",

    "dbpassword" => "",

    "dbname" => "2016_test"

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

    $message=$message.' in file '.$file.' at line '.$line;

    // Log::report($code, $message, $file, $line);

    Alert::make($message);
}

function codemeFatalErrorShutdownHandler()
{
  $last_error = error_get_last();
  if ($last_error['type'] === E_ERROR) {
    // fatal error
    codemeErrorHandler(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
  }
}