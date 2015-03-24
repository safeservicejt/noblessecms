<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">List Affiliates</h3>
  </div>
  <div class="panel-body">
    
 <div class="row">

		<div class="col-lg-12">
<!-- Form Action -->


		<!-- List -->
		<div class="row">
			<div class="col-lg-12">

				<table class="table table-hover">
				<thead>
					<tr>
					<td class="col-lg-1">#</td>
					<td class="col-lg-5">Fullname</td>
					<td class="col-lg-3">Earned</td>
					<td class="col-lg-2">Commision</td>
					<td class="col-lg-1"></td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($users);

				$li='';


				if(isset($users[0]['userid']))
				for($i=0;$i<$totalRow;$i++)
				{

					$li.='

					<tr>
					<td>
					<input type="checkbox" name="id[]" value="'.$users[$i]['userid'].'" />
					</td>
					<td>'.$users[$i]['firstname'].' '.$users[$i]['lastname'].'
					</td>
					<td>'.$users[$i]['earnedFormat'].'</td>
					<td>'.$users[$i]['commission'].' %</td>
					<td><a href="'.ROOT_URL.'admincp/affiliates/edit/'.$users[$i]['userid'].'" class="btn btn-xs btn-warning">Edit</a></td>

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