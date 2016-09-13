<!DOCTYPE html>
<html lang="en" xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="<?php echo System::getKeywords();?>">
    <meta name="description" content="<?php echo System::getDescriptions();?>">
    <link rel="shortcut icon" href="<?php echo System::getUrl();?>bootstrap/favicon.ico">
    <meta name="author" content="Safeservicejt">
    <meta name="url" id="root_url" content="<?php echo System::getUrl();?>">

    <meta name="copyright" content="Noblesse CMS" />
    <meta name="robots" content="index,follow" />
    <meta http-equiv="content-language" content="en"/>
    <meta name="revisit-after" content="30 days">
    <meta name="dc.description" content="<?php echo System::getDescriptions();?>">
    <meta name="dc.keywords" content="<?php echo System::getKeywords();?>">
    <meta name="dc.subject" content="<?php echo System::getTitle();?>">
    <meta name="dc.created" content="2016-05-10">
    <meta name="dc.publisher" content="Content Manager System NoblesseCMS">
    <meta name="dc.rights.copyright" content="Noblesse CMS">
    <meta name="dc.creator.name" content="Noblesse CMS">
    <meta name="dc.creator.email" content="freshcodeteam@gmail.com">
    <meta name="dc.identifier" content="<?php echo System::getUrl();?>">
    <meta name="dc.language" content="en-US">

  <meta property="fb:app_id" content="<?php if(isset($themeSetting['facebook_app_id']))echo $themeSetting['facebook_app_id'];?>" />

  <meta property="og:type" content='article' />
  <meta property="og:title" itemprop="headline" name="title" content='<?php echo System::getTitle();?>' />
  <meta property="og:site_name" content='<?php echo System::getTitle();?>' />
  <meta property="og:url" itemprop="url" content='<?php echo System::getUrl().System::getUri();?>' />

  <meta property="og:description" itemprop="description" name="description" content='<?php echo System::getDescriptions();?>' />

  <?php if(isset($postImage)){ ?>
  <meta property="og:image" content="<?php echo $postImage;?>" />  
  <?php } ?>


    <title><?php echo System::getTitle();?></title>

    <link rel="stylesheet" media="screen" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,300italic,300,600,600italic,700,700italic" /> 
<link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'/>
<link href='http://fonts.googleapis.com/css?family=Rokkitt:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'/>

    <!-- Bootstrap theme -->
     <link href="<?php echo System::getThemeUrl();?>css/bootstrap.min.css" rel="stylesheet">
	
     <link href="<?php echo System::getThemeUrl();?>css/custom-core.css" rel="stylesheet">
     <link href="<?php echo System::getThemeUrl();?>css/animate.css" rel="stylesheet">
	   <link href="<?php echo System::getThemeUrl();?>css/custom.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	  <script src="<?php echo System::getThemeUrl();?>js/jquery-2.1.1.min.js"></script>
      <script src="<?php echo System::getThemeUrl();?>js/jquery-2.1.1.min.map"></script>
      <script src="<?php echo System::getThemeUrl();?>js/custom.js"></script>
			
  </head>

  <body>

    <!-- container -->
    <div class="container container-fix margin-top-10 margin-bottom-10">
      <!-- row -->
      <div class="row">
        <div class="col-lg-12 text-center">
          <a href="<?php echo System::getUrl();?>" rel="nofollow" class="site-title"><?php echo System::getVar('siteTitle');?></a>
        </div>
      </div>
      <!-- row -->
      <!-- row -->
      <div class="row row-menu">
        <div class="col-lg-12 text-center">
          <ul>
            <?php

            $total=count($linkList);

            $li='';

            if(isset($linkList[0]['id']))
            {
              for ($i=0; $i < $total; $i++) { 
                $li.='<li><a rel="nofollow" href="'.$linkList[$i]['urlFormat'].'">'.$linkList[$i]['title'].'</a></li>';
              }
            }

            echo $li;
            ?>            
          </ul>
        </div>
      </div>
      <!-- row -->
      <!-- row -->
      <div class="row row-contents margin-top-30">