
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
					  <?php echo $alert;?>
					  	<div class="row">
					  		<div class="col-lg-12 ">
					  		
							    <p>
							    	<strong>Firstname:</strong>
							    </p>
							    <p>
							    	<input type="text" class="form-control" placeholder="Firstname..." name="send[firstname]" id="txtUsername" required />
							    </p>
							    <p>
							    	<strong>Lastname:</strong>
							    </p>
							    <p>
							    	<input type="text" class="form-control" placeholder="Lastname..." name="send[lastname]" id="txtUsername" required />
							    </p>
							    <p>
							    	<strong>Email:</strong>
							    </p>
							    <p>
							    	<input type="email" class="form-control" placeholder="Email..." name="send[email]" id="txtUsername" required />
							    </p>
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
							    	<input type="password" class="form-control" placeholder="Password..." name="send[password]" id="txtUsername" required />
							    </p>
							    <p>
							    	<strong>Confirm Password:</strong>
							    </p>
							    <p>
							    	<input type="password" class="form-control" placeholder="Confirm Password..." name="send[repassword]" id="txtUsername" required />
							    </p>

							    <?php echo $captchaHTML;?>	

					  		</div>

					  	</div>

					  	<div class="row">
					  		<div class="col-lg-12">
							    <p>
							    	<button type="submit" class="btn btn-danger" name="btnRegister">Register</button>

							    	<a href="<?php echo System::getAdminUrl();?>" class="btn btn-default pull-right">Back to login</a>
							    </p>					  			
					  		</div>
					  	</div>



					  </div>
					</div>	
					<!-- panel -->
	    		</div>
	    	</div>
	    	<!-- row -->


	    	</div>    		
    	</div>

    </div>
    </form>