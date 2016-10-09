<?php
ob_start();
error_reporting(0);
session_start();

include('../includes/Request.php');
include('../includes/Strings.php');

include('import.php');

if(!isset($_REQUEST['do']))
{
  die('Hi you !');
}

$do=$_REQUEST['do'];

switch ($do) {
  case 'connect':
  
    checkConnect();

    break;
  case 'complete':

    startInstall();

    break;
  

}
function cronjob_exists($command){

    $cronjob_exists=false;

    exec('crontab -l', $crontab);


    if(isset($crontab)&&is_array($crontab)){

        $crontab = array_flip($crontab);

        if(isset($crontab[$command])){

            $cronjob_exists=true;

        }

    }
    return $cronjob_exists;
}
// Append a cronjob

function append_cronjob($command){

    if(is_string($command)&&!empty($command)&&cronjob_exists($command)===FALSE){

        //add job to crontab
        exec('echo -e "`crontab -l`\n'.$command.'" | crontab -', $output);


    }

    return $output;
}
function startInstall()
{
  $dbhost=trim($_REQUEST['dbhost']);

  $dbuser=trim($_REQUEST['dbuser']);

  $dbpass=trim($_REQUEST['dbpass']);

  $dbname=isset($_REQUEST['dbname'])?trim($_REQUEST['dbname']):'';

  $dbport=trim($_REQUEST['dbport']);

  // $url=trim($_REQUEST['url']);
  
  $path=trim($_REQUEST['path']);
  
  $username=trim($_REQUEST['username']);

  $email=trim($_REQUEST['email']);
  
  $password=trim($_REQUEST['password']);

  $secretKey=Strings::randAlpha(20);

  $isHttp=$_SERVER['HTTPS'];

  $beforeUrl=($isHttp=='on')?'https://':'http://';

  $host=$beforeUrl.$_SERVER['HTTP_HOST'];

  $uri=$host.$_SERVER['REQUEST_URI'];

  preg_match('/(.*?)\/install/i', $uri,$match);

  $url=$match[1];

  $theHost=$url;

  $parseUrl=parse_url($url);

  if(isset($parseUrl['host']))
  {
    $theHost=$parseUrl['host'].$parseUrl['path'];
  }
  

  // echo $path;

  // die();

  // define("ENCRYPT_SECRET_KEY", $secretKey);

  if(!preg_match('/^http/i', $url))
  {
    $url=$beforeUrl.$url;
  }

  if(!preg_match('/^https?.*?\/$/i', $url))
  {
    $url=$url.'/';
  }

  $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname, $dbport);  

  if(isset($conn->connect_error[5]))
  {
    echo json_encode(array('error'=>'yes'));
    die();
  }

  if(!isset($dbname[1]))
  {
    $dbname='noblessecms_db'.Strings::randText(5);

    $conn->query("CREATE DATABASE $dbname CHARACTER SET utf8 COLLATE utf8_general_ci;");
    $conn->query("GRANT ALL ON $dbname.* TO '$dbuser'@localhost IDENTIFIED BY '$dbpass';");
    $conn->query("FLUSH PRIVILEGES;");

    if(isset($conn->connect_error[5]))
    {
      echo json_encode(array('error'=>'yes','message'=>'Can not connect to database for create database'));
      die();     
    }

    $conn->select_db($dbname);

  }

  $rootPath=dirname(dirname(__FILE__)).'/';

  if(!file_exists($rootPath.'.htaccess'))
  {
    copy($rootPath.'install/htaccess.txt',$rootPath.'.htaccess');
  }

  // Check & create htaccess

  $requestUri=$_SERVER['REQUEST_URI'];

  $pathSelf=$_SERVER['PHP_SELF'];

  if(isset($requestUri[12]))
  {
    // $requestUri=dirname($requestUri).'/';

    $pathSelf=dirname(dirname($pathSelf)).'/';

    $getData=file_get_contents($rootPath.'.htaccess');

    $getData=preg_replace('/RewriteBase.*/i', 'RewriteBase '.$pathSelf, $getData);

    chmod($rootPath.'.htaccess', 0666);

    $fp=fopen($rootPath.'.htaccess','w');

    fwrite($fp,$getData);

    fclose($fp);   
    
    chmod($rootPath.'.htaccess', 0644);

  }

  $getData=file_get_contents($rootPath.'.htaccess');

  $getData=str_replace('RewriteBase \/', 'RewriteBase /', $getData);

  chmod($rootPath.'.htaccess', 0666);
  
  $fp=fopen($rootPath.'.htaccess','w');

  fwrite($fp,$getData);

  fclose($fp);     

  chmod($rootPath.'.htaccess', 0644);


  $loadData=file_get_contents($rootPath.'config.php');

  $tmpPath=str_replace('\\', '/', $rootPath);

  $replace=array(
    '/"dbhost" \=\> ".*?"/i'=>'"dbhost" => "'.$dbhost.'"',
    '/"dbuser" \=\> ".*?"/i'=>'"dbuser" => "'.$dbuser.'"',
    '/"dbpassword" \=\> ""/i'=>'"dbpassword" => "'.$dbpass.'"',
    '/"dbname" \=\> ".*?"/i'=>'"dbname" => "'.$dbname.'"',
    '/"dbport" \=\> ".*?"/i'=>'"dbport" => "'.$dbport.'"',
   '/root_path = \'.*?\';/i'=>'root_path = \''.$tmpPath.'\';',
   '/root_url = \'.*?\';/i'=>'root_url = \''.$theHost.'\';',
   '/"ENCRYPT_SECRET_KEY", ".*?"/i'=>'"ENCRYPT_SECRET_KEY", "'.$secretKey.'"'
    );

  $loadData=preg_replace(array_keys($replace), array_values($replace), $loadData);

  chmod($rootPath.'config.php', 0666);

  $fp=fopen($rootPath.'config.php','w');

  fwrite($fp,$loadData);

  fclose($fp);

  chmod($rootPath.'config.php', 0644);


  $importStatus='';

  try {
    importProcess($conn,'db.sql');
  } catch (Exception $e) {
    $importStatus=$e->getMessage();
  }

  if(isset($importStatus[2]))
  {
    echo json_encode(array('error'=>'yes','message'=>$importStatus));
    die();      
  }


  $ip=$_SERVER['REMOTE_ADDR'];

  $date_added=date('Y-m-d H:i:s');

  $md5Pass=Strings::encrypt($password,$secretKey);

  $query=$conn->query("insert into users(groupid,username,email,password,date_added) values('1','$username','$email','$md5Pass','$date_added')");
 
  if(isset($conn->error[5]))
  {
    echo json_encode(array('error'=>'yes','message'=>$conn->error));
    die();    
  }

  $query=$conn->query("select * from users");

  $rowData=$query->fetch_assoc();

  $id=$rowData['id'];

  $query=$conn->query("insert into address(userid,firstname,lastname) values('$id','Admin','System')");
   
  if(isset($conn->error[5]))
  {
    echo json_encode(array('error'=>'yes','message'=>$conn->error));
    die();    
  }


  rename('../install','../installBackup');

  exec('crontab -r');

  append_cronjob('* * * * * curl -s '.$url.'api/cronjob/run.php');  
  
  $result['username']=Request::get('username');
  $result['password']=Request::get('password');
  $result['siteurl']=$url.'npanel/';
  $result['Urlfontend']=$url;
  $result['error']='no';

  echo json_encode($result);
  die();
}

function checkConnect()
{
  $dbhost=trim($_REQUEST['dbhost']);

  $dbuser=trim($_REQUEST['dbuser']);

  $dbpass=trim($_REQUEST['dbpass']);

  $dbname=trim($_REQUEST['dbname']);

  $dbport=trim($_REQUEST['dbport']);


  $conn = new mysqli($dbhost, $dbuser, $dbpass, '', $dbport); 

  if(isset($conn->connect_error[5]))
  {
    die('ERRORCONNECT');
  }

  die('OK');
}

?>