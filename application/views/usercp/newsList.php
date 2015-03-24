<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">List post</h3>
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
			<option value="setFeatured">Set as featured</option>   
			<option value="unsetFeatured">unSet featured</option>   
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
					<td class="col-lg-2">Category</td>
					<td class="col-lg-7">Title</td>
					<td class="col-lg-1">Status</td>
					<td class="col-lg-1"></td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($posts);

				$li='';

				$status='<span class="label label-danger">Pending</span>';

				$views='';

				$date_added='';

				$isFeatured='';

				if(isset($posts[0]['userid']))
				for($i=0;$i<$totalRow;$i++)
				{
					$isFeatured='';

					$status='<span class="label label-danger">Pending</span>';
					
					if((int)$posts[$i]['status']==1)
					{
						$status='<span class="label label-success">Publish</span>';
					}

					$views='<span class="glyphicon glyphicon-eye-open"></span> '.$posts[$i]['views'];

					$date_added='<span class="glyphicon glyphicon-calendar"></span> '.$posts[$i]['date_added'];

					if((int)$posts[$i]['is_featured']==1)
					{
						$isFeatured='<span class="label label-success">Featured</span>';					
					}

					$catid=$posts[$i]['catid'];

					$cattitle=isset($categories[$catid]['cattitle'])?stripslashes($categories[$catid]['cattitle']):'None';

					$li.='

					<tr>
					<td>
					<input type="checkbox" name="id[]" value="'.$posts[$i]['postid'].'" />
					</td>
					<td>'.$cattitle.'</td>
					<td><strong>'.stripslashes($posts[$i]['title']).'</strong>
					<br>
					'.$views.' '.$date_added.' '.$isFeatured.'
					</td>
					<td>'.$status.'</td>

					<td><a href="'.ROOT_URL.'usercp/news/edit/'.$posts[$i]['postid'].'" class="btn btn-xs btn-warning">Edit</a></td>

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