<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">List Customers</h3>
  </div>
  <div class="panel-body">
    
 <div class="row">

		<div class="col-lg-12">
<!-- Form Action -->
		<div class="row">
		<form action="" method="post">
		<div class="col-lg-10">
			<select class="form-control" name="action">
			<option value="delete">Delete</option>
			<option value="isaff">Set as affiliate</option>
			<option value="notaff">unSet as affiliate</option>
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

				<table class="table">
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

				$totalRow=count($customers);

				$li='';

				$admin_status='';

				$affiliate_status='';

				$status='';

				$date_added='';



				if(isset($customers[0]['customerid']))
				for($i=0;$i<$totalRow;$i++)
				{
					$admin_status='';

					$affiliate_status='';

					$status='<span class="label label-danger">Pending</span>';

					if((int)$customers[$i]['is_admin']==1)
					{
						$admin_status='<span class="label label-danger">Administrator</span>';
					}
					if((int)$customers[$i]['is_affiliate']==1)
					{
						$affiliate_status='<span class="label label-info">Affiliate</span>';
					}
					if((int)$customers[$i]['approved']==1)
					{
						$status='<span class="label label-success">Approved</span>';
					}

					$date_added='<span class="label label-default">Join date: '.$customers[$i]['date_added'].'</span>';

					$li.='

					<tr>
					<td>
					<input type="checkbox" name="id[]" value="'.$customers[$i]['customerid'].'" />
					</td>
					<td>'.$customers[$i]['firstname'].' '.$customers[$i]['lastname'].'
					<br>
					'.$admin_status.' '.$affiliate_status.' '.$date_added.'

					</td>
					<td>'.$customers[$i]['email'].'</td>
					<td>'.$status.'</td>

					<td><a href="'.ROOT_URL.'admincp/customers/edit/'.$customers[$i]['customerid'].'" class="btn btn-xs btn-warning">Edit</a></td>

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