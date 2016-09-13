<div class="panel panel-default">

  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<h3>Statistics</h3>
    	<hr>
		    <div class="row">

		    	<div class="col-lg-3 col-md-3 col-sm-3 text-center">
		    		<div class="text-success" style="font-size:32px;"><?php echo FastEcommerce::money_format($balance);?></div>
		    		<span>Earned</span>
		    	</div>
		    	<div class="col-lg-3 col-md-3 col-sm-3 text-center">
		    		<div class="text-danger" style="font-size:32px;"><?php echo number_format($order_completed);?></div>
		    		<span>Orders Completed</span>
		    	</div>
		    	<div class="col-lg-3 col-md-3 col-sm-3 text-center">
		    		<div class="text-primary" style="font-size:32px;"><?php echo number_format($clicks);?></div>
		    		<span>Withdraw Pending</span>
		    	</div>			    	
		    	<div class="col-lg-3 col-md-3 col-sm-3 text-center">
		    		<div class="text-warning" style="font-size:32px;"><?php echo FastEcommerce::money_format($withdrawed);?></div>
		    		<span>Withdraw Success</span>
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
				<h3>Earneds</h3>
				<hr> 	

				<table class="table table-hover">
					<thead>
						<tr>
							<td class="col-lg-2 col-md-2 col-sm-2 "><strong>Date Added</strong></td>
							<td class="col-lg-3 col-md-3 col-sm-3 "><strong>Order Total</strong></td>
							<td class="col-lg-3 col-md-3 col-sm-3 text-center"><strong>Commission</strong></td>
							<td class="col-lg-4 col-md-4 col-sm-4 text-right"><strong>Earned</strong></td>
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

                <div class="col-lg-5 text-left">
                    <span>Total: <?php echo $totalPost.' of '.$totalPage.' page(s)';?></span>
                </div>              
				<div class="col-lg-7 text-right">
					<?php  echo $pages; ?>
				</div>    		    	
		    </div>
		  </div>
		</div>				
	</div>
</div> 
<!-- row -->