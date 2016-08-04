
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
	    		<div class="col-lg-6 col-lg-offset-3">
					<div class="panel panel-default">
					<div class="panel-heading"><?php echo Lang::get('cmsadmin.forgotPassword');?></div>
					  <div class="panel-body">
					  	<div class="row">
					  		<div class="col-lg-12">
					  		<?php echo $alert;?>
							    <p>
							    	<strong><?php echo Lang::get('cmsadmin.email');?>:</strong>
							    </p>
							    <p>
							    	<input type="email" class="form-control" placeholder="<?php echo Lang::get('cmsadmin.email');?>..." name="send[email]" id="txtUsername" required />
							    </p>
							    <p style="margin-top:20px;">
							    	<strong><?php echo Lang::get('cmsadmin.enterCaptcha');?>:</strong>
							    </p>							    
							    <p>
							    	<div class="pull-right"><?php echo $captchaHTML;?></div>	
							    </p>
							    <p>
							    	<button type="submit" class="btn btn-primary" name="btnSend"><?php echo Lang::get('cmsadmin.sendPassword');?></button>

							    	<a href="<?php echo System::getAdminUrl();?>" class="pull-right"><?php echo Lang::get('cmsadmin.backToLogin');?></a>
							    </p>								    				  			
					  		</div>

					  	</div>



					  </div>
					</div>	    	   			
	    		</div>
	    	</div>
	    	<!-- row -->


	    	</div>    		
    	</div>

    </div>
    </form>