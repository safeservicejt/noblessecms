<form action="" method="post" enctype="multipart/form-data">
	
<div class="panel panel-default">

  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<?php echo $alert; ?>
    	<h3>Currency</h3>
    	<hr>
		<table class="table table-hover">
			<tbody>
				<tr>
					<td class="col-lg-4 col-md-4 col-sm-4 "><strong>Currency</strong></td>
					<td class="col-lg-8 col-md-8 col-sm-8 ">
					<select class="form-control" name="send[currency]">
						<option value="usd" <?php if($setting['currency']=='usd')echo 'selected';?>>US Dollar</option>
						<option value="eur" <?php if($setting['currency']=='eur')echo 'selected';?>>Euro</option>
						<option value="gbp" <?php if($setting['currency']=='gbp')echo 'selected';?>>Pound Sterling</option>
						<option value="vnd" <?php if($setting['currency']=='vnd')echo 'selected';?>>Viet Nam Dong</option>
					</select>
					</td>
				</tr>
				<tr>
					<td class="col-lg-4 col-md-4 col-sm-4 "><strong>Symbol Left</strong></td>
					<td class="col-lg-8 col-md-8 col-sm-8 ">
					<input type="text" class="form-control input-size-medium" name="send[currency_symbol_left]" value="<?php echo Request::get('send.currency_symbol_left',$setting['currency_symbol_left']);?>" maxlength="255" />
					</td>
				</tr>
				<tr>
					<td class="col-lg-4 col-md-4 col-sm-4 "><strong>Symbol Right</strong></td>
					<td class="col-lg-8 col-md-8 col-sm-8 ">
					<input type="text" class="form-control input-size-medium" name="send[currency_symbol_right]" value="<?php echo Request::get('send.currency_symbol_right',$setting['currency_symbol_right']);?>" maxlength="255" />
					</td>
				</tr>
			</tbody>
		</table>
		<hr>
		<button type="submit" name="btnSend" class="btn btn-primary">Save Changes</button>

    	</div>
    </div>
  </div>
</div>
</form>