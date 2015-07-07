<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="<?php echo System::getKeywords();?>">
    <meta name="description" content="<?php echo System::getDescriptions();?>">
    <link rel="shortcut icon" href="<?php echo ROOT_URL;?>bootstrap/favicon.ico">
    <meta name="author" content="Safeservicejt">
    <meta name="url" id="rootUrl" content="<?php echo ROOT_URL;?>">

    <title><?php echo System::getTitle();?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo System::getThemeUrl();?>css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="<?php echo System::getThemeUrl();?>css/flat-theme.css" rel="stylesheet">
      <link href="<?php echo System::getThemeUrl();?>css/custom.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

      <script src="<?php echo System::getThemeUrl();?>js/jquery-1.11.1.min.js"></script>
           <script src="<?php echo System::getThemeUrl();?>js/jquery-1.11.1.min.map"></script>
           <script src="<?php echo ROOT_URL;?>bootstrap/js/system.js"></script>

  </head>

  <body>




    <div class="container">

        <div class="row" style="margin-top:15px;">

            <!--Logo-->

            <div class="col-md-12">
                <a href="<?php echo System::getUrl();?>"><img src="<?php echo System::getThemeUrl();?>images/logo.png" class="img-responsive" /></a>
            </div>

            <!--Menu-->

            <div class="col-md-12" style="background-color:#3399fe;margin-top:15px;">
                <div class="row">
                    <div class="col-md-8">
                        <ul class="main_menu">
                            <li><a href="<?php echo System::getUrl();?>">Home</a></li>
                            <?php

                            $listCat=Categories::get(array(
                              'limitShow'=>6,
                              'orderby'=>'order by title asc',
                              'cacheTime'=>120
                              ));

                            if(isset($listCat[0]['catid']))
                            {
                              $total=count($listCat);

                              $li='';

                              for ($i=0; $i < $total; $i++) { 
                                $li.='<li><a href="'.$listCat[$i]['url'].'">'.$listCat[$i]['title'].'</a></li>';
                              }

                              echo $li;
                            }

                            ?>

                            <li><a href="<?php echo System::getUrl();?>contactus">Contact Us</a></li>

                        </ul>
                    </div>

                    <div class="col-md-4" style="padding:7px 20px 5px 0px;">
                    <form action="<?php echo System::getUrl();?>search" method="post" enctype="multipart/form-data">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" placeholder="Search..." required>
                          <span class="input-group-btn">
                            <button class="btn btn-success" name="btnSearch" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                          </span>
                        </div><!-- /input-group -->
                    </form>
                    </div>
                </div>

            </div>

            <!--Content-->

            <div class="col-md-12" style="margin-top:15px;">