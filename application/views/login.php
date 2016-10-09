
    <link href="<?php echo System::getUrl();?>bootstraps/sbnoblesse/css/login.css" rel="stylesheet">

    <form action="" method="post" enctype="multipart/form-data">
    <div class="container">
    	<div class="row" style="margin-top:100px;">
	    	<div class="col-lg-8 col-lg-offset-2">


	    	<!-- row -->
	    	<div class="row">
	    		<div class="col-lg-12 text-center">
	    		<?php if(!isset(System::$setting['other_logo_login_page'])){ ?>
	    		<img src="<?php echo System::getUrl();?>bootstraps/sbnoblesse/images/logo3128.png" />
	    		<?php }else{ ?>
	    		<img src="<?php echo System::$setting['other_logo_login_page'];?>" />
	    		<?php } ?>	    			
	    		</div>
	    	</div>
	    	<!-- row -->
	    	<!-- row -->
	    	<div class="row" style="margin-top:10px;">
	    		<div class="col-lg-12">
	    			<!-- panel -->
					<div class="panel panel-default">
					  <div class="panel-body">
					  	<div class="row">
					  		<div class="col-lg-6 col-md-6 col-sm-6 ">
					  		<?php echo $alert;?>
							    <p>
							    	<strong>Username:</strong>
							    </p>
							    <p>
							    	<input type="text" class="form-control" placeholder="Username..." name="send[username]" id="txtUsername" required />
							    </p>
							    <p>
							    	<strong>Password:</strong>
							    </p>
							    <p>
							    	<input type="password" class="form-control" placeholder="Password..." name="send[password]" id="txtPassword" required />
							    </p>					  			
					  		</div>
					  		<div class="col-lg-5 col-lg-offset-1  col-md-5  col-sm-5 " style="padding-top:20px;">
							    <?php echo $captchaHTML;?>				  			
					  		</div>

					  	</div>

					  	<div class="row">
					  		<div class="col-lg-6 col-md-6 col-sm-6 ">
							    <p>
							    	<button type="submit" class="btn btn-primary" name="btnLogin">Login</button>

							    	<?php if(System::$setting['register_user_status']=='enable'){ ?>
							    	<a href="<?php echo System::getUrl();?>npanel/register" class="btn btn-danger pull-right">Register</a>
							    	<?php }else{ ?>
							    	<a href="<?php echo System::getUrl();?>npanel/forgotpassword" class=" pull-right">Forgot password ?</a>
							    	<?php } ?>
							    </p>					  			
					  		</div>
					  	</div>



					  </div>
					</div>	
					<!-- panel -->
					<?php if(System::$setting['register_user_status']=='enable'){ ?>
					<a href="<?php echo System::getUrl();?>npanel/register">Register</a>
					<?php } ?>

	    		</div>
	    	</div>
	    	<!-- row -->


	    	</div>    		
    	</div>

    </div>
    </form>