
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Payment Information</h3>
  </div>
  <div class="panel-body">
    

<div class="row">
		<div class="col-lg-6">
		<form action="" method="post" enctype="multipart/form-data">
				
			<p>
			<label><strong>Payment method:</strong></label>
			<input type="text" name="send[payment_method]" class="form-control" placeholder="Payment method..." value="<?php if(isset($edit['payment_method'])) echo $edit['payment_method'];?>" />
			</p>
					
				<p>
			<label><strong>Payment account:</strong></label>
			<input type="text" name="send[payment_account]" class="form-control" placeholder="Payment account..." value="<?php if(isset($edit['payment_account'])) echo $edit['payment_account'];?>" />
			</p>
					
				<p>
			<label><strong>Cheque:</strong></label>
			<input type="text" name="send[cheque]" class="form-control" placeholder="Cheque..." value="<?php if(isset($edit['cheque'])) echo $edit['cheque'];?>" />
			</p>
					

	
		</div>

		<div class="col-lg-6">
			<p>
			<label><strong>Bank name:</strong></label>
			<input type="text" name="send[bank_name]" class="form-control" placeholder="Bank name..." value="<?php if(isset($edit['bank_name'])) echo $edit['bank_name'];?>" />
			</p>
					
			<p>
			<label><strong>Bank branch number:</strong></label>
			<input type="text" name="send[bank_branch_number]" class="form-control" placeholder="Bank branch number..." value="<?php if(isset($edit['bank_branch_number'])) echo $edit['bank_branch_number'];?>" />
			</p>
					
			<p>
			<label><strong>Bank swift code:</strong></label>
			<input type="text" name="send[bank_swift_code]" class="form-control" placeholder="Bank swift code..." value="<?php if(isset($edit['bank_swift_code'])) echo $edit['bank_swift_code'];?>" />
			</p>
					
			<p>
			<label><strong>Bank account name:</strong></label>
			<input type="text" name="send[bank_account_name]" class="form-control" placeholder="Bank account name..." value="<?php if(isset($edit['bank_account_name'])) echo $edit['bank_account_name'];?>" />
			</p>
					
			<p>
			<label><strong>Bank account number:</strong></label>
			<input type="text" name="send[bank_account_number]" class="form-control" placeholder="Bank account number..." value="<?php if(isset($edit['bank_account_number'])) echo $edit['bank_account_number'];?>" />
			</p>
					


		
		</div>


		<div class="col-lg-12">
		<button type="submit" class="btn btn-info" name="btnSave">Save changes</button>
		</div>


	</form>



	</div>    
  </div>
</div>
