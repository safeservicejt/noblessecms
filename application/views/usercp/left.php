  <div class="container-fluid">
      <div class="row rowContainer">


      <!-- Content -->
        <div class="col-lg-12 colRight">

        <!-- Left -->
        <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12 colLeft hidden-xs">
          <ul class="ulLeft">
          <li><a href="<?php echo USERCP_URL;?>"><span class="glyphicon glyphicon-globe"></span> Dashboard</a>
        
          </li>
          <?php if(GlobalCMS::ecommerce()==true){ ?>
           <li><a href="#"><span class="glyphicon glyphicon-shopping-cart"></span> Ecommerce</a>
          <ul>
          <li>

          <?php if(UserGroups::enable('can_manage_own_product')==true){ ?>  
          <li><a href="<?php echo USERCP_URL;?>products">Product</a></li>
           <?php } ?>   
         <li><a href="<?php echo USERCP_URL;?>orders">Orders History</a>
         <li><a href="<?php echo USERCP_URL;?>users/paymentinfo">Payment Information</a>
         <li><a href="<?php echo USERCP_URL;?>users/affiliate">Affiliate Information</a>
        <li><a href="<?php echo USERCP_URL;?>users/paymenthistory">Payment History</a>

          </ul>
          </li>
          <?php } ?>

          <?php if(UserGroups::enable('can_manage_category')==true){ ?>  
          <li><a href="<?php echo USERCP_URL;?>categories"><span class="glyphicon glyphicon-list-alt"></span> Categories</a>
            <?php } ?>

          </li>
           <?php if(UserGroups::enable('can_manage_post')==true){ ?>         
                <li><a href="<?php echo USERCP_URL;?>news"><span class="glyphicon glyphicon-file"></span> Post</a>
          <ul>
          <li><a href="<?php echo USERCP_URL;?>news/addnew">Add new</a>
          <?php if(UserGroups::enable('can_manage_comment')==true){ ?>
              <li><a href="<?php echo USERCP_URL;?>comments">Comments</a></li>
              <?php } ?>

          </ul>
          </li>
          <?php } ?>

          <?php if(UserGroups::enable('can_manage_page')==true){ ?>  
              <li><a href="<?php echo USERCP_URL;?>pages"><span class="glyphicon glyphicon-th-large"></span> Page</a>
          <ul>

          <li><a href="<?php echo USERCP_URL;?>pages/addnew">Add new</a></li>

          </ul>
          </li>

           <?php } ?>
              <li><a href="#"><span class="glyphicon glyphicon-user"></span> User</a>
          <ul>

          <li><a href="<?php echo USERCP_URL;?>users/profile">Profile</a></li>
          <li><a href="<?php echo USERCP_URL;?>users/password">Change Password</a></li>

          </ul>
          </li>
              <!-- Admin left menu plugins -->
              <?php
              $menu=Render::adminMenu('usercp_left_menu');

              $total=count($menu);

              $li='';
              
              $text='';

              if($total > 0)
              {
                for($i=0;$i<$total;$i++)
                {
                    $text=$menu[$i]['text'];

                    if(isset($text[1]))
                    $li.='<li><a href="'.USERCP_URL.'plugins/run/'.base64_encode($menu[$i]['filename']).'/'.$menu[$i]['foldername'].'"><span class="glyphicon glyphicon-list"></span> '.$menu[$i]['text'].'</a></li>';
                }

                echo $li;              
              }

              ?>         
               <!-- Admin left menu plugins -->


          </ul>    
        </div>
        <!-- End Menu -->