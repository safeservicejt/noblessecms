
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo ROOT_URL;?>" target="_blank">Home</a>

            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-left top-nav">
               <li class="dropdown navbar-default-system">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Add new <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="<?php echo ADMINCP_URL;?>categories">Category</a></li>
                 <li><a href="<?php echo ADMINCP_URL;?>pages/addnew">Page</a></li>
                 <li><a href="<?php echo ADMINCP_URL;?>post/addnew">Post</a></li>
                 <li><a href="<?php echo ADMINCP_URL;?>links/addnew">Links</a></li>

                </ul>
              </li>
              

              
            </ul>


            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <?php

                        $today=date('Y-m-d');

                        $loadData=Contactus::get(array(
                          'limitShow'=>5,
                          'cacheTime'=>30,
                          'where'=>"where DATE(date_added)='$today'",
                          'orderby'=>'order by contactid desc'
                          ));

                        if(isset($loadData[0]['contactid']))
                        {
                          $li='';

                          $total=count($loadData);

                          for ($i=0; $i < $total; $i++) { 
                            $li.='
                            <li class="message-preview">
                                <a href="'.$loadData[$i]['url'].'">
                                    <div class="media">
                                        
                                        <div class="media-body">
                                            <h5 class="media-heading"><strong>'.$loadData[$i]['fullname'].'</strong>
                                            </h5>
                                            <p class="small text-muted"><i class="fa fa-clock-o"></i> '.$loadData[$i]['date_addedFormat'].'</p>
                                            <p>'.substr($loadData[$i]['content'], 0,50).'...</p>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            ';
                          }

                          
                        }
                        else
                        {
                          $li='
                            <li class="message-preview">
                                <a href="#">
                                    <div class="media">
                                        
                                        <div class="media-body">
                                            <h5 class="media-heading"><strong>There is not have any new contact(s)</strong>
                                            </h5>
                                        </div>
                                    </div>
                                </a>
                            </li>

                          ';
                        }

                        echo $li;
                        
                        ?>


                        
                        <li class="message-footer">
                            <a href="<?php echo ADMINCP_URL;?>contacts">Read All New Messages</a>
                        </li>
                    </ul>
                </li>                
    
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo Cookie::get('firstname').' '.Cookie::get('lastname');?> <b class="caret"></b></a>
                    <ul class="dropdown-menu" style="min-width:180px;">
                        <li>
                            <a href="<?php echo ADMINCP_URL;?>users/profile"><i class="glyphicon glyphicon-cog"></i> Profile</a>
                        </li>
                        <li>
                            <a href="<?php echo ADMINCP_URL;?>users/profile"><i class="glyphicon glyphicon-cog"></i> Change Password</a>
                        </li>
                        <li>
                            <a href="<?php echo ADMINCP_URL;?>logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>

                    </ul>
                </li>
            </ul>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="li-dashboard">
                        <a href="<?php echo ADMINCP_URL;?>"><span class="glyphicon glyphicon-globe"></span> Dashboard</a></a>
                    </li>
                   <!--  <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#ecommerce"><span class="glyphicon glyphicon-shopping-cart"></span> Ecommerce <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="ecommerce" class="collapse">
                          <li><a href="<?php echo ADMINCP_URL;?>ecommerce">Statistics</a></li> -->
                          <!-- <li><a href="<?php echo ADMINCP_URL;?>affiliates">Affiliates</a></li> -->
                          <!-- <li><a href="<?php echo ADMINCP_URL;?>coupons">Coupons</a></li>
                          <li><a href="<?php echo ADMINCP_URL;?>currency">Currency</a></li>
                          <li><a href="<?php echo ADMINCP_URL;?>downloads">Downloads</a></li>
                          <li><a href="<?php echo ADMINCP_URL;?>vouchers">Gift Vouchers</a></li>
                         <li><a href="<?php echo ADMINCP_URL;?>manufacturers">Manufacturers</a></li>
                           <li><a href="<?php echo ADMINCP_URL;?>products">Product</a></li>
                           <li><a href="<?php echo ADMINCP_URL;?>paymentmethods">Payment Methods</a></li>
                            <li><a href="<?php echo ADMINCP_URL;?>reviews">Reviews</a></li> -->
                         <!-- <li><a href="<?php echo ADMINCP_URL;?>requestpayment">Request Payments</a> </li>        -->
                        <!--  <li><a href="<?php echo ADMINCP_URL;?>orders">Orders</a></li>
                         <li><a href="<?php echo ADMINCP_URL;?>taxrate">Tax Rate</a></li>
                         

                        </ul>
                    </li>  -->                   
                    <li class="li-categories">
                        <a href="<?php echo ADMINCP_URL;?>categories"><span class="glyphicon glyphicon-list-alt"></span> Categories</a>
                    </li>

                    <li class="li-post">
                        <a href="javascript:;" data-toggle="collapse" data-target="#post"><span class="glyphicon glyphicon-file"></span> Post <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="post" class="collapse">
                        <li><a href="<?php echo ADMINCP_URL;?>post">List post</a></li>
                         <li><a href="<?php echo ADMINCP_URL;?>post/status/pending">Pending</a></li>

                      <li><a href="<?php echo ADMINCP_URL;?>post/addnew">Add new</a></li>
                          <li><a href="<?php echo ADMINCP_URL;?>comments">Comments</a></li>

                        </ul>
                    </li>
                    <li class="li-pages">
                        <a href="javascript:;" data-toggle="collapse" data-target="#page"><span class="glyphicon glyphicon-th-large"></span> Page <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="page" class="collapse">
                         <li><a href="<?php echo ADMINCP_URL;?>pages">List page</a></li>
                         <li><a href="<?php echo ADMINCP_URL;?>pages/addnew">Add new</a></li>

                        </ul>
                    </li>
                    <li class="li-links">
                        <a href="javascript:;" data-toggle="collapse" data-target="#links"><span class="glyphicon glyphicon-link"></span> Links <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="links" class="collapse">
                         <li><a href="<?php echo ADMINCP_URL;?>links">List links</a></li>

                        </ul>
                    </li>

                    <li class="li-users">
                        <a href="javascript:;" data-toggle="collapse" data-target="#users"><span class="glyphicon glyphicon-user"></span> Users <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="users" class="collapse">
                         <li><a href="<?php echo ADMINCP_URL;?>users">List users</a></li>
                         <li><a href="<?php echo ADMINCP_URL;?>users/addnew">Add new</a></li>

                        </ul>
                    </li>
                    <li class="li-usergroups">
                        <a href="javascript:;" data-toggle="collapse" data-target="#usergroup"><span class="glyphicon glyphicon-user"></span> User Groups <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="usergroup" class="collapse">
                         <li><a href="<?php echo ADMINCP_URL;?>usergroups">List groups</a></li>
                         <li><a href="<?php echo ADMINCP_URL;?>usergroups/addnew">Add new</a></li>

                        </ul>
                    </li>


                    <li class="li-contact">
                        <a href="<?php echo ADMINCP_URL;?>contacts"><span class="glyphicon glyphicon-comment"></span> Contacts</a>
                    </li>
                    <li class="li-theme">
                        <a href="javascript:;" data-toggle="collapse" data-target="#appearance"><span class="glyphicon glyphicon-th"></span> Appearance <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="appearance" class="collapse">
                          <li><a href="<?php echo ADMINCP_URL;?>theme">Theme</a></li>
                          <!-- <li><a href="<?php echo ADMINCP_URL;?>widgets">Widgets</a></li> -->
                              <li><a href="<?php echo ADMINCP_URL;?>theme/filemanager">File Manager</a>
                          <li><a href="<?php echo ADMINCP_URL;?>templatestore">Templates Store</a></li>      
                          <li><a href="<?php echo ADMINCP_URL;?>theme/import">Import</a></li>  
                        </ul>
                    </li>
                     <li class="li-plugins">
                        <a href="javascript:;" data-toggle="collapse" data-target="#plugins"><span class="glyphicon glyphicon-wrench"></span> Plugins <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="plugins" class="collapse">
                            <li><a href="<?php echo ADMINCP_URL;?>plugins">List Plugins</a></li>
                            <li><a href="<?php echo ADMINCP_URL;?>pluginstore">Plugins Store</a></li>
                            <li><a href="<?php echo ADMINCP_URL;?>plugins/import">Import</a></li>
                        </ul>
                    </li>

                       <li class="li-setting">
                        <a href="javascript:;" data-toggle="collapse" data-target="#setting"><span class="glyphicon glyphicon-cog"></span> Setting <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="setting" class="collapse">
                              <li><a href="<?php echo ADMINCP_URL;?>setting">General</a></li>

                              <!-- <li><a href="<?php echo ADMINCP_URL;?>setting/ecommerce">Ecommerce</a></li> -->
                              <li><a href="<?php echo ADMINCP_URL;?>setting/mailsystem">Mail System</a></li>
                              <li><a href="<?php echo ADMINCP_URL;?>setting/update">Update</a></li>

                        </ul>
                    </li>

                    <?php Render::cpanel_menu('admincp_menu');?>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">    
          <div class="container-fluid">            

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">          