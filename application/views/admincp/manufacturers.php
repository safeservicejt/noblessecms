  <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/admincp/css/chosen.min.css">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Manufacturers</h3>
  </div>
  <div class="panel-body">

<div class="row">
		<div class="col-lg-7 showBorderRight">
		<p>
			<h4>List manufacturers</h4>
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
					<td class="col-lg-1"><input type="checkbox" id="selectAll" /></td>
					<td class="col-lg-11">Name</td>
						<td class="col-lg-1"></td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($manu);

				$li='';

				if(isset($manu[0]['manufacturerid']))
				for($i=0;$i<$totalRow;$i++)
				{
					$li.='

					<tr>
					<td>
					<input type="checkbox" id="cboxID" name="id[]" value="'.$manu[$i]['manufacturerid'].'" />
					</td>
					<td>'.$manu[$i]['manufacturer_title'].'</td>
					<td><a href="'.ROOT_URL.'admincp/manufacturers/edit/'.$manu[$i]['manufacturerid'].'" class="btn btn-xs btn-warning">Edit</a></td>

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
			<h4>Add new manufacturer</h4>
			</p>
			<?php echo $alert;?>
			<p>
			<label><strong>Title:</strong></label>
			<input type="text" name="send[manufacturer_title]" class="form-control" placeholder="Title..." />
			</p>

	<p>
			<label><strong>Image:</strong></label>
			<input type="file" name="thumbnail" class="form-control" />

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
			<h4>Edit manufacturer</h4>
			</p>
			<?php echo $alert;?>
			<p>
			<label><strong>Title:</strong></label>
			<input type="text" name="send[manufacturer_title]" class="form-control" placeholder="Title..." value="<?php if($showEdit=='yes')echo stripslashes($edit['manufacturer_title']);?>" />
			</p>
			<p>
			<label><strong>Friendly url:</strong></label>
			<input type="text" name="send[friendly_url]" class="form-control" placeholder="Friendly url..." value="<?php echo stripslashes($edit['friendly_url']);?>" />
			</p>

	<p>
			<label><strong>Image:</strong></label>
			<input type="file" name="thumbnail" class="form-control" />

			</p>
			<?php $thumbnail=$edit['manufacturer_image']; if(isset($thumbnail[5])){ ;?>	
			<p>
			<img src="<?php echo ROOT_URL.$thumbnail;?>" class="img-responsive" />
			</p>

			<?php } ?>				
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