
<div class="panel panel-default">

  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">

		<h3>Your rank: <span class="text-primary"><?php echo $rankData['title'];?></span> (<span class="text-success"><?php echo $commission;?>%</span>)</h3>
   	
    	<h3><?php echo Lang::get('usercp/index.statistics');?> </h3>
    	<hr>
		    <div class="row">
		    	<div class="col-lg-3 col-md-3 col-sm-3 text-center">
		    		<div class="text-primary" style="font-size:28px;"><?php echo number_format($clicks);?></div>
		    		<span><?php echo Lang::get('usercp/index.clicks');?></span>
		    	</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 text-center">
		    		<div class="text-success" style="font-size:28px;"><?php echo FastEcommerce::money_format($balance);?></div>
		    		<span><?php echo Lang::get('usercp/index.earned');?></span>
		    	</div>
		    	<div class="col-lg-2 col-md-2 col-sm-2 text-center">
		    		<div class="text-danger" style="font-size:28px;"><?php echo number_format($order_completed);?></div>
		    		<span><?php echo Lang::get('usercp/index.ordersCompleted');?></span>
		    	</div>
		    	<div class="col-lg-3 col-md-3 col-sm-3 text-center">
		    		<div class="text-warning" style="font-size:28px;"><?php echo FastEcommerce::money_format($withdrawed);?></div>
		    		<span><?php echo Lang::get('usercp/index.withdrawSuccess');?></span>
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
				<h3><?php echo Lang::get('usercp/index.earneds');?></h3>
				<hr> 	

				<table class="table table-hover">
					<thead>
						<tr>
							<td class="col-lg-2 col-md-2 col-sm-2 "><strong><?php echo Lang::get('usercp/index.dateAdded');?></strong></td>
							<td class="col-lg-3 col-md-3 col-sm-3 "><strong><?php echo Lang::get('usercp/index.orderTotal');?></strong></td>
							<td class="col-lg-3 col-md-3 col-sm-3 text-center"><strong><?php echo Lang::get('usercp/index.commission');?></strong></td>
							<td class="col-lg-4 col-md-4 col-sm-4 text-right"><strong><?php echo Lang::get('usercp/index.earned');?></strong></td>
						</tr>
					</thead>

					<tbody>
					<?php

					if(isset($theList[0]['id']))
					{
						$li='';

						$total=count($theList);

						$status='';

						for ($i=0; $i < $total; $i++) { 

							$li.='
							<tr>
							<td>'.date('M d, Y H:i',strtotime($theList[$i]['date_added'])).'</td>
							<td class="">'.FastEcommerce::money_format($theList[$i]['orderData']['total']).'</td>
							<td class="text-center">'.$theList[$i]['orderData']['commission'].'%</td>
							<td class="text-right">'.FastEcommerce::money_format($theList[$i]['orderData']['money']).'</td>
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