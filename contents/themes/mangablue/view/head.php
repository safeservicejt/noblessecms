<!DOCTYPE html>
<html lang="en">
  <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="<?php echo $keywords;?>">
        <meta name="description" content="<?php echo $description;?>">
        <link rel="shortcut icon" href="<?php echo ROOT_URL;?>bootstrap/favicon.ico">
        <meta name="author" content="Safeservicejt">
        <meta name="url" id="rootUrl" content="<?php echo ROOT_URL;?>">

        <title><?php echo $title;?></title>

    <!-- Bootstrap theme -->
     <link href="<?php echo THEME_URL;?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo THEME_URL;?>css/flat-theme.css" rel="stylesheet">
       <link href="<?php echo THEME_URL;?>css/custom.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
        <script src="<?php echo ROOT_URL;?>bootstrap/js/system.js"></script>
        
      <script src="<?php echo THEME_URL;?>js/jquery-2.1.1.min.js"></script>
      <script src="<?php echo THEME_URL;?>js/jquery-2.1.1.min.map"></script>
        <!-- bxSlider Javascript file -->
        <script src="<?php echo ROOT_URL;?>bootstrap/js/jquery.bxslider.min.js"></script>
        <!-- bxSlider CSS file -->
        <link href="<?php echo ROOT_URL;?>bootstrap/css/jquery.bxslider.css" rel="stylesheet" />
      
      <script src="<?php echo THEME_URL;?>js/custom.js"></script>
            
  </head>

  <body>




    <div class="container">

        <div class="row" style="margin-top:15px;">

            <!--Logo-->

            <div class="col-md-12">
                <img src="<?php echo Url::bannerImg();?>" class="img-responsive" />
            </div>

            <!--Menu-->

            <div class="col-md-12" style="background-color:#3399fe;margin-top:15px;">
                <div class="row">
                    <div class="col-md-8">
                        <ul class="main_menu">
                            <li><a href="df">TRANG CHU</a></li>
                            <li><a href="df">TRANG CHU</a></li>
                            <li><a href="df">TRANG CHU</a></li>
                            <li><a href="df">TRANG CHU</a></li>

                        </ul>
                    </div>

                    <div class="col-md-4" style="padding:7px 20px 5px 0px;">
                        <div class="input-group">
                            <input type="text" class="form-control" name="k" placeholder="Search...">
                          <span class="input-group-btn">
                            <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                          </span>
                        </div><!-- /input-group -->
                    </div>
                </div>

            </div>