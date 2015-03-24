
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Send request payment </h3>
  </div>
  <div class="panel-body">
    
<form action="" method="post" enctype="multipart/form-data">
<div class="row">

	<div class="col-lg-12">
	<?php echo $alert;?>
		<p>
		<label><strong>Total request: </strong> <span><?php echo $edit['earnedFormat'];?></span></label>
		</p>
		<p>
		<label><strong>Write your comments about this request payment</strong>
		</p>

	</div>

	<div class="col-lg-12">
		<textarea rows="8" class="form-control" name="send[comments]" placeholder="Write your comments about this request payment"></textarea>

	</div>
	<div class="col-lg-12">
		<p><br>
		<button type="submit" class="btn btn-primary" name="btnSend">Send request</button>

		<a href="<?php echo USERCP_URL;?>" class="btn btn-default">Cancel</a>
		</p>

	</div>


</div> 
</form>	   
  </div>
</div>
