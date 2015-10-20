<!DOCTYPE html>
<html lang="en">
  <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="<?php echo System::getKeywords();?>">
        <meta name="description" content="<?php echo System::getDescriptions();?>">
        <link rel="shortcut icon" href="<?php echo System::getUrl();?>bootstrap/favicon.ico">
        <meta name="author" content="Safeservicejt">
        <meta name="url" id="root_url" content="<?php echo System::getUrl();?>">

        <title><?php echo System::getTitle();?></title>

    <!-- Bootstrap theme -->
     <link href="<?php echo System::getThemeUrl();?>css/bootstrap.css" rel="stylesheet">
    
       <link href="<?php echo System::getThemeUrl();?>css/custom.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
       
      <script src="<?php echo System::getThemeUrl();?>js/jquery-2.1.1.min.js"></script>
      <script src="<?php echo System::getThemeUrl();?>js/jquery-2.1.1.min.map"></script>
              <script src="<?php echo System::getUrl();?>bootstrap/js/system.js"></script>
 
        <!-- bxSlider Javascript file -->
        <script src="<?php echo System::getUrl();?>bootstrap/bxslider/jquery.bxslider.min.js"></script>
        <!-- bxSlider CSS file -->
        <link href="<?php echo System::getUrl();?>bootstrap/bxslider/jquery.bxslider.css" rel="stylesheet" />
      
      <script src="<?php echo System::getThemeUrl();?>js/custom.js"></script>
      
      <?php echo System::getVar('site_header');?>


            
  </head>

  <body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=<?php if(isset($themeSetting['facebook_app_id']))echo $themeSetting['facebook_app_id'];?>";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  
<nav class="navbar navbar-default navbar-modern">
  <div class="container-fluid">
  <div class="row">
  <div class="col-lg-10 col-lg-offset-1">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo System::getUrl();?>"><?php if(isset($site_name))echo $site_name;else{echo 'Noblesse CMS';}?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
     
      <ul class="nav navbar-nav navbar-right">
        <?php

        $total=count($linkList);

        $li='';

        if(isset($linkList[0]['id']))
        {
          for ($i=0; $i < $total; $i++) { 
            $li.='<li><a href="'.$linkList[$i]['urlFormat'].'">'.$linkList[$i]['title'].'</a></li>';
          }
        }

        echo $li;
        ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div>
  </div>

  </div><!-- /.container-fluid -->
</nav>