<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Fast & Secure CMS - Noblesse CMS">
    <meta name="keywords" content="noblessecms, noblesse, php cms, noblesse cms"/>
    <meta name="author" content="Safeservicejt - James">
       
    <meta id="root_url" content="<?php echo System::getUrl();?>">

    <?php if(!isset(System::$setting['admincp_change_favicon'])){ ?>
    <link rel="shortcut icon" href="<?php echo System::getUrl();?>bootstrap/favicon.ico">
    <?php }else{ ?>
    <link rel="shortcut icon" href="<?php echo System::getUrl().System::$setting['admincp_change_favicon'];?>">
    <?php } ?>

    <meta property="og:title" content="<?php echo System::getTitle();?>" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="<?php echo System::getTitle();?>" />
    <meta property="og:description" content="Fast & Secure CMS - Noblesse CMS" />
    <meta property="og:url" content="<?php echo System::getUrl();?>" />
    <meta property="og:image" content="" />

    <title><?php echo System::getTitle();?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo System::getUrl();?>bootstrap/sbnoblesse/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo System::getUrl();?>bootstrap/sbnoblesse/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo System::getUrl();?>bootstrap/sbnoblesse/css/plugins/morris.css" rel="stylesheet">

    <link href="<?php echo System::getUrl();?>bootstrap/sbnoblesse/css/custom.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo System::getUrl();?>bootstrap/sbnoblesse/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <?php echo unserialize(System::getVar('cssGlobal'));?>

    <!-- jQuery -->
    <script src="<?php echo System::getUrl();?>bootstrap/js/jquery-2.1.3.min.js"></script>
    <script src="<?php echo System::getUrl();?>bootstrap/js/system.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php echo System::getVar('admincp_header');?>

</head>

<body>

<div id="wrapper">