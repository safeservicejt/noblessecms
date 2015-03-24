<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">List reviews</h3>
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
					<td class="col-lg-2">Fullname</td>
					<td class="col-lg-2">Email</td>
					<td class="col-lg-4">Product</td>
					<td class="col-lg-1">Status</td>

					<td class="col-lg-1"></td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($listData);

				$li='';

				$status='';

				if(isset($listData[0]['reviewid']))
				for($i=0;$i<$totalRow;$i++)
				{

					$status='<span class="label label-danger">Pending</span>';

					if($listData[$i]['status']=='approved')
					{
						$status='<span class="label label-success">Approved</span>';

					}



					$li.='

					<tr>
					<td>
					<input type="checkbox" id="cboxID" name="id[]" value="'.$listData[$i]['reviewid'].'" />
					</td>
					<td><strong>'.stripslashes($listData[$i]['date_added']).'</strong>
					<td><strong>'.$listData[$i]['firstname'].' '.$listData[$i]['lastname'].'</strong>
					<td><strong>'.$listData[$i]['email'].'</strong>
					<td><strong>'.stripslashes($listData[$i]['title']).'</strong>
					</td>
					<td>'.$status.'</td>
					<td><a href="'.ROOT_URL.'admincp/reviews/view/'.$listData[$i]['reviewid'].'" class="btn btn-xs btn-warning">View</a></td>

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