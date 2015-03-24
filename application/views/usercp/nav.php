
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
      <a class="navbar-brand" href="<?php echo USERCP_URL;?>"><img class="img_logo" src="<?php echo ROOT_URL;?>bootstrap/images/logo24.png" /></a>

    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
         <li><a href="<?php echo ROOT_URL;?>" target="_blank" title="Go to homepage"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Homepage</a></li>
     
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Add new <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo USERCP_URL;?>categories">Category</a></li>
           <li><a href="<?php echo USERCP_URL;?>pages/addnew">Page</a></li>
           <li><a href="<?php echo USERCP_URL;?>news/addnew">Post</a></li>

          </ul>
        </li>
        <?php if(GlobalCMS::ecommerce()==true){ ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Ecommerce <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo USERCP_URL;?>products/addnew">Add new product</a></li>

          </ul>
        </li>
          <?php } ?>
         <!-- Admin nav menu plugins -->
        <?php
        $menu=Render::adminMenu('usercp_nav_menu');

        $total=count($menu);

        if($total > 0 && isset($menu[0]['foldername']))
        {
          ?>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;&nbsp;Addons <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">

        <?php
        
        $li='';

        $text='';


        for($i=0;$i<$total;$i++)
        {
          $li.='<li><a href="'.USERCP_URL.'plugins/run/'.base64_encode($menu[$i]['filename']).'/'.$menu[$i]['foldername'].'">'.$menu[$i]['text'].'</a></li>';
        }

        echo $li;

        ?>         
          </ul>
        </li>
          <?php
        }

        ?>         
         <!-- Admin nav menu plugins -->       
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Cookie::get('email');?> <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo USERCP_URL;?>logout">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>