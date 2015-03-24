  <link rel="stylesheet" href="<?php echo ROOT_URL; ?>bootstrap/toggle/bootstrap-toggle.min.css">
<script src="<?php echo ROOT_URL; ?>bootstrap/toggle/bootstrap-toggle.min.js"></script>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Ecommerce setting</h3>
  </div>
  <div class="panel-body">
<div class="row">
	<?php echo $alert;?>
		<div class="col-lg-12">


		  <form action="" method="post" enctype="multipart/form-data">	

			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>Turn On/Off Ecommerce System ?</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[enable_ecommerce]" class="form-control">
							<option value="1" <?php if((int)$enable_ecommerce==1)echo 'selected';?> >Enable</option>
							<option value="0" <?php if((int)$enable_ecommerce==0)echo 'selected';?> >Disabled</option>
							</select>

			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Turn On/Off Affiliate System ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<select name="general[enable_affiliate]" class="form-control">
							<option value="1" <?php if((int)$enable_affiliate==1)echo 'selected';?> >Enable</option>
							<option value="0" <?php if((int)$enable_affiliate==0)echo 'selected';?> >Disabled</option>
							</select>

			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Turn On/Off Deposit System ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<select name="general[enable_deposit]" class="form-control">
							<option value="1" <?php if((int)$enable_deposit==1)echo 'selected';?> >Enable</option>
							<option value="0" <?php if((int)$enable_deposit==0)echo 'selected';?> >Disabled</option>
							</select>


			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Turn On/Off Withdraw System ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<select name="general[enable_withdraw]" class="form-control">
							<option value="1" <?php if((int)$enable_withdraw==1)echo 'selected';?> >Enable</option>
							<option value="0" <?php if((int)$enable_withdraw==0)echo 'selected';?> >Disabled</option>
							</select>
							
			    		</div>

			    	</div>

			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Default minimum withdraw amount ? (Currency is dollars)</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="text" name="general[default_min_withdraw]" class="form-control" value="<?php if(isset($default_min_withdraw)) echo $default_min_withdraw ;else echo '50'?>">
			    		</div>

			    	</div>

			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Default affiliate commission percent ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="text" name="general[default_affiliate_commission]" class="form-control" value="<?php if(isset($default_affiliate_commission)) echo $default_affiliate_commission ;else echo '50'?>">
			    		</div>

			    	</div>
			    	
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Default VAT percent ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="text" name="general[default_vat_commission]" class="form-control" value="<?php if(isset($default_vat_commission)) echo $default_vat_commission ;else echo '10'?>">
			    		</div>

			    	</div>

			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>Default order status :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[order_status]" class="form-control">
							<option value="pending" <?php if($order_status=='pending')echo 'selected';?> >Pending</option>
								<option value="approved" <?php if($order_status=='approved')echo 'selected';?> >Approved</option>
								<option value="cancel" <?php if($order_status=='cancel')echo 'selected';?> >Cancel</option>

							</select>
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>Default currency :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[currency]" class="form-control">
							<?php

								$default_currency=isset($currency)?$currency:'usd';

								$total=count($listCurrency);

								$li='';

								for($i=0;$i<$total;$i++)
								{
									$theCode=strtolower($listCurrency[$i]['code']);
									if($default_currency==$theCode)
									{
										$li.='<option value="'.$theCode.'" selected>'.$listCurrency[$i]['title'].'</option>';

									}
									else
									{
										$li.='<option value="'.$theCode.'">'.$listCurrency[$i]['title'].'</option>';

									}
								
								}

								echo $li;
							?>
							</select>
			    		</div>

			    	</div>
		  	<p>
		  	<button type="submit" name="btnSave" class="btn btn-info">Save Changes</button>
		  	</p>	
		  </form>

		</div>

	</div>    

  </div>
</div>