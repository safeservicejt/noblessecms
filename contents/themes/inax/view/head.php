<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="<?php echo $keywords;?>">
        <meta name="description" content="<?php echo $description;?>">

        <meta name="author" content="Safeservicejt">
        <meta name="url" id="rootUrl" content="<?php echo ROOT_URL;?>">

        <title><?php echo $title;?></title>
        <!-- Bootstrap theme -->
        <link href="<?php echo THEME_URL;?>css/bootstrap.css" rel="stylesheet">

        <link href="<?php echo ROOT_URL;?>bootstrap/css/ecommerce.css" rel="stylesheet">
        <link href="<?php echo THEME_URL;?>css/custom.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script src="<?php echo THEME_URL;?>js/jquery-2.1.1.min.js"></script>
        <script src="<?php echo THEME_URL;?>js/jquery-2.1.1.min.map"></script>

        <!-- Jquery Session -->
        <script src="<?php echo ROOT_URL;?>bootstrap/js/jquery.session.js"></script>

        <!-- bxSlider Javascript file -->
        <script src="<?php echo THEME_URL;?>js/jquery.bxslider.min.js"></script>
        <!-- bxSlider CSS file -->
        <link href="<?php echo THEME_URL;?>css/jquery.bxslider.css" rel="stylesheet" />


        <script src="<?php echo THEME_URL;?>js/custom.js"></script>
        

    </head>
    <body>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo ROOT_URL;?>">Home</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
                                   <li><a href="<?php echo ROOT_URL;?>shop">Shop</a></li>
                                   
                                   <li><a href="<?php echo ROOT_URL;?>contactus">Contact us</a></li>
                                      <li><a href="<?php echo Url::cart();?>">Giỏ hàng</a></li>
                                    <li><a href="<?php echo Url::checkout();?>">Thanh toán</a></li>
                                    <li><a href="<?php echo Url::login();?>">Đăng nhập</a></li>
                                    <li><a href="<?php echo Url::register();?>">Đăng ký tài khoản</a></li>                                 
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <!-- <li><a href="#onTop" title="Go to top"><span class="glyphicon glyphicon-hand-up"></span></a></li> -->
         <li><a id="gotoTop" title="Go to top"><span class="glyphicon glyphicon-hand-up"></span></a></li>

      </ul>
    </div><!-- /.navbar-collapse -->

  </div><!-- /.container-fluid -->
</nav>

        <div class="container">
            <div class="row">
                <!-- Logo -->
                <div class="col-lg-5" id="onTop">
                    <a href="<?php echo ROOT_URL;?>" ><img src="<?php echo Url::bannerImg();?>" class="img-responsive img-logo" /></a>
                </div>
                <!-- Right -->
                <div class="col-lg-7">
                    <!-- Search bar -->
                    <div class="row">


                        <div class="col-lg-5 pull-right">
                                <form action="<?php ROOT_URL;?>search" method="post" enctype="multipart/form-data">
                                <div class="input-group ">
                                <input type="text" class="form-control" name="txtKeywords" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" name="btnSearch" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                </span>
                                </div><!-- /input-group -->
                                </form>
                            </div>
                        <!-- cart -->
                        <div class="col-lg-7 pull-right">
                        <div id="theCartData" class="pull-right"></div>
                        </div>
                        <!-- cart -->

                        </div>
                        <!-- Links -->
                        <div class="row">
                            <div class="col-lg-12">


                                <ul class="mainLinks pull-right">
                                    <li><a href="<?php echo ROOT_URL;?>">Home</a></li>
                                    <?php if(Users::isLogined()){ ?>
                                    <li><a href="<?php echo Url::account();?>">My account</a></li>
                                    <?php } ?>

                                    <li><a href="<?php echo Url::cart();?>">Shopping cart</a></li>
                                    <li><a href="<?php echo Url::checkout();?>">Checkout</a></li>

                                    <?php if(!Users::isLogined()){ ?>
                                    <li><a href="<?php echo Url::login();?>">Login</a></li>
                                    <li><a href="<?php echo Url::register();?>">Register an account</a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Content -->
                <div class="row">

                    <div class="col-lg-12">

             
                        <!-- Menu -->
                        <div class="row">
                            <div class="col-lg-12 divMenuTop">
                                <ul class="topCategories">
                                    <li><a href="<?php echo ROOT_URL;?>">Home</a></li>
                                   <li><a href="<?php echo Url::get('page/4-Aboutus.html');?>">About us</a></li>
                                   <li><a href="<?php echo ROOT_URL;?>news">Post</a></li>
                                   <li><a href="<?php echo ROOT_URL;?>shop">Shop</a></li>
                                   <li><a href="<?php echo ROOT_URL;?>contactus">Contact us</a></li>

                                </ul>
                            </div>
                        </div>
                                            <!-- Notify -->
                            <div id="cmsnotify">
                              <div class="alert alert-warning">Notify</div>
                            </div>
                            <!-- Notify --> 