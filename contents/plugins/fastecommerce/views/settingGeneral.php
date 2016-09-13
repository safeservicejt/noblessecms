<form action="" method="post" enctype="multipart/form-data">
	
<div class="panel panel-default">

  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<?php echo $alert; ?>
    	<h3>General</h3>
    	<hr>
		    <div class="row">
		    	<div class="col-lg-5 col-md-5 col-sm-5">
		    	<p>
		    		<strong>Store details</strong>
		    	</p>
		    	<span>Your customer will use this information to contact you.</span>
		    	</div>
		    	<div class="col-lg-7 col-md-7 col-sm-7">
		    	<p>
		    		<strong>Language</strong>
					<select class="form-control" name="send[language]">
						<option value="en" <?php if($setting['language']=='en')echo 'selected';?>>English</option>
						<option value="vn" <?php if($setting['language']=='vn')echo 'selected';?>>Vietnamese</option>
					</select>		    	
				
		    	</p>		    	
		    	<p>
		    		<strong>Store Name</strong>
		    		<input type="text" class="form-control input-size-medium" name="send[store_name]" value="<?php echo Request::get('send.store_name',$setting['store_name']);?>" maxlength="255" />
		    	</p>
		    	<p>
		    		<strong>Account Email</strong>
		    		<input type="text" class="form-control input-size-medium" value="<?php echo Request::get('send.account_email',$setting['account_email']);?>" name="send[account_email]" maxlength="255" />
		    	</p>
		    	<p>
		    		<strong>Customer Email</strong>
		    		<input type="text" class="form-control input-size-medium" value="<?php echo Request::get('send.customer_email',$setting['customer_email']);?>" name="send[customer_email]" maxlength="255" />
		    	</p>
		    	<p>
		    		<strong>Order Notify Email</strong>
		    		<input type="text" class="form-control input-size-medium" value="<?php echo Request::get('send.order_notify_email',$setting['order_notify_email']);?>" name="send[order_notify_email]" maxlength="255" />
		    	</p>
		    	<p>
		    		<strong>Allow Send Order Notify To Admin</strong>
					<select class="form-control" name="send[allow_send_order_notify_to_admin]">
						<option value="yes" <?php if($setting['allow_send_order_notify_to_admin']=='yes')echo 'selected';?>>Yes</option>
						<option value="no" <?php if($setting['allow_send_order_notify_to_admin']=='no')echo 'selected';?>>No</option>
					</select>		    	
				
		    	</p>
		    	<p>
		    		<strong>Allow Send Order Notify To Customer</strong>
					<select class="form-control" name="send[allow_send_order_notify_to_customer]">
						<option value="yes" <?php if($setting['allow_send_order_notify_to_customer']=='yes')echo 'selected';?>>Yes</option>
						<option value="no" <?php if($setting['allow_send_order_notify_to_customer']=='no')echo 'selected';?>>No</option>
					</select>		    	
				
		    	</p>

		    	</div>
		    </div>
		<hr>
		    <div class="row">
		    	<div class="col-lg-5 col-md-5 col-sm-5">
		    	<p>
		    		<strong>Store address</strong>
		    	</p>
		    	<span>This address will appear on your invoices.</span>
		    	</div>
		    	<div class="col-lg-7 col-md-7 col-sm-7">
		    	<p>
		    		<strong>Legal name of business</strong>
		    		<input type="text" class="form-control input-size-medium" value="<?php echo Request::get('send.store_legal_name',$setting['store_legal_name']);?>" name="send[store_legal_name]" maxlength="255" />
		    	</p>
		    	<p>
		    		<strong>Phone</strong>
		    		<input type="text" class="form-control input-size-medium" value="<?php echo Request::get('send.store_phone',$setting['store_phone']);?>" name="send[store_phone]" maxlength="255" />
		    	</p>
		    	<p>
		    		<strong>Street</strong>
		    		<input type="text" class="form-control input-size-medium" value="<?php echo Request::get('send.store_street',$setting['store_street']);?>" name="send[store_street]" maxlength="255" />
		    	</p>
		    	<p>
		    		<strong>City</strong>
		    		<input type="text" class="form-control input-size-medium" value="<?php echo Request::get('send.store_city',$setting['store_city']);?>" name="send[store_city]" maxlength="255" />
		    	</p>
		    	<p>
		    		<strong>Zip code</strong>
		    		<input type="text" class="form-control input-size-medium" value="<?php echo Request::get('send.system_zipcode',$setting['system_zipcode']);?>" name="send[system_zipcode]" maxlength="255" />
		    	</p>
		    	<p>
		    		<strong>Country</strong>
		    		<input type="text" class="form-control input-size-medium" value="<?php echo Request::get('send.system_country',$setting['system_country']);?>" name="send[system_country]" maxlength="255" />
		    	</p>

		    	</div>
		    </div>
		<hr>
		    <div class="row">
		    	<div class="col-lg-5 col-md-5 col-sm-5">
		    	<p>
		    		<strong>Length Class</strong>
		    		
		    	</p>
		    	</div>
		    	<div class="col-lg-7 col-md-7 col-sm-7">
		    	<p>
					<select class="form-control" name="send[length_class]">
						<option value="centimeter" <?php if($setting['length_class']=='centimeter')echo 'selected';?>>Centimeter</option>
						<option value="millimeter" <?php if($setting['length_class']=='millimeter')echo 'selected';?>>Millimeter</option>
						<option value="inch" <?php if($setting['length_class']=='inch')echo 'selected';?>>Inch</option>
					</select>		    	
				</p>
		    	

		    	</div>
		    </div>
		<hr>
		    <div class="row">
		    	<div class="col-lg-5 col-md-5 col-sm-5">
		    	<p>
		    		<strong>Weight Class</strong>
		    		
		    	</p>
		    	</div>
		    	<div class="col-lg-7 col-md-7 col-sm-7">
		    	<p>
					<select class="form-control" name="send[weight_class]">
						<option value="kilogram" <?php if($setting['weight_class']=='kilogram')echo 'selected';?>>Kilogram</option>
						<option value="gram" <?php if($setting['weight_class']=='gram')echo 'selected';?>>Gram</option>
						<option value="pound" <?php if($setting['weight_class']=='pound')echo 'selected';?>>Pound</option>
						<option value="ounce" <?php if($setting['weight_class']=='ounce')echo 'selected';?>>Ounce</option>
					</select>		    	
				</p>
		    	

		    	</div>
		    </div>
		<hr>
		    <div class="row">
		    	<div class="col-lg-5 col-md-5 col-sm-5">
		    	<p>
		    		<strong>Allow Reviews</strong>
		    		
		    	</p>
		    	</div>
		    	<div class="col-lg-7 col-md-7 col-sm-7">
		    	<p>
					<select class="form-control" name="send[allow_reviews]">
						<option value="yes" <?php if($setting['allow_reviews']=='yes')echo 'selected';?>>Yes</option>
						<option value="no" <?php if($setting['allow_reviews']=='no')echo 'selected';?>>No</option>
					</select>		    	
				</p>
		    	

		    	</div>
		    </div>
		<hr>
		    <div class="row">
		    	<div class="col-lg-5 col-md-5 col-sm-5">
		    	<p>
		    		<strong>Default Affiliate Rank (<?php echo $setting['affiliate_rank_title'].' - '.$setting['affiliate_percent'].'%';?>)</strong>
		    		
		    	</p>
		    	</div>
		    	<div class="col-lg-7 col-md-7 col-sm-7">
		    	<p>
					<select class="form-control" name="affiliate_rankid">
						<?php if(isset($ranksList[0]['id'])){

						$total=count($ranksList);

						$li='';

						for ($i=0; $i < $total; $i++) { 

							if((int)$setting['affiliate_rankid']==(int)$ranksList[$i]['id'])
							{
								$li.='<option value="'.$ranksList[$i]['id'].'" selected>'.$ranksList[$i]['title'].' ('.$ranksList[$i]['commission'].'%) - Require '.$ranksList[$i]['orders'].' Orders</option>';
							}
							else
							{
								$li.='<option value="'.$ranksList[$i]['id'].'">'.$ranksList[$i]['title'].' ('.$ranksList[$i]['commission'].'%) - Require '.$ranksList[$i]['orders'].' Orders</option>';
							}
							
						}

						echo $li;

						} ?>

					</select>							
				</p>
		    	

		    	</div>
		    </div>
		<hr>
		    <div class="row">
		    	<div class="col-lg-5 col-md-5 col-sm-5">
		    	<p>
		    		<strong>Default VAT (%)</strong>
		    		
		    	</p>
		    	</div>
		    	<div class="col-lg-7 col-md-7 col-sm-7">
		    	<p>
					<input type="text" class="form-control input-size-medium" value="<?php echo Request::get('send.default_vat',$setting['default_vat']);?>" name="send[default_vat]" maxlength="255" />	    	
				</p>
		    	

		    	</div>
		    </div>
		<hr>
		    <div class="row">
		    	<div class="col-lg-5 col-md-5 col-sm-5">
		    	<p>
		    		<strong>Use theme for mobile</strong>
		    		
		    	</p>
		    	</div>
		    	<div class="col-lg-7 col-md-7 col-sm-7">
		    	<p>
					<select class="form-control" name="send[theme_mobile]">
						<option value="yes" <?php if($setting['theme_mobile']=='yes')echo 'selected';?>>Yes</option>
						<option value="no" <?php if($setting['theme_mobile']=='no')echo 'selected';?>>No</option>
					</select>	    	
				</p>
		    	

		    	</div>
		    </div>
		<hr>
		    <div class="row">
		    	<div class="col-lg-5 col-md-5 col-sm-5">
		    	<p>
		    		<strong>Select theme for mobile</strong>
		    		
		    	</p>
		    	</div>
		    	<div class="col-lg-7 col-md-7 col-sm-7">
		    	<p>
					<select class="form-control" name="send[theme_mobile_name]">
						<?php if(isset($listThemes)){
							$total=count($listThemes);

							if($total > 0)
							{
								$themeNames=array_keys($listThemes);

								$li='';

								for ($i=0; $i < $total; $i++) { 

								$themeName=$themeNames[$i];
								
								if($themeName==FastEcommerce::$setting['theme_mobile_name'])
								{
									$li.='<option value="'.$themeName.'" selected>'.$listThemes[$themeNames[$i]][0].'</option>';
								}
								else
								{
									$li.='<option value="'.$themeName.'">'.$listThemes[$themeNames[$i]][0].'</option>';
								}
								
						
								}

								echo $li;
							}

						} ?>
						
					</select>	    	
				</p>
		    	

		    	</div>
		    </div>

		<button type="submit" name="btnSend" class="btn btn-primary">Save Changes</button>

    	</div>
    </div>
  </div>
</div>
</form>