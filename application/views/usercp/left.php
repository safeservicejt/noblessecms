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

              // print_r();die();
              $menu=Render::usercpMenu('usercp_left_menu');

              $total=count($menu);

              $li='';
              
              $text='';

              // print_r($menu);die();

              if($total > 0)
              {
                for($i=0;$i<$total;$i++)
                {
                    $child='';

                    if(isset($menu[$i]['child_menu']))
                    {
                  // print_r($menu[$i]);die();

                      $childData=$menu[$i]['child_menu'];

                      $totalChild=count($childData);

                      for ($j=0; $j < $totalChild; $j++) { 

                        $runFunc='';

                        if(isset($childData[$j]['func']))
                        {
                          $runFunc='func/'.base64_encode($childData[$j]['func']).'/';
                        }

                        $child.='<li><a href="'.USERCP_URL.'plugins/runc/'.base64_encode($childData[$j]['filename']).'/'.$runFunc.$menu[$i]['foldername'].'">'.$childData[$j]['text'].'</a></li>';

                      }

                      $child='<ul>'.$child.'</ul>';

                    }


                    $text=$menu[$i]['text'];

                    if(isset($text[1]))
                    $li.='<li><a href="'.USERCP_URL.'plugins/run/'.base64_encode($menu[$i]['filename']).'/'.$menu[$i]['foldername'].'"><span class="glyphicon glyphicon-list"></span> '.$menu[$i]['text'].'</a>'.$child.'</li>';
                }

                echo $li;              
              }

              ?>         
               <!-- Admin left menu plugins -->


          </ul>    
        </div>
        <!-- End Menu -->