  <div class="container-fluid">
      <div class="row rowContainer">


      <!-- Content -->
        <div class="col-lg-12 colRight">

        <!-- Left -->
        <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12 colLeft hidden-xs">
          <ul class="ulLeft">
          <li><a href="<?php echo ADMINCP_URL;?>"><span class="glyphicon glyphicon-globe"></span> Dashboard</a></li>

          </li>
          <?php if(GlobalCMS::ecommerce()==true){ ?>
           <li><a href="<?php echo ADMINCP_URL;?>ecommerce"><span class="glyphicon glyphicon-shopping-cart"></span> Ecommerce</a>
          <ul>
          <li><a href="<?php echo ADMINCP_URL;?>products">Product</a></li>
         <li><a href="<?php echo ADMINCP_URL;?>manufacturers">Manufacturers</a></li>
          <li><a href="<?php echo ADMINCP_URL;?>downloads">Downloads</a></li>
            <li><a href="<?php echo ADMINCP_URL;?>reviews">Reviews</a></li>
         <li><a href="<?php echo ADMINCP_URL;?>paymentmethods">Payment Methods</a></li>
         <li><a href="<?php echo ADMINCP_URL;?>requestpayment">Request Payments</a> </li>        
         <!-- <li><a href="<?php echo ADMINCP_URL;?>admincp/taxclass">Tax Class</a></li> -->
         <li><a href="<?php echo ADMINCP_URL;?>orders">Orders</a></li>
         <li><a href="<?php echo ADMINCP_URL;?>affiliates">Affiliates</a></li>
         <li><a href="<?php echo ADMINCP_URL;?>giftvouchers">Gift Vouchers</a></li>
         <li><a href="<?php echo ADMINCP_URL;?>coupons">Coupons</a></li>
         <li><a href="<?php echo ADMINCP_URL;?>taxrate">Tax Rate</a></li>
         <li><a href="<?php echo ADMINCP_URL;?>currency">Currency</a></li>

          </ul>
          </li>
          <?php } ?>

        
              <li><a href="<?php echo ADMINCP_URL;?>categories"><span class="glyphicon glyphicon-list-alt"></span> Categories</a>
          
          </li>
                <li><a href="<?php echo ADMINCP_URL;?>news"><span class="glyphicon glyphicon-file"></span> Post</a>
          <ul>
          <li><a href="<?php echo ADMINCP_URL;?>news/addnew">Add new</a></li>
              <li><a href="<?php echo ADMINCP_URL;?>comments">Comments</a></li>

          </ul>
          </li>

              <li><a href="<?php echo ADMINCP_URL;?>pages"><span class="glyphicon glyphicon-th-large"></span> Page</a>
          <ul>
          <li><a href="<?php echo ADMINCP_URL;?>pages/addnew">Add new</a></li>

          </ul>
          </li>
                <li><a href="<?php echo ADMINCP_URL;?>users"><span class="glyphicon glyphicon-user"></span> Users</a>
          <ul>
          <li><a href="<?php echo ADMINCP_URL;?>users/addnew">Add new</a></li>
          </ul>
          </li>
                <li><a href="<?php echo ADMINCP_URL;?>usergroups"><span class="glyphicon glyphicon-user"></span> User Groups</a>
          <ul>
          <li><a href="<?php echo ADMINCP_URL;?>usergroups/addnew">Add new</a></li>

          </ul>
          </li>
                <li><a href="<?php echo ADMINCP_URL;?>contactus"><span class="glyphicon glyphicon-comment"></span> Contacts</a>
          
          </li>

              <li><a href="<?php echo ADMINCP_URL;?>theme"><span class="glyphicon glyphicon-th"></span> Appearance</a>
          <ul>

          <li><a href="<?php echo ADMINCP_URL;?>theme">Theme</a></li>
              <li><a href="<?php echo ADMINCP_URL;?>filemanager">File Manager</a>
          <li><a href="<?php echo ADMINCP_URL;?>templatestore">Themes Store</a></li>      
          <li><a href="<?php echo ADMINCP_URL;?>theme/import">Import</a></li>      
              <?php
              $menu=Render::adminMenu('themes_menu');

              $total=count($menu);

              $li='';

              for($i=0;$i<$total;$i++)
              {
                $li.='<li><a href="'.ADMINCP_URL.'plugins/run/'.base64_encode($menu[$i]['filename']).'/'.$menu[$i]['foldername'].'">'.$menu[$i]['text'].'</a></li>';
              }

              echo $li;
              ?>

          </ul>
          </li>
              <li><a href="<?php echo ADMINCP_URL;?>plugins"><span class="glyphicon glyphicon-wrench"></span> Plugins</a>
          <ul>
          <li>
          <li><a href="<?php echo ADMINCP_URL;?>pluginstore">Plugins Store</a></li>
              <li><a href="<?php echo ADMINCP_URL;?>plugins/layouts">Layouts</a></li>
              <li><a href="<?php echo ADMINCP_URL;?>plugins/import">Import</a></li>
              <?php
              $menu=Render::adminMenu('plugins_menu');

              $total=count($menu);

              $li='';

              for($i=0;$i<$total;$i++)
              {
                $li.='<li><a href="'.ADMINCP_URL.'plugins/run/'.base64_encode($menu[$i]['filename']).'/'.$menu[$i]['foldername'].'">'.$menu[$i]['text'].'</a></li>';
              }

              echo $li;
              ?>

          </ul>
          </li>
               
                  <li><a href="<?php echo ADMINCP_URL;?>setting"><span class="glyphicon glyphicon-cog"></span> Setting</a>
          <ul>
          <li><a href="<?php echo ADMINCP_URL;?>setting">General</a></li>

          <li><a href="<?php echo ADMINCP_URL;?>setting/ecommerce">Ecommerce</a></li>
          <li><a href="<?php echo ADMINCP_URL;?>setting/mailsystem">Mail System</a></li>
              <?php
              $menu=Render::adminMenu('setting_menu');

              $total=count($menu);

              $li='';

              for($i=0;$i<$total;$i++)
              {
                $li.='<li><a href="'.ADMINCP_URL.'plugins/run/'.base64_encode($menu[$i]['filename']).'/'.$menu[$i]['foldername'].'">'.$menu[$i]['text'].'</a></li>';
              }

              echo $li;
              ?>

          </ul>
          </li>
          
              <!-- Admin left menu plugins -->
              <?php
              $menu=Render::adminMenu('admin_left_menu');

              $total=count($menu);

              $li='';
              
              $text='';

              if($total > 0)
              {
                for($i=0;$i<$total;$i++)
                {
                    $text=$menu[$i]['text'];

                    if(isset($text[1]))
                    $li.='<li><a href="'.ADMINCP_URL.'plugins/run/'.base64_encode($menu[$i]['filename']).'/'.$menu[$i]['foldername'].'"><span class="glyphicon glyphicon-list"></span> '.$menu[$i]['text'].'</a></li>';
                }

                echo $li;              
              }

              ?>         
               <!-- Admin left menu plugins -->


          </ul>    
        </div>
        <!-- End Menu -->