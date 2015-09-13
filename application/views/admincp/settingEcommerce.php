
<?php

$default_affiliate_status=isset($default_affiliate_status)?$default_affiliate_status:'disable';

?>
<form action="" method="post" enctype="multipart/form-data">	
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Ecommerce Setting</h3>
  </div>
  <div class="panel-body">
<div class="row">
		<div class="col-lg-12">


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
							<select name="general[default_order_status]" id="default_order_status" class="form-control">
							<option value="pending" >Pending</option>
								<option value="approved" >Approved</option>
								<option value="cancel" >Cancel</option>

							</select>
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>Default currency :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[default_currency]" id="default_currency" class="form-control">
							<?php

								$total=count($listCurrency);

								$li='';

								for($i=0;$i<$total;$i++)
								{
									$theCode=strtolower($listCurrency[$i]['code']);
									$li.='<option value="'.$theCode.'">'.$listCurrency[$i]['title'].'</option>';
								
								}

								echo $li;
							?>
							</select>
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>Enable/Disable affiliate system ?</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[default_affiliate_status]" id="default_affiliate_status" class="form-control">
								<option value="enable" >Enable</option>
								<option value="disable" >Disable</option>

							</select>
			    		</div>

			    	</div>

		  	<p>
		  	<button type="submit" name="btnSave" class="btn btn-info">Save Changes</button>
		  	</p>			  	

		</div>

	</div>    

  </div>
</div>
</form>
<script>

$(document).ready(function(){

setSelect('default_order_status','<?php echo $default_order_status;?>');

setSelect('default_currency','<?php echo $default_currency;?>');

setSelect('default_affiliate_status','<?php echo $default_affiliate_status;?>');


});

function setSelect(id,value)
{
	$('#'+id+' option').each(function(){
		var thisVal=$(this).val();

		if(thisVal==value)
		{
			$(this).attr('selected',true);
		}


	});
}
</script>