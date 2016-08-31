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

    <link href="<?php echo System::getUrl();?>bootstrap/css/animate-animo.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/jsupload/css/jquery.fileupload.css">   

    <!-- Custom Fonts -->
    <link href="<?php echo System::getUrl();?>bootstrap/sbnoblesse/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <?php echo System::getImplodeVar('cssGlobal');?>

    <!-- jQuery -->
    <script src="<?php echo System::getUrl();?>bootstrap/js/jquery-2.1.3.min.js"></script>
    <script src="<?php echo System::getUrl();?>bootstrap/js/animo.min.js"></script>
    <script src="<?php echo System::getUrl();?>bootstrap/js/system.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php echo System::getImplodeVar('admincp_header');?>

</head>

<body>

<!-- Modal media -->
<div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Media</h4>
      </div>
      <div class="modal-body">
        <div>
          <!-- Nav tabs -->
          <ul class="nav nav-tabs nav-media-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#addnew_media" aria-controls="addnew_media" role="tab" data-toggle="tab">Upload</a></li>
            <li role="presentation"><a href="#list_media" class="show_media_list" aria-controls="list_media" role="tab" data-toggle="tab">List</a></li>
           
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="addnew_media">
                <!-- file upload -->
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success btn-sm fileinput-button margin-top-20">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Select files...</span>

                    <!-- The file input field used as target for the file upload widget -->
                    <input id="mediaupload" type="file" name="files[]">
                </span>
                <span id="files"></span>
                <br>
                <br>
                <!-- The global progress bar -->
                <div id="mediaupload_progress" class="progress">
                    <div class="progress-bar progress-bar-success"></div>
                </div>                    
                <!-- file upload -->
            </div>

            <div role="tabpanel" class="tab-pane" id="list_media">
                <div class="wrap_list_media">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td class="col-lg-6 col-md-6 col-sm-6 "><strong>Name</strong></td>
                                <td class="col-lg-2 col-md-2 col-sm-2 "><strong>Size</strong></td>
                                <td class="col-lg-3 col-md-3 col-sm-3 "><strong>Date</strong></td>
                                <td class="col-lg-1 col-md-1 col-sm-1 text-right"><strong>#</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
          </div>

        </div>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal media -->


<?php if(!System::issetVar('admincp_navbar_hide_tools')){ ?>
<img src="<?php echo System::getUrl();?>bootstrap/images/addnew.png" class=" img-tools" />
<div class="modal fade" id="modal-tools">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Choose Your Action:</h4>
            </div>
            <div class="modal-body modal-body-tools">
                <!-- row -->
                <div class="row row-tools">
                    <div class="col-lg-2 col-md-2 col-sm-4 text-center">
                        <p>
                            <a href="<?php echo System::getAdminUrl();?>post/addnew"><img src="<?php echo System::getUrl();?>bootstrap/images/tools/post.png" class="img-responsive the-tool" /></a>
                        </p>
                        <a href="<?php echo System::getAdminUrl();?>post/addnew" class="a-the-tool">New Post</a>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4  text-center">
                        <p>
                            <a href="<?php echo System::getAdminUrl();?>categories"><img src="<?php echo System::getUrl();?>bootstrap/images/tools/category.png" class="img-responsive the-tool" /></a>
                        </p>
                        <a href="<?php echo System::getAdminUrl();?>categories" class="a-the-tool">New Category</a>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4  text-center">
                        <p>
                            <a href="<?php echo System::getAdminUrl();?>pages/addnew"><img src="<?php echo System::getUrl();?>bootstrap/images/tools/page.png" class="img-responsive the-tool" /></a>
                        </p>
                        <a href="<?php echo System::getAdminUrl();?>pages/addnew" class="a-the-tool">New Page</a>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4  text-center">
                        <p>
                            <a href="<?php echo System::getAdminUrl();?>links"><img src="<?php echo System::getUrl();?>bootstrap/images/tools/link.png" class="img-responsive the-tool" /></a>
                        </p>
                        <a href="<?php echo System::getAdminUrl();?>links" class="a-the-tool">New Link</a>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4  text-center">
                        <p>
                            <a href="<?php echo System::getAdminUrl();?>setting"><img src="<?php echo System::getUrl();?>bootstrap/images/tools/setting.png" class="img-responsive the-tool" /></a>
                        </p>
                        <a href="<?php echo System::getAdminUrl();?>setting" class="a-the-tool">Settings</a>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4  text-center">
                        <p>
                            <a href="<?php echo System::getAdminUrl();?>theme"><img src="<?php echo System::getUrl();?>bootstrap/images/tools/theme.png" class="img-responsive the-tool" /></a>
                        </p>
                        <a href="<?php echo System::getAdminUrl();?>theme" class="a-the-tool">Theme</a>
                    </div>

                </div>
                <!-- row -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<?php } ?>

<div id="wrapper">