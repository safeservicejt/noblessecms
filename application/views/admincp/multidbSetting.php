  <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/admincp/css/chosen.min.css">

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Multiple Database</h3>
  </div>
  <div class="panel-body">
    <div class="row">
		<div class="col-lg-9 showBorderRight">
		<p>
			<h4>List database</h4>
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
			<button type="submit" class="btn btn-primary" name="btnAction">Apply</button>
		</div>
		<div class="col-lg-7 text-right">
			<button type="submit" class="btn btn-danger" name="btnClear">Reset cache (Total: <?php echo Multidb::getTotalPost();?>)</button>
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
					<td class="col-lg-2">Host</td>
					<td class="col-lg-2">Username</td>
					<td class="col-lg-2">Password</td>
					<td class="col-lg-3">Database name</td>
					<td class="col-lg-1">Port</td>

						<td class="col-lg-1"></td>

					</tr>
				</thead>
				<tbody>

				<?php
				$total=count($theList);

				$li='';

				if(isset($theList[0]['dbhost']))
				for($i=0;$i<$total;$i++)
				{
					$status='<div class="label label-warning">'.$theList[$i]['statusFormat'].'</div>';

					if((int)$theList[$i]['status']==1)
					{
						$status='<div class="label label-primary">'.$theList[$i]['statusFormat'].'</div>';
					}
					$li.='

					<!-- tr -->
						<tr>
						<td class="col-lg-1"><input type="checkbox"  id="cboxID" name="id[]" value="'.$theList[$i]['dbid'].'" /></td>
						<td class="col-lg-2">'.$theList[$i]['dbhost'].'</td>
						<td class="col-lg-2">'.$theList[$i]['dbuser'].'</td>
						<td class="col-lg-2">'.$theList[$i]['dbpassword'].'</td>
						<td class="col-lg-3">'.$theList[$i]['dbname'].'</td>
						<td class="col-lg-1">'.$theList[$i]['dbport'].'</td>

							<td class="col-lg-1"><a href="'.ADMINCP_URL.'setting/multidb/edit/'.$theList[$i]['dbid'].'" class="btn btn-xs btn-warning">Edit</a></td>

						</tr>				
					<!-- tr -->

					';
				}

				echo $li;

				?>


				</tbody>
				</table>
			</div>

		</div>
		</form>



		</div>		


		<div class="col-lg-3">
		<form action="" method="post" enctype="multipart/form-data">

		<input type="hidden" name="send[dbtype]" value="mysqli" />

			<?php if($showEdit=='no'){ ?>
			<!-- Add new -->
			<div style="display:block;">
			<p>
			<h4>Add new database</h4>
			</p>
			<?php echo $alert;?>
			<p>
			<label><strong>Database host:</strong></label>
			<input type="text" name="send[dbhost]" class="form-control" placeholder="Database host..." value="localhost" required />
			</p>
			<p>
			<label><strong>Database name:</strong></label>
			<input type="text" name="send[dbname]" class="form-control" placeholder="Database name..." required />
			</p>
			<p>
			<label><strong>Database port:</strong></label>
			<input type="text" name="send[dbport]" class="form-control" placeholder="Database port..." value="3306" required />
			</p>
			<p>
			<label><strong>Database username:</strong></label>
			<input type="text" name="send[dbuser]" class="form-control" placeholder="Database username..." value="root" required />
			</p>
			<p>
			<label><strong>Database password:</strong></label>
			<input type="text" name="send[dbpassword]" class="form-control" placeholder="Database password..." />
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
			<h4>Edit database</h4>
			</p>
			<?php echo $alert;?>
			<p>
			<label><strong>Database host:</strong></label>
			<input type="text" name="send[dbhost]" class="form-control" placeholder="Database host..." value="<?php echo $edit['dbhost'] ;?>" required />
			</p>
			<p>
			<label><strong>Database name:</strong></label>
			<input type="text" name="send[dbname]" class="form-control" placeholder="Database name..." value="<?php echo $edit['dbname'] ;?>" required />
			</p>
			<p>
			<label><strong>Database port:</strong></label>
			<input type="text" name="send[dbport]" class="form-control" placeholder="Database port..." value="<?php echo $edit['dbport'] ;?>" required />
			</p>
			<p>
			<label><strong>Database username:</strong></label>
			<input type="text" name="send[dbuser]" class="form-control" placeholder="Database username..." value="<?php echo $edit['dbuser'] ;?>" required />
			</p>
			<p>
			<label><strong>Database password:</strong></label>
			<input type="text" name="send[dbpassword]" class="form-control" placeholder="Database password..." value="<?php echo $edit['dbpassword'] ;?>" />
			</p>
			
			<p>
			<button type="submit" class="btn btn-info" name="btnSave">Save Changes</button>
			<a href="<?php echo ADMINCP_URL;?>setting/multidb" class="btn btn-default pull-right">Cancel</a>
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