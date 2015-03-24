  <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/admincp/css/chosen.min.css">

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Gift Vouchers</h3>
  </div>
  <div class="panel-body">
    <div class="row">
		<div class="col-lg-8 showBorderRight">
		<p>
			<h4>List gift vouchers</h4>
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
					<td class="col-lg-2">Date Added</td>
					<td class="col-lg-5">Code</td>
					<td class="col-lg-3">Amount</td>

					<td class="col-lg-1">Status</td>
						<td class="col-lg-1"></td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($vouchers);

				$li='';

				$status='';

				if(isset($vouchers[0]['amount']))
				for($i=0;$i<$totalRow;$i++)
				{
					$status='<div class="label label-warning">Not Publish</div>';
					if((int)$vouchers[$i]['status']==1)
					{
						$status='<div class="label label-success">Published</div>';
					}
					$li.='

					<tr>
					<td>
					<input type="checkbox" id="cboxID" name="id[]" value="'.$vouchers[$i]['voucherid'].'" />
					</td>
					<td>'.$vouchers[$i]['date_added'].'</td>
					<td>'.$vouchers[$i]['code'].'</td>
					<td>'.$vouchers[$i]['amountFormat'].'</td>

					<td>'.$status.'</td>

					<td><a href="'.ROOT_URL.'admincp/giftvouchers/edit/'.$vouchers[$i]['voucherid'].'" class="btn btn-xs btn-warning">Edit</a></td>

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

			<?php if($showEdit=='no'){ ?>
			<!-- Add new -->
			<div style="display:block;">
			<p>
			<h4>Add new voucher (Default currency is dollars)</h4>
			</p>
			<?php echo $alert;?>
			<p>
			<label><strong>Amount:</strong></label>
			<input type="text" name="send[amount]" class="form-control" placeholder="Amount..." />
			<input type="hidden" name="send[date_added]" class="form-control" value="<?php echo date('Y-m-d h:i:s');?>" />
			<input type="hidden" name="send[code]" class="form-control" value="<?php echo String::randText(32);?>" />

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
			<label><strong>Amount:</strong></label>
			<input type="text" name="send[amount]" class="form-control" placeholder="Amount..." value="<?php if($showEdit=='yes')echo Render::numberFormat($edit['amount']);?>" />

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


<script src="<?php echo ROOT_URL;?>bootstrap/admincp/js/chosen.jquery.min.js"></script>
  <script type="text/javascript">
      $("#jsCategory").chosen({max_selected_options: 1});
  </script>