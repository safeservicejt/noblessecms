
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
                <a class="navbar-brand" href="<?php echo System::getUrl();?>" target="_blank">Home</a>

            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-left hidden-xs top-nav">

              <?php if(!System::issetVar('admincp_navbar_hide_addnew')){ ?>
               <li class="dropdown navbar-default-system">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Add new <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="<?php echo System::getAdminUrl();?>categories">Category</a></li>
                 <li><a href="<?php echo System::getAdminUrl();?>pages/addnew">Page</a></li>
                 <li><a href="<?php echo System::getAdminUrl();?>post/addnew">Post</a></li>
                 <li><a href="<?php echo System::getAdminUrl();?>links/addnew">Links</a></li>
                 <li><a href="#" data-toggle="modal" data-target="#mediaModal" class="show_medial_modal">Media</a></li>
              
                </ul>
              </li>
              <?php } ?>

              
            </ul>


            <!-- Top Menu Items -->
            <ul class="nav navbar-right hidden-xs top-nav">

                <?php if(!System::issetVar('admincp_navbar_hide_contact')){ ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <?php

                        $total=0;

                        $today=date('Y-m-d');

                        $loadData=Contactus::get(array(
                          'limitShow'=>5,
                          'cacheTime'=>30,
                          'where'=>"where DATE(date_added)='$today'",
                          'orderby'=>'order by id desc'
                          ));

                        if(isset($loadData[0]['id']))
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
                            <a href="<?php echo System::getAdminUrl();?>contacts">Read All New Messages</a>
                        </li>
                    </ul>
                    <span class="badge notify-badge"><?php echo $total;?></span>
                </li>  
                <?php } ?>              
    
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo Cookie::get('username');?> <b class="caret"></b></a>
                    <ul class="dropdown-menu" style="min-width:180px;">
                        <li>
                            <a href="<?php echo System::getAdminUrl();?>users/profile"><i class="glyphicon glyphicon-cog"></i>  Profile</a>
                        </li>
                        <li>
                            <a href="<?php echo System::getAdminUrl();?>users/profile"><i class="glyphicon glyphicon-cog"></i>  Change Password</a>
                        </li>
                        <li>
                            <a href="<?php echo System::getAdminUrl();?>logout"><i class="fa fa-fw fa-power-off"></i> Logout</a>
                        </li>

                    </ul>
                </li>
            </ul>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">

                    <?php if(!System::issetVar('admincp_left_hide_all')){ ?>

                    <?php if(System::issetVar('before_left_dashboard')){ echo System::getVar('before_left_dashboard');} ?>

                    <?php if(!System::issetVar('admincp_left_hide_dashboard')){ ?>
                    <li class="li-dashboard">
                        <a href="<?php echo System::getAdminUrl();?>"><span class="glyphicon glyphicon-globe"></span> Dashboard</a></a>
                    </li>
                    <?php } ?>

                    <?php if(System::issetVar('before_left_dashboard')){ echo System::getVar('before_left_category_manager');} ?>                    
                    <?php $valid=Usergroups::getPermission(Users::getCookieGroupId(),'show_category_manager'); $valid=System::issetVar('admincp_left_hide_category')?'yes':$valid; if($valid=='yes'){ ?>
                     
                        <li class="li-categories">
                            <a href="<?php echo System::getAdminUrl();?>categories"><span class="glyphicon glyphicon-list-alt"></span> Categories</a>
                        </li>
                       
                    <?php } ?>

                    <?php if(System::issetVar('before_left_dashboard')){ echo System::getVar('before_left_post_manager');} ?>

                    <?php $valid=Usergroups::getPermission(Users::getCookieGroupId(),'show_post_manager'); $valid=System::issetVar('admincp_left_hide_post')?'yes':$valid; if($valid=='yes'){ ?>
                     
                        <li class="li-post">
                            <a href="javascript:;" data-toggle="collapse" data-target="#post"><span class="glyphicon glyphicon-file"></span> Post <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="post" class="collapse">
                            <li><a href="<?php echo System::getAdminUrl();?>post">List post</a></li>
                             <li><a href="<?php echo System::getAdminUrl();?>post/status/pending">Pending</a></li>

                          <li><a href="<?php echo System::getAdminUrl();?>post/addnew">Add new</a></li>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if(System::issetVar('before_left_dashboard')){ echo System::getVar('before_left_page_manager');} ?>

                    <?php $valid=Usergroups::getPermission(Users::getCookieGroupId(),'show_page_manager'); $valid=System::issetVar('admincp_left_hide_page')?'yes':$valid; if($valid=='yes'){ ?>
                        <li class="li-pages">
                            <a href="javascript:;" data-toggle="collapse" data-target="#page"><span class="glyphicon glyphicon-th-large"></span> Page <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="page" class="collapse">
                             <li><a href="<?php echo System::getAdminUrl();?>pages">List page</a></li>
                             <li><a href="<?php echo System::getAdminUrl();?>pages/addnew">Add new</a></li>

                            </ul>
                        </li>
                    <?php } ?>

                    <?php if(System::issetVar('before_left_dashboard')){ echo System::getVar('before_left_link_manager');} ?>

                    <?php $valid=Usergroups::getPermission(Users::getCookieGroupId(),'show_link_manager'); $valid=System::issetVar('admincp_left_hide_link')?'yes':$valid; if($valid=='yes'){ ?>
                        <li class="li-links">
                            <a href="javascript:;" data-toggle="collapse" data-target="#links"><span class="glyphicon glyphicon-link"></span> Links <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="links" class="collapse">
                             <li><a href="<?php echo System::getAdminUrl();?>links">List links</a></li>
                             <li><a href="<?php echo System::getAdminUrl();?>redirects">Redirects</a></li>

                            </ul>
                        </li>
                    <?php } ?>

                    <?php if(System::issetVar('before_left_dashboard')){ echo System::getVar('before_left_user_manager');} ?>

                    <?php $valid=Usergroups::getPermission(Users::getCookieGroupId(),'show_user_manager'); $valid=System::issetVar('admincp_left_hide_user')?'yes':$valid; if($valid=='yes'){ ?>
                        <li class="li-users">
                            <a href="javascript:;" data-toggle="collapse" data-target="#users"><span class="glyphicon glyphicon-user"></span> Users <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="users" class="collapse">
                             <li><a href="<?php echo System::getAdminUrl();?>users">List users</a></li>
                             <li><a href="<?php echo System::getAdminUrl();?>users/addnew">Add new</a></li>

                            </ul>
                        </li>
                    <?php } ?>

                    <?php if(System::issetVar('before_left_dashboard')){ echo System::getVar('before_left_usergroup_manager');} ?>

                    <?php $valid=Usergroups::getPermission(Users::getCookieGroupId(),'show_usergroup_manager'); $valid=System::issetVar('admincp_left_hide_usergroup')?'yes':$valid; if($valid=='yes'){ ?>
                        <li class="li-usergroups">
                            <a href="javascript:;" data-toggle="collapse" data-target="#usergroup"><span class="glyphicon glyphicon-user"></span> User Groups <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="usergroup" class="collapse">
                             <li><a href="<?php echo System::getAdminUrl();?>usergroups">List groups</a></li>
                             <li><a href="<?php echo System::getAdminUrl();?>usergroups/addnew">Add new</a></li>

                            </ul>
                        </li>
                    <?php } ?>

                    <?php if(System::issetVar('before_left_dashboard')){ echo System::getVar('before_left_contact_manager');} ?>

                    <?php $valid=Usergroups::getPermission(Users::getCookieGroupId(),'show_contact_manager'); $valid=System::issetVar('admincp_left_hide_contact')?'yes':$valid; if($valid=='yes'){ ?>
                        <li class="li-contact">
                            <a href="<?php echo System::getAdminUrl();?>contacts"><span class="glyphicon glyphicon-comment"></span> Contacts</a>
                        </li>
                    <?php } ?>

                    <?php if(System::issetVar('before_left_dashboard')){ echo System::getVar('before_left_theme_manager');} ?>

                    <?php $valid=Usergroups::getPermission(Users::getCookieGroupId(),'show_theme_manager'); $valid=System::issetVar('admincp_left_hide_theme')?'yes':$valid; if($valid=='yes'){ ?>                
                        <li class="li-theme">
                            <a href="javascript:;" data-toggle="collapse" data-target="#appearance"><span class="glyphicon glyphicon-th"></span> Appearance <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="appearance" class="collapse">
                              <li><a href="<?php echo System::getAdminUrl();?>theme">Theme</a></li>
                              <!-- <li><a href="<?php echo System::getAdminUrl();?>widgets">Widgets</a></li> -->
                              <li><a href="<?php echo System::getAdminUrl();?>theme/import">Import</a></li>  
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if(System::issetVar('before_left_dashboard')){ echo System::getVar('before_left_plugin_manager');} ?>

                    <?php $valid=Usergroups::getPermission(Users::getCookieGroupId(),'show_plugin_manager'); $valid=System::issetVar('admincp_left_hide_plugin')?'yes':$valid; if($valid=='yes'){ ?>
                         <li class="li-plugins">
                            <a href="javascript:;" data-toggle="collapse" data-target="#plugins"><span class="glyphicon glyphicon-wrench"></span> Plugins <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="plugins" class="collapse">
                                <li><a href="<?php echo System::getAdminUrl();?>plugins">List Plugins</a></li>
                                <li><a href="<?php echo System::getAdminUrl();?>plugins/import">Import</a></li>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if(System::issetVar('before_left_dashboard')){ echo System::getVar('before_left_setting');} ?>

                    <?php $valid=Usergroups::getPermission(Users::getCookieGroupId(),'show_setting_manager'); $valid=System::issetVar('admincp_left_hide_setting')?'yes':$valid; if($valid=='yes'){ ?>
                           <li class="li-setting">
                            <a href="javascript:;" data-toggle="collapse" data-target="#setting"><span class="glyphicon glyphicon-cog"></span> Setting <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="setting" class="collapse">
                                  <li><a href="<?php echo System::getAdminUrl();?>setting">General</a></li>

                                  <li><a href="<?php echo System::getAdminUrl();?>setting/mailsystem">Mail System</a></li>

                            </ul>
                        </li>
                    <li class="li-dashboard">
                        <a href="<?php echo System::getAdminUrl();?>logs"><span class="glyphicon glyphicon-envelope"></span> Logs</a></a>
                    </li>                        
                    <?php } ?>



                    <?php $valid=Usergroups::getPermission(Users::getCookieGroupId(),'show_setting_manager'); $valid=System::issetVar('admincp_left_hide_plugin')?'yes':$valid; if($valid=='yes'){ ?>

                        <?php //Render::cpanel_menu('admincp_menu');?>

                    <?php } ?>

                    <?php } ?>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">    
          <div class="container-fluid">            

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">          