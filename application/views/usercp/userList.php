<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">List Users</h3>
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
			<option value="isadmin">Set as administrator</option>
			<option value="notadmin">unSet as administrator</option>
			<option value="approved">Set as approved</option>
			<option value="unapproved">Set as unapproved</option>
			</select>
		</div>
		<div class="col-lg-2">
			<button type="submit" class="btn btn-info" name="btnAction">Apply</button>
		</div>



		</div>

		<!-- List -->
		<div class="row">
			<div class="col-lg-12">

				<table class="table table-hover">
				<thead>
					<tr>
					<td class="col-lg-1">#</td>
					<td class="col-lg-6">Fullname</td>
					<td class="col-lg-3">Email</td>
					<td class="col-lg-1">Status</td>
					<td class="col-lg-1"></td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($users);

				$li='';

				$admin_status='';

				$status='';

				$date_added='';

				if(isset($users[0]['userid']))
				for($i=0;$i<$totalRow;$i++)
				{
					$admin_status='';

					$status='<span class="label label-danger">Pending</span>';

					$admin_status='<span class="label label-danger">'.$users[$i]['group_title'].'</span>';
					if((int)$users[$i]['approved']==1)
					{
						$status='<span class="label label-success">Approved</span>';
					}

					$date_added='<span class="label label-default">Join date: '.$users[$i]['date_added'].'</span>';

					$li.='

					<tr>
					<td>
					<input type="checkbox" name="id[]" value="'.$users[$i]['userid'].'" />
					</td>
					<td>'.$users[$i]['firstname'].' '.$users[$i]['lastname'].'
					<br>
					'.$admin_status.' '.$date_added.'

					</td>
					<td>'.$users[$i]['email'].'</td>
					<td>'.$status.'</td>

					<td><a href="'.ROOT_URL.'admincp/users/edit/'.$users[$i]['userid'].'" class="btn btn-xs btn-warning">Edit</a></td>

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