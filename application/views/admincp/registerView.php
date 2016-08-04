
    <link href="<?php echo System::getUrl();?>bootstrap/sbnoblesse/css/login.css" rel="stylesheet">

    <form action="" method="post" enctype="multipart/form-data">
    <div class="container">
    	<div class="row" style="margin-top:100px;">
	    	<div class="col-lg-8 col-lg-offset-2">


	    	<!-- row -->
	    	<div class="row">
	    		<div class="col-lg-12 text-center">
	    		<?php if(!isset(System::$setting['other_logo_login_page'])){ ?>
	    		<img src="<?php echo System::getUrl();?>bootstrap/sbnoblesse/images/logo3128.png" />
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
							    	<strong><?php echo Lang::get('cmsadmin.firstName');?>:</strong>
							    </p>
							    <p>
							    	<input type="text" class="form-control" placeholder="<?php echo Lang::get('cmsadmin.firstName');?>..." name="send[firstName]" id="txtUsername" required />
							    </p>
							    <p>
							    	<strong><?php echo Lang::get('cmsadmin.lastName');?>:</strong>
							    </p>
							    <p>
							    	<input type="text" class="form-control" placeholder="<?php echo Lang::get('cmsadmin.lastName');?>..." name="send[lastName]" id="txtUsername" required />
							    </p>
							    <p>
							    	<strong><?php echo Lang::get('cmsadmin.email');?>:</strong>
							    </p>
							    <p>
							    	<input type="email" class="form-control" placeholder="<?php echo Lang::get('cmsadmin.email');?>..." name="send[email]" id="txtUsername" required />
							    </p>
							    <p>
							    	<strong><?php echo Lang::get('cmsadmin.username');?>:</strong>
							    </p>
							    <p>
							    	<input type="text" class="form-control" placeholder="<?php echo Lang::get('cmsadmin.username');?>..." name="send[username]" id="txtUsername" required />
							    </p>
							    <p>
							    	<strong><?php echo Lang::get('cmsadmin.password');?>:</strong>
							    </p>
							    <p>
							    	<input type="password" class="form-control" placeholder="<?php echo Lang::get('cmsadmin.password');?>..." name="send[password]" id="txtUsername" required />
							    </p>
							    <p>
							    	<strong><?php echo Lang::get('cmsadmin.confirmPassword');?>:</strong>
							    </p>
							    <p>
							    	<input type="password" class="form-control" placeholder="<?php echo Lang::get('cmsadmin.confirmPassword');?>..." name="send[repassword]" id="txtUsername" required />
							    </p>

							    <?php echo $captchaHTML;?>	

					  		</div>

					  	</div>

					  	<div class="row">
					  		<div class="col-lg-12">
							    <p>
							    	<button type="submit" class="btn btn-danger" name="btnRegister"><?php echo Lang::get('cmsadmin.register');?></button>

							    	<a href="<?php echo System::getAdminUrl();?>" class="btn btn-default pull-right"><?php echo Lang::get('cmsadmin.back');?></a>
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