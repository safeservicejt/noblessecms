
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit Profile</h3>
  </div>
  <div class="panel-body">
    

<div class="row">
		<div class="col-lg-6">
		<form action="" method="post" enctype="multipart/form-data">
				
			<p>
			<label><strong>First name:</strong></label>
			<input type="text" name="send[firstname]" class="form-control" placeholder="First name..." value="<?php echo $edit['firstname'];?>" />
			</p>
					
			<p>
			<label><strong>Last name:</strong></label>
			<input type="text" name="send[lastname]" class="form-control" placeholder="Last name..." value="<?php echo $edit['lastname'];?>" />
			</p>
				<p>
			<label><strong>Telephone:</strong></label>
			<input type="text" name="address[phone]" class="form-control" placeholder="Phone..." value="<?php echo $address['phone'];?>" />
			</p>
	
			<p>
			<label><strong>Fax:</strong></label>
			<input type="text" name="address[fax]" class="form-control" placeholder="Fax..." value="<?php echo $address['fax'];?>" />
			</p>		
		
		</div>

		<div class="col-lg-6">
			<p>
			<label><strong>Address 1:</strong></label>
			<input type="text" name="address[address_1]" class="form-control" placeholder="Address 1..." value="<?php echo $address['address_1'];?>" />
			</p>
	

				<p>
			<label><strong>Address 2:</strong></label>
			<input type="text" name="address[address_2]" class="form-control" placeholder="Address 2..." value="<?php echo $address['address_2'];?>" />
			</p>


				<p>
			<label><strong>City:</strong></label>
			<input type="text" name="address[city]" class="form-control" placeholder="City..." value="<?php echo $address['city'];?>" />
			</p>

				<p>
			<label><strong>Postcode:</strong></label>
			<input type="text" name="address[postcode]" class="form-control" placeholder="Postcode..." value="<?php echo $address['postcode'];?>" />
			</p>

				<p>
			<label><strong>Country:</strong></label>
			<input type="text" name="address[country]" class="form-control" placeholder="Country..." value="<?php echo $address['country'];?>" />
			</p>



		
		</div>


		<div class="col-lg-12">
		<button type="submit" class="btn btn-info" name="btnSave">Save changes</button>
		</div>


	</form>



	</div>    
  </div>
</div>
