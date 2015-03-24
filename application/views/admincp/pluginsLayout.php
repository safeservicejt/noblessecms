

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Manage layouts</h3>
  </div>
  <div class="panel-body">
    <div class="row">
		<div class="col-lg-7 showBorderRight">
		<p>
			<h4>List layouts</h4>
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

				$totalRow=count($layouts);

				$li='';

				for($i=0;$i<$totalRow;$i++)
				{
					$li.='

					<tr>
					<td>
					<input type="checkbox" name="id[]" value="'.$layouts[$i]['layoutid'].'" />
					</td>
					<td>'.$layouts[$i]['layoutname'].'</td>
					<td><a href="'.ROOT_URL.'admincp/plugins/layouts/edit/'.$layouts[$i]['layoutid'].'" class="btn btn-xs btn-warning">Edit</a></td>

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
			<h4>Add new layout</h4>
			</p>
			<?php echo $alert;?>
			<p>
			<label><strong>Name:</strong></label>
			<input type="text" name="send[layoutname]" class="form-control" placeholder="Layout name..." />
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
			<h4>Edit layout</h4>
			</p>
			<?php echo $alert;?>
			<p>
			<label><strong>Layout name:</strong></label>
			<input type="text" name="send[layoutname]" class="form-control" placeholder="Layout name..." value="<?php if($showEdit=='yes')echo stripslashes($edit['layoutname']);?>" />

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