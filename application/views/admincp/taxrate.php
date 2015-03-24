  <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/admincp/css/chosen.min.css">

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Tax rate</h3>
  </div>
  <div class="panel-body">
    <div class="row">
		<div class="col-lg-7 showBorderRight">
		<p>
			<h4>List tax rate</h4>
		</p>

<!-- Form Action -->
		<div class="row">
		<form action="" method="post">
		<div class="col-lg-10">
			<select class="form-control" name="action">
			<option value="delete">Delete</option>
			</select>
		</div>
		<div class="col-lg-2">
			<button type="submit" class="btn btn-info" name="btnAction">Apply</button>
		</div>



		</div>

		<!-- List -->
		<div class="row">
			<div class="col-lg-12">

				<table class="table">
				<thead>
					<tr>
					<td class="col-lg-1">#</td>
					<td class="col-lg-11">Name</td>
						<td class="col-lg-1"></td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($taxrate);

				$li='';

				if(isset($taxrate[0]['taxid']))
				for($i=0;$i<$totalRow;$i++)
				{
					$li.='

					<tr>
					<td>
					<input type="checkbox" name="id[]" value="'.$taxrate[$i]['taxid'].'" />
					</td>
					<td>'.$taxrate[$i]['tax_title'].'</td>
					<td><a href="'.ROOT_URL.'admincp/taxrate/edit/'.$taxrate[$i]['taxid'].'" class="btn btn-xs btn-warning">Edit</a></td>

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


		<div class="col-lg-5">
		<form action="" method="post" enctype="multipart/form-data">

			<?php if($showEdit=='no'){ ?>
			<!-- Add new -->
			<div style="display:block;">
			<p>
			<h4>Add new tax rate</h4>
			</p>
			<?php echo $alert;?>
			<p>
			<label><strong>Title:</strong></label>
			<input type="text" name="send[tax_title]" class="form-control" placeholder="Title..." />
			</p>

			<p>
			<label><strong>Type:</strong></label>
			<select class="form-control" name="send[tax_type]">
			<option value="percent">Percent</option>
			<option value="fixedamount">Fixed amount</option>
			</select>
			</p>
			<p>
			<label><strong>Rate: (default currency is dollars)</strong></label>
			<input type="text" name="send[tax_rate]" class="form-control" value="0.00" placeholder="0.00" />
			</p>
			<p>
			<label><strong>Apply to countries:</strong></label>
			<select multiple class="form-control" name="countries[]" id="jsCountries" data-placeholder="Choose countries...">
			<option value="worldwide" selected>Worldwide</option>

			<?php
				$total=count($countries);

				$li='';
				for($i=0;$i<$total;$i++)
				{
					$li.='<option value="'.$countries[$i]['iso_code_2'].'">'.$countries[$i]['name'].'</option>';
				}

				echo $li;
			?>
			</select>
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
			<h4>Edit tax rate</h4>
			</p>
			<?php echo $alert;?>
			<p>
			<label><strong>Title:</strong></label>
			<input type="text" name="send[tax_title]" class="form-control" value="<?php if(isset($edit['tax_title']))echo $edit['tax_title'];?>" placeholder="Title..." />
			</p>

			<p>
			<label><strong>Type:</strong></label>
			<select class="form-control" name="send[tax_type]">
			<option value="percent" <?php if(isset($edit['tax_type']) && $edit['tax_type']=='percent')echo 'selected';?>>Percent</option>
			<option value="fixedamount" <?php if(isset($edit['tax_type']) && $edit['tax_type']=='fixedamount')echo 'selected';?>>Fixed amount</option>
			</select>
			</p>
			<p>
			<label><strong>Rate: (default currency is dollars)</strong></label>
			<input type="text" name="send[tax_rate]" class="form-control" value="<?php if(isset($edit['tax_rate']))echo $edit['tax_rate'];?>" placeholder="0.00" />
			</p>
			<p>
			<label><strong>Apply to countries:</strong></label>
			<select multiple class="form-control" name="countries[]" id="jsCountries" data-placeholder="Choose countries...">


			<?php
				$total=count($countries);

				$li='';
				for($i=0;$i<$total;$i++)
				{
					if(in_array($countries[$i]['iso_code_2'], $edit['countries']))
					{
						$li.='<option value="'.$countries[$i]['iso_code_2'].'" selected>'.$countries[$i]['name'].'</option>';	
					}
					else
					{
						$li.='<option value="'.$countries[$i]['iso_code_2'].'">'.$countries[$i]['name'].'</option>';							
					}

				}
				
				echo $li;
			?>
			</select>
			</p>

			<p>
			<button type="submit" class="btn btn-info" name="btnSave">Save Changes</button>
			<a class="btn btn-default pull-right" href="<?php echo ADMINCP_URL;?>taxrate">Cancel</a>

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
      $("#jsCountries").chosen();
  </script>