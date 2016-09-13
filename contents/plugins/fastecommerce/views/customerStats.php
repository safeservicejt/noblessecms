<div class="panel panel-default">

  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<h3><?php echo Lang::get('usercp/index.statistics');?></h3>
    	<hr>
		    <div class="row">
		    	<div class="col-lg-2 col-md-2 col-sm-2 text-center">
		    		<div class="text-primary" style="font-size:28px;"><?php echo number_format($order);?></div>
		    		<span><?php echo Lang::get('usercp/index.orders');?></span>
		    	</div>
		    	<div class="col-lg-3 col-md-3 col-sm-3 text-center">
		    		<div class="text-success" style="font-size:28px;"><?php echo number_format($order_pending);?></div>
		    		<span><?php echo Lang::get('usercp/index.ordersCompleted');?></span>
		    	</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 text-center">
		    		<div class="text-info" style="font-size:28px;"><?php echo FastEcommerce::money_format($balance);?></div>
		    		<span><?php echo Lang::get('usercp/index.balance');?></span>
		    	</div>
		    	<div class="col-lg-3 col-md-3 col-sm-3 text-center">
		    		<div class="text-warning" style="font-size:28px;"><?php echo $commission;?>%</div>
		    		<span><?php echo Lang::get('usercp/index.affiliateCommission');?></span>
		    	</div>

		    </div>    	
    	</div>
    </div>
  </div>
</div>

<!-- row -->
<div class="row">
	<div class="col-lg-12">
	
		<div class="panel panel-default">

		  <div class="panel-body">
		    <div class="row">
		    	<div class="col-lg-12">
				<h3><?php echo Lang::get('usercp/index.latestOrders');?></h3>
				<hr> 	

				<table class="table table-hover">
					<thead>
						<tr>
							<td class="col-lg-3 col-md-3 col-sm-3 "><strong><?php echo Lang::get('usercp/index.orderid');?></strong></td>
							<td class="col-lg-2 col-md-2 col-sm-2 "><strong><?php echo Lang::get('usercp/index.date');?></strong></td>
							<td class="col-lg-2 col-md-2 col-sm-2 "><strong><?php echo Lang::get('usercp/index.status');?></strong></td>
							<td class="col-lg-3 col-md-3 col-sm-3 "><strong><?php echo Lang::get('usercp/index.total');?></strong></td>
							<td class="col-lg-2 col-md-2 col-sm-2 text-right"><strong><?php echo Lang::get('usercp/index.action');?></strong></td>
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
								$status='<strong class="text-success">'.Lang::get('usercp/index.approved').'</strong>';
							}
							elseif($listOrders[$i]['status']=='shipping')
							{
								$status='<strong class="text-primary">'.Lang::get('usercp/index.shipping').'</strong>';
							}
							elseif($listOrders[$i]['status']=='canceled')
							{
								$status='<strong class="text-default">'.Lang::get('usercp/index.canceled').'</strong>';
							}
							elseif($listOrders[$i]['status']=='refund')
							{
								$status='<strong class="text-danger">'.Lang::get('usercp/index.refund').'</strong>';
							}
							elseif($listOrders[$i]['status']=='completed')
							{
								$status='<strong class="text-success">'.Lang::get('usercp/index.completed').'</strong>';
							}
							elseif($listOrders[$i]['status']=='draft')
							{
								$status='<strong class="text-default" style="color:#999;">'.Lang::get('usercp/index.draft').'</strong>';
							}

							$li.='
							<tr>
								<td class="col-lg-3 col-md-3 col-sm-3 "><a href="'.$listOrders[$i]['url'].'"><strong>Order #'.$listOrders[$i]['id'].'</strong></a></td>
								<td class="col-lg-2 col-md-2 col-sm-2 ">'.date('M d, Y H:i',strtotime($listOrders[$i]['date_added'])).'</td>
								<td class="col-lg-2 col-md-2 col-sm-2 ">'.$status.'</td>
								<td class="col-lg-3 col-md-3 col-sm-3 "><strong class="text-success">'.FastEcommerce::money_format($listOrders[$i]['total']).'</strong></td>
								<td class="col-lg-2 col-md-2 col-sm-2 text-right">
								<a href="'.System::getUrl().'admincp/plugins/privatecontroller/fastecommerce/order/view/'.$listOrders[$i]['id'].'" class="btn btn-primary btn-sm" target="_blank">'.Lang::get('usercp/index.view').'</a>
                                <button type="button" data-href="'.System::getUrl().'admincp/plugins/privatecontroller/fastecommerce/order/cancel/'.$listOrders[$i]['id'].'" class="btn btn-danger btn-customer-cancel-order btn-sm">'.Lang::get('usercp/index.cancel').'</button>
								</td>
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