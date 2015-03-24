<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">List pages</h3>
  </div>
  <div class="panel-body">
<div class="row">
		<div class="col-lg-12">
<!-- Form Action -->
		<div class="row">
		<form action="" method="post">
		<div class="col-lg-2">
			<select class="form-control" name="action">
			<option value="delete">Delete</option>
			<option value="publish">Set as publish</option>
			<option value="unpublish">Set as unpublish</option>
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
					<td class="col-lg-9">Title</td>
					<td class="col-lg-1">Status</td>
					<td class="col-lg-1"></td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($listPages);

				$li='';

				$status='<span class="label label-danger">Pending</span>';

				if(isset($listPages[0]['pageid']))
				for($i=0;$i<$totalRow;$i++)
				{

					$status='<span class="label label-danger">Pending</span>';
					
					if((int)$listPages[$i]['status']==1)
					{
						$status='<span class="label label-success">Publish</span>';
					}

					$li.='

					<tr>
					<td>
					<input type="checkbox" name="id[]" value="'.$listPages[$i]['nodeid'].'" />
					</td>
					<td><strong>'.stripslashes($listPages[$i]['title']).'</strong>
					</td>
					<td>'.$status.'</td>

					<td><a href="'.USERCP_URL.'pages/edit/'.$listPages[$i]['nodeid'].'" class="btn btn-xs btn-warning">Edit</a></td>

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






	</div>    
    
  </div>
</div>