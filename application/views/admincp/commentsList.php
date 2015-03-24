<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">List comments</h3>
  </div>
  <div class="panel-body">
<div class="row">
		<div class="col-lg-12">
<!-- Form Action -->
		<div class="row">
		<form action="" method="post" enctype="multipart/form-data">
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
					<td class="col-lg-2">Date added</td>
					<td class="col-lg-8">Fullname</td>
					<td class="col-lg-1">Status</td>

					<td class="col-lg-1"></td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($listData);

				$li='';

				$status='';

				if(isset($listData[0]['commentid']))
				for($i=0;$i<$totalRow;$i++)
				{

					$status='<span class="label label-danger">Pending</span>';

					if((int)$listData[$i]['status']==1)
					{
						$status='<span class="label label-success">Approved</span>';

					}



					$li.='

					<tr>
					<td>
					<input type="checkbox" id="cboxID" name="id[]" value="'.$listData[$i]['commentid'].'" />
					</td>
					<td><strong>'.stripslashes($listData[$i]['date_added']).'</strong>
					<td><strong>'.stripslashes($listData[$i]['fullname']).'</strong>

					</td>
					<td>'.$status.'</td>
					<td><a href="'.ROOT_URL.'admincp/comments/view/'.$listData[$i]['commentid'].'" class="btn btn-xs btn-warning">View</a></td>

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