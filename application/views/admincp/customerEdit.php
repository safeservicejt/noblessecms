  <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/admincp/css/chosen.min.css">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit Customers</h3>
  </div>
  <div class="panel-body">
    

<div class="row">
		<div class="col-lg-6">
		<form action="" method="post" enctype="multipart/form-data">
			
			<p>
			<label><strong>First name:</strong></label>
			<input type="text" name="send[firstname]" class="form-control" placeholder="First name..." value="<?php echo stripslashes(trim($edit['firstname']));?>" />
			</p>
					
			<p>
			<label><strong>Last name:</strong></label>
			<input type="text" name="send[lastname]" class="form-control" placeholder="Last name..." value="<?php echo stripslashes(trim($edit['lastname']));?>" />
			</p>
					
			<p>
			<label><strong>Email:</strong></label>
			<input type="text" name="send[email]" class="form-control" placeholder="Email..." value="<?php echo stripslashes(trim($edit['email']));?>" />
			</p>
					
				<p>
			<label><strong>Telephone:</strong></label>
			<input type="text" name="send[telephone]" class="form-control" placeholder="Phone..." value="<?php echo stripslashes(trim($edit['telephone']));?>" />
			</p>
				<p>
			<label><strong>Fax:</strong></label>
			<input type="text" name="send[fax]" class="form-control" placeholder="Fax..." value="<?php echo stripslashes(trim($edit['fax']));?>" />
			</p>
				<p>
				<input type="checkbox" name="send[isadmin]" value="1" <?php if((int)$edit['is_admin']==1)echo 'checked';?> />
			<label><strong>is Administrator</strong></label>
			
			</p>
							<p>
				<input type="checkbox" name="send[isaff]" value="1" <?php if((int)$edit['is_affiliate']==1)echo 'checked';?> />
			<label><strong>is Affiliate</strong></label>
			
			</p>
					


		</div>

		<div class="col-lg-6">
				<p>
			<label><strong>Address 1:</strong></label>
			<input type="text" name="address[address_1]" class="form-control" placeholder="Fax..." value="<?php echo stripslashes(trim($address['address_1']));?>" />
			</p>

				<p>
			<label><strong>Address 2:</strong></label>
			<input type="text" name="address[address_2]" class="form-control" placeholder="Fax..." value="<?php echo stripslashes(trim($address['address_2']));?>" />
			</p>

				<p>
			<label><strong>Company:</strong></label>
			<input type="text" name="address[company]" class="form-control" placeholder="Fax..." value="<?php echo stripslashes(trim($address['company']));?>" />
			</p>

				<p>
			<label><strong>City:</strong></label>
			<input type="text" name="address[city]" class="form-control" placeholder="Fax..." value="<?php echo stripslashes(trim($address['city']));?>" />
			</p>

				<p>
			<label><strong>Postcode:</strong></label>
			<input type="text" name="address[postcode]" class="form-control" placeholder="Fax..." value="<?php echo stripslashes(trim($address['postcode']));?>" />
			</p>

				<p>
			<label><strong>Country:</strong></label>
			<input type="text" name="address[country]" class="form-control" placeholder="Fax..." value="<?php echo stripslashes(trim($address['country']));?>" />
			</p>



		
		</div>

		<div class="col-lg-12">
		<hr>
		<h4>Affiliate & Payment information</h4>

		</div>

		<div class="col-lg-6">
				<p>
			<label><strong>Commission (percent):</strong></label>
			<input type="text" name="aff[commission]" class="form-control" placeholder="Commission..." value="<?php echo stripslashes(trim($affiliate['commission']));?>" />
			</p>		
				<p>
			<label><strong>Payment method:</strong></label>
			<input type="text" name="aff[payment_method]" class="form-control" placeholder="Payment method..." value="<?php echo stripslashes(trim($affiliate['payment_method']));?>" />
			</p>		
				<p>
			<label><strong>Payment account:</strong></label>
			<input type="text" name="aff[payment_account]" class="form-control" placeholder="Payment account..." value="<?php echo stripslashes(trim($affiliate['payment_account']));?>" />
			</p>		
				<p>
			<label><strong>Cheque:</strong></label>
			<input type="text" name="aff[cheque]" class="form-control" placeholder="Cheque..." value="<?php echo stripslashes(trim($affiliate['cheque']));?>" />
			</p>		

		</div>
		<div class="col-lg-6">
				<p>
			<label><strong>Bank name:</strong></label>
			<input type="text" name="aff[bank_name]" class="form-control" placeholder="Bank name..." value="<?php echo stripslashes(trim($affiliate['bank_name']));?>" />
			</p>		
				<p>
			<label><strong>Bank branch number:</strong></label>
			<input type="text" name="aff[bank_branch_number]" class="form-control" placeholder="Bank branch number..." value="<?php echo stripslashes(trim($affiliate['bank_branch_number']));?>" />
			</p>		
				<p>
			<label><strong>Bank swift code:</strong></label>
			<input type="text" name="aff[bank_swift_code]" class="form-control" placeholder="Bank swift code..." value="<?php echo stripslashes(trim($affiliate['bank_swift_code']));?>" />
			</p>		
				<p>
			<label><strong>Bank account name:</strong></label>
			<input type="text" name="aff[bank_account_name]" class="form-control" placeholder="Bank account name..." value="<?php echo stripslashes(trim($affiliate['bank_account_name']));?>" />
			</p>		
				<p>
			<label><strong>Bank account number:</strong></label>
			<input type="text" name="aff[bank_account_number]" class="form-control" placeholder="Bank account number..." value="<?php echo stripslashes(trim($affiliate['bank_account_number']));?>" />
			</p>		

		</div>


		<div class="col-lg-12">
		<button type="submit" class="btn btn-info" name="btnSave">Save changes</button>
		</div>


	</form>



	</div>    
  </div>
</div>

<script src="<?php echo ROOT_URL;?>bootstrap/admincp/js/chosen.jquery.min.js"></script>
  <script type="text/javascript">
    $(".chosen-select").chosen({max_selected_options: 1});
  </script>