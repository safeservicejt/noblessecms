<div class="panel panel-default">

  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<h3>Statistics</h3>
    	<hr>
		    <div class="row">
		    	<div class="col-lg-3 col-md-3 col-sm-3 text-center">
		    		<div class="text-success" style="font-size:32px;"><?php echo $order;?></div>
		    		<span>Orders</span>
		    	</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 text-center">
		    		<div class="text-info" style="font-size:32px;"><?php echo FastEcommerce::money_format($sale);?></div>
		    		<span>Sales</span>
		    	</div>
		    	<div class="col-lg-3 col-md-3 col-sm-3 text-center">
		    		<div class="text-warning" style="font-size:32px;"><?php echo $customer;?></div>
		    		<span>Customers</span>
		    	</div>
		    	<div class="col-lg-2 col-md-2 col-sm-2 text-center">
		    		<div class="text-primary" style="font-size:32px;"><?php echo $product;?></div>
		    		<span>Products</span>
		    	</div>
		    </div>    	
    	</div>
    </div>
  </div>
</div>

<!-- row -->
<div class="row">
	<div class="col-lg-4 col-md-4 col-sm-4">

		<div class="panel panel-default">

		  <div class="panel-body">
		    <div class="row">
		    	<div class="col-lg-12">
				<h3>Recent Activity</h3>
				<hr>  	
		    	</div>
		    </div>
		  </div>
		</div>		
	</div>
	<div class="col-lg-8 col-md-8 col-sm-8">
	
		<div class="panel panel-default">

		  <div class="panel-body">
		    <div class="row">
		    	<div class="col-lg-12">
				<h3>Latest Orders</h3>
				<hr> 	

				<table class="table table-hover">
					<thead>
						<tr>
							<td class="col-lg-4 col-md-4 col-sm-4 "><strong>Order ID</strong></td>
							<td class="col-lg-3 col-md-3 col-sm-3 "><strong>Status</strong></td>
							<td class="col-lg-3 col-md-3 col-sm-3 "><strong>Total</strong></td>
							<td class="col-lg-2 col-md-2 col-sm-2 text-right"><strong>Action</strong></td>
						</tr>
					</thead>

					<tbody>
					<?php

					if(isset($listOrders[0]['id']))
					{
						$li='';

						$total=count($listOrders);

						$status='';

						for ($i=0; $i < $total; $i++) { 

							$status='<strong class="text-warning">Pending</strong>';

							if($listOrders[$i]['status']=='approved')
							{
								$status='<strong class="text-success">Approved</strong>';
							}
							elseif($listOrders[$i]['status']=='shipping')
							{
								$status='<strong class="text-primary">Shipping</strong>';
							}
							elseif($listOrders[$i]['status']=='canceled')
							{
								$status='<strong class="text-default">Canceled</strong>';
							}
							elseif($listOrders[$i]['status']=='refund')
							{
								$status='<strong class="text-danger">Refund</strong>';
							}
							elseif($listOrders[$i]['status']=='completed')
							{
								$status='<strong class="text-success">Completed</strong>';
							}
							elseif($listOrders[$i]['status']=='draft')
							{
								$status='<strong class="text-default" style="color:#999;">Draft</strong>';
							}
							
							$li.='
							<tr>
								<td class="col-lg-4 col-md-4 col-sm-4 "><a href="df"><strong>#'.$listOrders[$i]['id'].'</strong></a>
								<br>
								<span style="color:#999;font-size:13px;">Date added: '.date('M d, Y H:i',strtotime($listOrders[$i]['date_added'])).'</span>
								</td>
								<td class="col-lg-3 col-md-3 col-sm-3 ">'.$status.'</td>
								<td class="col-lg-3 col-md-3 col-sm-3 "><strong class="text-success">'.FastEcommerce::money_format($listOrders[$i]['total']).'</strong></td>
								<td class="col-lg-2 col-md-2 col-sm-2 text-right"><a href="'.System::getUrl().'admincp/plugins/privatecontroller/fastecommerce/order/view/'.$listOrders[$i]['id'].'" class="btn btn-primary btn-sm" target="_blank">View</a></td>
							</tr>

							';
						}

						echo $li;
					}
					?>						
					</tbody>
				</table>
		    	</div>
		    </div>
		  </div>
		</div>				
	</div>
</div> 
<!-- row -->
