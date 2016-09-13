
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
	    		<div class="col-lg-6 col-lg-offset-3">
					<div class="panel panel-default">
					<div class="panel-heading">Forgot Password</div>
					  <div class="panel-body">
					  	<div class="row">
					  		<div class="col-lg-12">
					  		<?php echo $alert;?>
							    <p>
							    	<strong>Email:</strong>
							    </p>
							    <p>
							    	<input type="email" class="form-control" placeholder="Email..." name="send[email]" id="txtUsername" required />
							    </p>
							    <p style="margin-top:20px;">
							    	<strong>Enter below captcha:</strong>
							    </p>							    
							    <p>
							    	<div class="pull-right"><?php echo $captchaHTML;?></div>	
							    </p>
							    <p>
							    	<button type="submit" class="btn btn-primary" name="btnSend">Send Password</button>

							    	<a href="<?php echo System::getUrl();?>npanel" class="pull-right">Back to login</a>
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