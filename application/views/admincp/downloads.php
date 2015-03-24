
  <script src="<?php echo ROOT_URL;?>uploads/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_URL;?>uploads/uploadify/uploadify.css">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Downloads</h3>
  </div>
  <div class="panel-body">
    
<div class="row">
		<div class="col-lg-7 showBorderRight">
		<p>
			<h4>List downloads</h4>
		</p>

<!-- Form Action -->
		<div class="row">
		<form action="" method="post" enctype="multipart/form-data">
		<div class="col-lg-3">
			<select class="form-control" name="action">
			<option value="delete">Delete</option>
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
					<td class="col-lg-7">File title</td>
					<td class="col-lg-3">Filename</td>
					<td class="col-lg-1"></td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($downloads);

				$li='';

				if(isset($downloads[0]['downloadid']))
				for($i=0;$i<$totalRow;$i++)
				{
					$li.='

					<tr>
					<td>
					<input type="checkbox" id="cboxID" name="id[]" value="'.$downloads[$i]['downloadid'].'" />
					</td>
					<td>'.basename($downloads[$i]['title']).'</td>
					<td>'.basename($downloads[$i]['filename']).'</td>
					<td><a href="'.ROOT_URL.'admincp/downloads/edit/'.$downloads[$i]['downloadid'].'" class="btn btn-xs btn-warning">Edit</a></td>
				
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
			<h4>Add new download</h4>
			</p>
			<?php echo $alert;?>
			<p>
			<label><strong>Title:</strong></label>
			<input type="text" name="send[title]" class="form-control" placeholder="Title..." />
			</p>
			<p>
			<label><strong>Remaining:</strong></label>
			<input type="text" name="send[remaining]" class="form-control" placeholder="Remaining..." value="1" />
			</p>
	
			<p>
			<label><strong>File:</strong></label>
			<input type="file" name="theFile" class="form-control" />

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
			<h4>Edit download</h4>
			</p>
			<?php echo $alert;?>
			<p>
			<label><strong>Title:</strong></label>
			<input type="text" name="send[title]" class="form-control" placeholder="Title..." value="<?php echo $edit['title'] ?>" />
			</p>
			<p>
			<label><strong>Remaining:</strong></label>
			<input type="text" name="send[remaining]" class="form-control" placeholder="Remaining..."  value="<?php echo $edit['remaining'] ?>" />
			</p>
					
			<p>
			<button type="submit" class="btn btn-info" name="btnSave">Save Changes</button>
			<a href="<?php echo ADMINCP_URL;?>downloads" class="btn btn-default pull-right">Cancel</a>
			</p>
			</div>
			<?php } ?>



		</form>
		</div>



	</div>
    
  </div>
</div>
