
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Change your password</h3>
  </div>
  <div class="panel-body">
    

<div class="row">
<?php echo $alert;?>
		<div class="col-lg-6">
		<form action="" method="post" enctype="multipart/form-data">
				
			<p>
			<label><strong>Password:</strong></label>
			<input type="text" name="send[password]" class="form-control" placeholder="Password..." />
			</p>
					
			<p>
			<label><strong>Confirm Password:</strong></label>
			<input type="text" name="send[repassword]" class="form-control" placeholder="Confirm Password..." />
			</p>
					
				
		
		</div>


		<div class="col-lg-12">
		<button type="submit" class="btn btn-info" name="btnSave">Save changes</button>
		</div>


	</form>



	</div>    
  </div>
</div>
