    <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/datepicker/css/datepicker.css">
 	<script src="<?php echo ROOT_URL;?>bootstrap/datepicker/js/bootstrap-datepicker.js"></script>


<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Coupons</h3>
  </div>
  <div class="panel-body">
    <div class="row">
		<div class="col-lg-8 showBorderRight">
		<p>
			<h4>List coupons</h4>
		</p>

<!-- Form Action -->
		<div class="row">
		<form action="" method="post" enctype="multipart/form-data">
		<div class="col-lg-3">
			<select class="form-control" name="action">
			<option value="delete">Delete</option>
			<option value="publish">Set Published</option>
			<option value="notpublish">Set Not Publish</option>

			</select>
		</div>
		<div class="col-lg-2">
			<button type="submit" class="btn btn-info" name="btnAction">Apply</button>
		</div>
		<!-- right -->
		<div class="col-lg-4 pull-right text-right">
		
    <div class="input-group">
      <input type="text" class="form-control" name="txtKeywords" placeholder="Search for...">
      <span class="input-group-btn">
        <button class="btn btn-primary" name="btnSearch" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
      </span>
    </div><!-- /input-group -->
    
		</div>
		<!-- right -->


		</div>

		<!-- List -->
		<div class="row">
			<div class="col-lg-12">

				<table class="table">
				<thead>
					<tr>
					<td class="col-lg-1"><input type="checkbox" id="selectAll" /></td>
					<td class="col-lg-3">Date Added</td>
					<td class="col-lg-3">Title</td>
					<td class="col-lg-3">Code</td>
					<td class="col-lg-1">Amount</td>

					<td class="col-lg-1">Status</td>
						<td class="col-lg-1"></td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($coupons);

				$li='';

				$status='';

				if(isset($coupons[0]['amount']))
				for($i=0;$i<$totalRow;$i++)
				{
					$status='<div class="label label-warning">Not Publish</div>';
					if((int)$coupons[$i]['status']==1)
					{
						$status='<div class="label label-success">Published</div>';
					}
					$li.='

					<tr>
					<td>
					<input type="checkbox" id="cboxID" name="id[]" value="'.$coupons[$i]['couponid'].'" />
					</td>
					<td>'.$coupons[$i]['date_added'].'</td>
					<td>'.$coupons[$i]['coupon_title'].'</td>
					<td>'.$coupons[$i]['coupon_code'].'</td>

					<td>$'.$coupons[$i]['amount'].'</td>

					<td>'.$status.'</td>

					<td><a href="'.ROOT_URL.'admincp/coupons/edit/'.$coupons[$i]['couponid'].'" class="btn btn-xs btn-warning">Edit</a></td>

					</tr>
					';

				}

				echo $li;

				?>


				</tbody>
				</table>
			</div>

			<div class="col-lg-12 text-right">
				<?php  echo $pages; ?>
			</div>
		</div>
		</form>



		</div>		


		<div class="col-lg-4">
		<form action="" method="post" enctype="multipart/form-data">
			<input type="hidden" name="send[date_added]" class="form-control" value="<?php echo date('Y-m-d h:i:s');?>" />
			<input type="hidden" name="send[coupon_code]" class="form-control" value="<?php echo String::randText(32);?>" />

			<?php if($showEdit=='no'){ ?>
			<!-- Add new -->
			<div style="display:block;">
			<p>
			<h4>Add new coupon (Default currency is dollars)</h4>
			</p>
			<?php echo $alert;?>
			<p>
			<label><strong>Title:</strong></label>
			<input type="text" name="send[coupon_title]" class="form-control" placeholder="Title..." />

			</p>
				<p>
			<label><strong>Coupon type:</strong></label>
			<select class="form-control" name="send[coupon_type]">
			<option value="percent">Percent</option>
			<option value="money">Money</option>
			</select>
			</p>

			<p>
			<label><strong>Is free shipping ?</strong></label>
			<select class="form-control" name="send[freeshipping]">
			<option value="1">Yes, Free shipping</option>
			<option value="0">No</option>
			</select>
			</p>

			<p>
			<label><strong>Amount:</strong></label>
			<input type="text" name="send[amount]" class="form-control" placeholder="Amount..." />

			</p>
			<p>
			<label><strong>Date start:</strong></label>
			<input type="text" name="send[date_start]" data-provide="datepicker" class="datepicker form-control " value="<?php echo date('Y-m-d');?>" placeholder="Date start..." />
			</p>
			<p>
			<label><strong>Date end:</strong></label>
			<input type="text" name="send[date_end]" data-provide="datepicker" class="datepicker form-control " value="<?php echo date('Y-m-d');?>" placeholder="Date end..." />
			</p>

			<p>
			<label><strong>Uses Per Coupon:</strong></label>
			<small>The maximum number of times the coupon can be used by any customer. Leave blank for unlimited</small>
			<input type="text" name="send[limituse]" class="form-control " value="1" placeholder="Uses Per Coupon..." />
			</p>
			<p>
			<label><strong>Uses Per Customer:</strong></label>
			<small>The maximum number of times the coupon can be used by a single customer. Leave blank for unlimited</small>
			<input type="text" name="send[limitperuser]" class="form-control " value="1" placeholder="Uses Per Customer..." />
			</p>

			<p>
			<button type="submit" class="btn btn-info" name="btnAdd">Add new</button>
			</p>
			</div>
			<?php } ?>


			<?php if($showEdit=='yes'){ ?>
			<!-- Edit -->
			<div style="display:block;">
			<p>
			<h4>Edit voucher</h4>
			</p>
			<?php echo $alert;?>
			<p>
			<label><strong>Title:</strong></label>
			<input type="text" name="send[coupon_title]" class="form-control" value="<?php echo $edit['coupon_title'];?>" placeholder="Title..." />

			</p>
				<p>
			<label><strong>Coupon type:</strong></label>
			<select class="form-control" name="send[coupon_type]">
			<option value="percent" <?php if($edit['coupon_type']=='percent')echo 'selected';?>>Percent</option>
			<option value="money" <?php if($edit['coupon_type']=='money')echo 'selected';?>>Money</option>
			</select>
			</p>

			<p>
			<label><strong>Is free shipping ?</strong></label>
			<select class="form-control" name="send[freeshipping]">
			<option value="1" <?php if((int)$edit['freeshipping']==1)echo 'selected';?>>Yes, Free shipping</option>
			<option value="0" <?php if((int)$edit['freeshipping']==0)echo 'selected';?>>No</option>
			</select>
			</p>

			<p>
			<label><strong>Amount:</strong></label>
			<input type="text" name="send[amount]" class="form-control" value="<?php echo $edit['amount'];?>" placeholder="Amount..." />

			</p>
			<p>
			<label><strong>Date start:</strong></label>
			<input type="text" name="send[date_start]" data-provide="datepicker" value="<?php echo $edit['date_start'];?>" class="datepicker form-control " placeholder="Date start..." />
			</p>
			<p>
			<label><strong>Date end:</strong></label>
			<input type="text" name="send[date_end]" data-provide="datepicker" value="<?php echo $edit['date_end'];?>" class="datepicker form-control " placeholder="Date end..." />
			</p>
			
			<p>
			<label><strong>Uses Per Coupon:</strong></label>
			<small>The maximum number of times the coupon can be used by any customer. Leave blank for unlimited</small>
			<input type="text" name="send[limituse]" class="form-control "  value="<?php echo $edit['limituse'];?>" placeholder="Uses Per Coupon..." />
			</p>
			<p>
			<label><strong>Uses Per Customer:</strong></label>
			<small>The maximum number of times the coupon can be used by a single customer. Leave blank for unlimited</small>
			<input type="text" name="send[limitperuser]" class="form-control "  value="<?php echo $edit['limitperuser'];?>" placeholder="Uses Per Customer..." />
			</p>


			<p>
			<button type="submit" class="btn btn-info" name="btnSave">Save Changes</button>
			</p>
			</div>
			<?php } ?>



		</form>
		</div>




	</div>
  </div>
</div>

			<script>
			$(document).ready(function(){
				$('.datepicker').datepicker({
					    format: 'yyyy-mm-dd'
					})
			});
			</script>