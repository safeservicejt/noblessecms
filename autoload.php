<?php
ob_start();
session_start();

$path=dirname(__FILE__).'/';

define("ROOT_PATH", $path);

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);


class Dir
{
    public function remove($path)
    {
        // Dir::remove(ROOT_PATH.'test');
        
        if (is_dir($path) === true)
        {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file)
            {
                self::remove(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        }

        else if (is_file($path) === true)
        {
            return unlink($path);
        }

        return false;        
    }
    
}
class File
{
    public function unzipModule($fullPath,$remove='no')
    {
        $zip = new Unzip($fullPath);

        $zip->extract();

        if($remove!='no')
        {
            unlink($fullPath);
        }

    }

    public function fullCopy( $source, $target ) {
        if ( is_dir( $source ) ) {
            @mkdir( $target );
            $d = dir( $source );
            while ( FALSE !== ( $entry = $d->read() ) ) {
                if ( $entry == '.' || $entry == '..' ) {
                    continue;
                }
                $Entry = $source . '/' . $entry; 
                if ( is_dir( $Entry ) ) {
                    self::fullCopy( $Entry, $target . '/' . $entry );
                    continue;
                }
                copy( $Entry, $target . '/' . $entry );
            }

            $d->close();
        }else {
            copy( $source, $target );
        }
    }

    public function downloadModule($fileUrl,$savePath,$unzip='no')
    {
        // self::uploadFromUrl($fileUrl,$savePath);

        $imgData=Http::getDataUrl($fileUrl);

        $fileName=basename($fileUrl);

        $fullPath=ROOT_PATH.$savePath.$fileName;

        File::create($fullPath,$imgData);

        if($unzip!='no')
        {
            self::unzipModule($fullPath,'yes');
        }

    }   

    public function create($filePath = '', $fileData = '', $writeMode = 'w')
    {
        $fp = fopen($filePath, $writeMode);
        fwrite($fp, $fileData);
        fclose($fp);
    }

}
class Compress
{

    public function gzip($inputData,$method='compress',$level=9)
    {
        $resultData='';

        switch ($method) {
            case 'compress':
                $resultData=gzcompress($inputData, $level);
                break;
            case 'uncompress':
                $resultData=gzuncompress($inputData);
                break;
            
        }

        return $resultData;
    }

    public function gzdecode($data){
      $g=tempnam('/tmp','ff');
      @file_put_contents($g,$data);
      ob_start();
      readgzfile($g);
      $d=ob_get_clean();
      return $d;
    }
    
}
class Http
{

    public function getDataUrl($url,$hasHeader='no', $follow = 'yes',$isGooglebot='yes')
    {
        $headers = array();
        // $headers[] = 'X-Apple-Tz: 0';
        // $headers[] = 'X-Apple-Store-Front: 143444,12';
        // $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        // $headers[] = 'Accept-Encoding: gzip, deflate';
        // $headers[] = 'Accept-Language: en-US,en;q=0.5';
        $headers[] = 'Cache-Control: max-age=0';
        $headers[] = 'Content-Type: text/html';
         $headers[] = 'Connection: keep-alive';
         $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
         $headers[] = 'Accept-Encoding: gzip, deflate, sdch';

        // $headers[] = 'Host: www.example.com';
        // $headers[] = 'Referer: http://www.example.com/index.php'; //Your referrer address
        // $headers[] = 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0';
        // $headers[] = 'X-MicrosoftAjax: Delta=true';

        $ch = curl_init();
        if ($follow == 'yes') curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        if($hasHeader=='yes')
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5000);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $result = curl_exec($ch);

        // $result=gzuncompress($result);

        if($hasHeader=='yes')
        $result=Compress::gzdecode($result);

         // File::create(ROOT_PATH.'accc.txt',$result);

        return $result;
    }

}



File::downloadModule('https://github.com/safeservicejt/noblessecms/archive/master.zip','','no');


$zip = new ZipArchive;
$res = $zip->open(ROOT_PATH.'master.zip');
if ($res === TRUE) {
  $zip->extractTo(ROOT_PATH);
  $zip->close();

  File::fullCopy(ROOT_PATH.'noblessecms-master', ROOT_PATH);

  Dir::remove(ROOT_PATH.'noblessecms-master');

  unlink(ROOT_PATH.'master.zip');

  $theUrl=dirname($_SERVER['PHP_SELF']);

  header("Location: $theUrl/install");

} else {
  die('Error. Contact us via email: safeservicejt@gmail.com');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Safeservicejt">
    <link rel="shortcut icon" href="https://raw.githubusercontent.com/safeservicejt/noblessecms/master/bootstrap/favicon.ico">

    <title>Auto Install - Noblesse CMS</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optional theme -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> -->



    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

    <style type="text/css">

    body
    {
        background-color: #1b8ec4;
        color: #ffffff;
    }
    .img-logo
    {
        border-radius: 135px;
    }


    </style>

</head>

<body>


<div class="container">

<!-- Page -->
    <div class="row" style="margin-top:50px;">
        <div class="col-lg-12 text-center">
            <img class="img-logo" src="https://raw.githubusercontent.com/safeservicejt/noblessecms/master/bootstrap/images/sublogo.png">
        </div>
    </div>
<!-- Page -->
<!-- Page -->
    <div class="row">
        <div class="col-lg-12 text-center">
            <h4>Noblesse CMS</h4>
        </div>
    </div>
<!-- Page -->

</div>



<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


</body>
</html>
