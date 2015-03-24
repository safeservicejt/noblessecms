  <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/admincp/css/chosen.min.css">

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Currency</h3>
  </div>
  <div class="panel-body">
    <div class="row">
		<div class="col-lg-7 showBorderRight">
		<p>
			<h4>List currency</h4>
		</p>

<!-- Form Action -->
		<div class="row">
		<form action="" method="post">
		<div class="col-lg-5">
			<select class="form-control" name="action">
			<option value="delete">Xóa</option>
			</select>
		</div>
		<div class="col-lg-2">
			<button type="submit" class="btn btn-primary" name="btnAction">Thực hiện</button>
		</div>

		</div>

		<!-- List -->
		<div class="row">
			<div class="col-lg-12">

				<table class="table">
				<thead>
					<tr>
					<td class="col-lg-1">#</td>
					<td class="col-lg-6">Title</td>
					<td class="col-lg-1">Code</td>
					<td class="col-lg-3">Value</td>
						<td class="col-lg-1"></td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($theList);

				$li='';

				if(isset($theList[0]['currencyid']))
				for($i=0;$i<$totalRow;$i++)
				{
					$li.='

					<tr>
					<td>
					<input type="checkbox" name="id[]" value="'.$theList[$i]['currencyid'].'" />
					</td>

					<td>'.$theList[$i]['title'].'</td>
					<td>'.$theList[$i]['code'].'</td>
					<td>'.Render::numberFormat($theList[$i]['dataValue']).'</td>

					<td><a href="'.ROOT_URL.'admincp/currency/edit/'.$theList[$i]['currencyid'].'" class="btn btn-xs btn-warning">Edit</a></td>

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
			<h4>Add new currency</h4>
			</p>
			<?php echo $alert;?>
			<p>
			<label><strong>Title:</strong></label>
			<input type="text" name="send[title]" class="form-control" placeholder="Currency title..." />
			</p>
			<p>
			<label><strong>Code:</strong></label>
			<input type="text" name="send[code]" class="form-control" placeholder="Code..." />
			</p>
			<p>
			<label><strong>Symbol left:</strong></label>
			<input type="text" name="send[symbolLeft]" class="form-control" placeholder="Symbol left..." />
			</p>
			<p>
			<label><strong>Symbol right:</strong></label>
			<input type="text" name="send[symbolRight]" class="form-control" placeholder="Symbol right.." />
			</p>
			<p>
			<label><strong>Value:</strong></label>
			<input type="text" name="send[dataValue]" class="form-control" placeholder="Value..." value="1.0000" />
			</p>
<!-- 			<p>
			<label><strong>Status:</strong></label>
			<select class="form-control" name="send[status]">
			<option value="1">Enable</option><option value="0">Disable</option>
			</select>
			</p>
 -->
			<p>
			<button type="submit" class="btn btn-info" name="btnAdd">Add new</button>
			</p>
			</div>
			<?php } ?>


			<?php if($showEdit=='yes'){ ?>
			<!-- Edit -->
			<div style="display:block;">
			<p>
			<h4>Edit currency</h4>
			</p>
			<?php echo $alert;?>
			<p>
			<label><strong>Title:</strong></label>
			<input type="text" name="send[title]" class="form-control" placeholder="Currency title..." value="<?php echo $edit['title'];?>" />
			</p>
			<p>
			<label><strong>Code:</strong></label>
			<input type="text" name="send[code]" class="form-control" placeholder="Code..." value="<?php echo $edit['code'];?>" />
			</p>
			<p>
			<label><strong>Symbol left:</strong></label>
			<input type="text" name="send[symbolLeft]" class="form-control" placeholder="Symbol left..." value="<?php echo $edit['symbolLeft'];?>" />
			</p>
			<p>
			<label><strong>Symbol right:</strong></label>
			<input type="text" name="send[symbolRight]" class="form-control" placeholder="Symbol right.." value="<?php echo $edit['symbolRight'];?>" />
			</p>
			<p>
			<label><strong>Value:</strong></label>
			<input type="text" name="send[dataValue]" class="form-control" placeholder="Value..." value="<?php echo Render::numberFormat($edit['dataValue']);?>" />
			</p>		
			<p>
			<button type="submit" class="btn btn-info" name="btnSave">Save Changes</button>
			<a class="btn btn-info pull-right" href="<?php echo ROOT_URL;?>admincp/currency">Back</a>

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