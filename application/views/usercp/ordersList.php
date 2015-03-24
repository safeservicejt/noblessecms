<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">List Orders</h3>
  </div>
  <div class="panel-body">
    
 <div class="row">

		<div class="col-lg-12">

		<!-- List -->
		<div class="row">
			<div class="col-lg-12">

				<table class="table table-hover">
				<thead>
					<tr>
					<td class="col-lg-1">#</td>
					<td class="col-lg-2">Date added</td>					
					<td class="col-lg-2">Fullname</td>

					<td class="col-lg-2">Total Products</td>
					<td class="col-lg-2">Total</td>

					<td class="col-lg-1">Status</td>

					<td class="col-lg-2"></td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($theList);

				$li='';


				if(isset($theList[0]['nodeid']))
				for($i=0;$i<$totalRow;$i++)
				{

					$li.='

					<tr>
					<td>
					<input type="checkbox" name="id[]" value="'.$theList[$i]['nodeid'].'" />
					</td>
					<td>'.Render::dateFormat($theList[$i]['date_added']).'</td>					
					<td>'.$theList[$i]['payment_firstname'].' '.$theList[$i]['payment_lastname'].'
					</td>
					<td>'.$theList[$i]['total_products'].'
					</td>

					<td>'.$theList[$i]['totalFormat'].'</td>
					<td><span class="label label-primary">'.$theList[$i]['order_status'].'</span></td>
					<td><a href="'.ROOT_URL.'usercp/orders/view/'.$theList[$i]['nodeid'].'" class="btn btn-xs btn-danger">Details</a></td>

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