<form action="" method="post" enctype="multipart/form-data">
	

<div class="panel panel-default">

  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<h3><?php echo $title;?></h3>
		<hr>
		<?php echo $alert;?>
		<p>
		<label>Subject</label>
		<input type="text" class="form-control" name="send[subject]" value="<?php echo $title;?>" />
		</p>
		<p>
		<label>Content</label>
		<textarea rows="20" class="form-control" name="send[content]"><?php echo $content;?></textarea>
		</p>

		<p>
			<button type="submit" class="btn btn-primary" name="btnSend">Save Changes</button>
		</p>
    	</div>
    </div>
  </div>
</div>
</form>