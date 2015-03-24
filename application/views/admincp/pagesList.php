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
			<select class="form-control" name="action" enctype="multipart/form-data">
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
					<input type="checkbox" id="cboxID" name="id[]" value="'.$listPages[$i]['pageid'].'" />
					</td>
					<td><a href="'.Url::page($listPages[$i]).'"><strong>'.$listPages[$i]['title'].'</strong></a>
					</td>
					<td>'.$status.'</td>

					<td><a href="'.ROOT_URL.'admincp/pages/edit/'.$listPages[$i]['pageid'].'" class="btn btn-xs btn-warning">Edit</a></td>

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
		



		</div>		
		</form>





	</div>    
    
  </div>
</div>