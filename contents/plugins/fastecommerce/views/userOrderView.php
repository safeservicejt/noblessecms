<?php

$status='<span class="text-warning">'.Lang::get('usercp/index.pending').'</span>';

if($orderData['status']=='approved')
{
	$status='<span class="text-success">'.Lang::get('usercp/index.approved').'</span>';
}
elseif($orderData['status']=='shipping')
{
	$status='<span class="text-primary">'.Lang::get('usercp/index.shipping').'</span>';
}
elseif($orderData['status']=='canceled')
{
	$status='<span class="text-default">'.Lang::get('usercp/index.canceled').'</span>';
}
elseif($orderData['status']=='refund')
{
	$status='<span class="text-danger">'.Lang::get('usercp/index.refund').'</span>';
}
elseif($orderData['status']=='completed')
{
	$status='<span class="text-success">'.Lang::get('usercp/index.completed').'</span>';
}
elseif($orderData['status']=='draft')
{
	$status='<span class="text-default" style="color:#999;">'.Lang::get('usercp/index.draft').'</span>';
}

?>

<div class="panel panel-default">

  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<h3><?php echo Lang::get('usercp/index.order');?> #<?php echo $orderData['id'];?> - <?php echo $status;?></h3>
    	<span><?php echo Lang::get('usercp/index.date');?>: <?php echo date('M d, Y H:i',strtotime($orderData['date_added']));?></span>
    	<hr>
		    <div class="row">
		    	<div class="col-lg-3 col-md-3 col-sm-3 text-center">
		    		<div class="text-primary" style="font-size:18px;"><?php echo FastEcommerce::money_format($orderData['total']);?></div>
		    		<span>Total</span>
		    	</div>
		    	<div class="col-lg-1 col-md-1 col-sm-1 text-center">
		    		<div class="text-success" style="font-size:18px;"><?php if(isset($orderData['summary']['vat']))echo $orderData['summary']['vat'];else echo '0';?>%</div>
		    		<span>VAT</span>
		    	</div>
		    	<div class="col-lg-2 col-md-2 col-sm-2 text-center">
		    		<div class="text-danger" style="font-size:18px;"><?php echo FastEcommerce::money_format($orderData['summary']['tax']);?></div>
		    		<span>Tax</span>
		    	</div>
		    	<div class="col-lg-3 col-md-3 col-sm-3 text-center">
		    		<div class="text-warning" style="font-size:18px;"><?php echo $orderData['summary']['payment_method'];?></div>
		    		<span>Payment Method</span>
		    	</div>		    	
		    	<div class="col-lg-3 col-md-3 col-sm-3 text-center">
		    		<div class="text-info" style="font-size:18px;"><?php echo $orderData['summary']['shipping_method'].' '.FastEcommerce::money_format($orderData['summary']['shipping_amount']);?></div>
		    		<span>Shipping Method</span>
		    	</div>

		    	<?php if(isset($orderData['summary']['coupon']['code'])){ ?>
		    	<div class="col-lg-12 margin-top-30 text-center">
		    		<div class="text-success" style="font-size:18px;"><?php echo $orderData['summary']['coupon']['code'];?> - Discount <?php echo Coupons::format($orderData['summary']['coupon']['code']);?></div>
		    		<span>Coupon</span>
		    	</div>
		    	<?php } ?>

		    </div>   
		<h3>Billing</h3>    
		<hr>
		<p>
		<strong>Fullname: <?php echo $billing['firstname'].' '.$billing['lastname'];?></strong>	
		</p>

		<p>
		<span class="text-danger">Phone: <?php echo $billing['phone'];?></span>
		</p>

		<p>
		<span class="text-info">Company: <?php echo $billing['company'];?></span>
		</p>

		<p>
		<span class="text-primary">Address: <?php echo $billing['address_1'];?>, <?php echo $billing['address_2'];?>, <?php echo $billing['city'];?>, <?php echo $billing['postcode'];?>, <?php echo $billing['state'];?>, <?php echo $billing['country'];?> </span>
		</p>
		<hr>		    
		<h3>Shipping to</h3>    
		<hr>
		<p>
		<strong>Fullname: <?php echo $orderData['shipping_firstname'].' '.$orderData['shipping_lastname'];?></strong>	
		</p>

		<p>
		<span class="text-danger">Phone: <?php echo $orderData['shipping_phone'];?></span>
		</p>

		<p>
		<span class="text-info">Company: <?php echo $orderData['shipping_company'];?></span>
		</p>		     
		<h3><?php echo Lang::get('usercp/index.comments');?></h3>    
		<hr>
		<span><?php echo $orderData['comment'];?></span>		     	
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
				<h3><?php echo Lang::get('usercp/index.products');?></h3>
				<hr> 	

				<table class="table table-hover">
					<thead>
						<tr>
							<td class="col-lg-5 col-md-5 col-sm-5 "><strong><?php echo Lang::get('usercp/index.title');?></strong></td>
							<td class="col-lg-2 col-md-2 col-sm-2 "><strong><?php echo Lang::get('usercp/index.price');?></strong></td>
							<td class="col-lg-2 col-md-2 col-sm-2 "><strong><?php echo Lang::get('usercp/index.quantity');?></strong></td>
							<td class="col-lg-3 col-md-3 col-sm-3 text-right"><strong><?php echo Lang::get('usercp/index.total');?></strong></td>
						</tr>
					</thead>

					<tbody>
					<?php

					if(isset($orderData['summary']['cart_product'][0]['id']))
					{
						$li='';

						$total=count($orderData['summary']['cart_product']);

						$status='';

						for ($i=0; $i < $total; $i++) { 

							$prodID=$orderData['summary']['cart_product'][$i]['id'];

							$attr=isset($orderData['summary']['cart_product'][$i]['attr'])?$orderData['summary']['cart_product'][$i]['attr']:'';

							$li.='
							<tr>
								<td class="col-lg-5 col-md-5 col-sm-5 ">
								<a href="'.$orderData['summary']['cart_product'][$i]['url'].'" target="_blank"><strong>'.$orderData['summary']['cart_product'][$i]['title'].'</strong></a>
								<br>
								<span style="color:#999;">'.$attr.'</span>
								</td>
								<td class="col-lg-2 col-md-2 col-sm-2 "><strong class="text-success">'.FastEcommerce::money_format($orderData['summary']['cart_product'][$i]['price']).'</strong></td>
								<td class="col-lg-2 col-md-2 col-sm-2 ">'.number_format($orderData['summary']['cart_product'][$i]['quantity']).'</td>
								<td class="col-lg-3 col-md-3 col-sm-3  text-right"><strong class="text-success">'.FastEcommerce::money_format($orderData['summary']['cart_product'][$i]['total']).'</strong></td>
							</tr>

							';

							if($orderData['status']=='completed' && $totalProd > 0)
							{
								$totalDownload=count($orderData['products'][$prodID]['download_data']);

								$dl='';

								for ($d=0; $d < $totalDownload; $d++) { 
									$dl.='
									<tr>
										<td colspan="3" class="col-lg-12">
										<span class="glyphicon glyphicon-cloud-download" style="color:#999;"></span> <a target="_blank" href="'.Downloads::urlInOrder($orderData['userid'],$orderData['id'],$prodID,$orderData['products'][$prodID]['download_data'][$d]).'"><span>Click here to download file of product.</span></a>
										</td>
									</tr>

									';
								}

								$li.=$dl;
							}

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