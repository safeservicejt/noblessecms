
<!-- row -->
<div class="row">
	<div class="col-lg-12"><h3><?php echo Lang::get('frontend/contactus.title');?></h3></div>
	<div class="col-lg-12">
	<form action="" method="post" enctype="multipart/form-data">
		<?php echo $alert;?>
		<p>
		<label><strong><?php echo Lang::get('frontend/contactus.fullname');?></h3></div>
	<div class="col-lg-12"></strong></label>
		<input type="text" class="form-control" placeholder="<?php echo Lang::get('frontend/contactus.fullname');?></h3></div>
	<div class="col-lg-12">" name="send[fullname]" required />
		</p>
		<p>
		<label><strong><?php echo Lang::get('frontend/contactus.email');?></h3></div>
	<div class="col-lg-12"></strong></label>
		<input type="email" class="form-control" placeholder="<?php echo Lang::get('frontend/contactus.email');?></h3></div>
	<div class="col-lg-12">" name="send[email]" required />
		</p>
		<p>
		<label><strong><?php echo Lang::get('frontend/contactus.content');?></h3></div>
	<div class="col-lg-12"></strong></label>
		<textarea rows="10" class="form-control" placeholder="<?php echo Lang::get('frontend/contactus.content');?></h3></div>
	<div class="col-lg-12">" name="send[content]"></textarea>
		</p>

		<button type="submit" class="btn btn-primary" name="btnSend"><?php echo Lang::get('frontend/contactus.btnSend');?></h3></div>
	<div class="col-lg-12"></button>

		<a href="<?php echo ROOT_URL;?>" class="btn btn-default pull-right"><?php echo Lang::get('frontend/contactus.btnBack');?></h3></div>
	<div class="col-lg-12"></a>
	</form>



	</div>

</div>
<!-- row -->