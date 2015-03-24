<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Orders information

    <div class="pull-right">
      <a href="<?php echo ADMINCP_URL;?>orders" class="btn btn-default btn-xs">Go back</a>

    </div>
    </h3>
  </div>
  <div class="panel-body">
    
 <div class="row">

		<div class="col-lg-12">
		<p>
		<strong>Total: <span class="label label-primary"><?php echo $orders['totalFormat'];?></span></strong>
		</p>
		<p>
		<strong>Order Status: <span class="label label-success"><?php echo ucfirst($orders['order_status']);?></span></strong>
		</p>
		<p>
		<strong>Comment: </strong>
		<?php echo $orders['comment'];?>
		</p>
		</div>		

		<!-- table -->
		<div class="col-lg-12 table-responsive">
		<table class="table table-hover">
		<thead>
			<tr>
			<td class="col-lg-6">Billing Information</td>
			<td class="col-lg-6">Shipping Information</td>
			</tr>
		</thead>

		<tbody>

		<!-- tr -->
		<tr>
			<td>
				<div class="row">
					<div class="col-lg-6">
					Full name:
					</div>	
					<div class="col-lg-6">
					<strong><?php echo $orders['payment_firstname'];?> <?php echo $orders['payment_lastname'];?></strong>
					</div>	
				</div>
			</td>
			<td>
				<div class="row">
					<div class="col-lg-6">
					Full name:
					</div>	
					<div class="col-lg-6">
					<strong><?php echo $orders['shipping_firstname'];?> <?php echo $orders['shipping_lastname'];?></strong>
					</div>	
				</div>
			</td>
			
		</tr>
		<!-- tr -->
		<!-- tr -->
		<tr>
			<td>
				<div class="row">
					<div class="col-lg-6">
					Company:
					</div>	
					<div class="col-lg-6">
					<strong><?php echo $orders['payment_company'];?></strong>
					</div>	
				</div>
			</td>
			<td>
				<div class="row">
					<div class="col-lg-6">
					Company:
					</div>	
					<div class="col-lg-6">
					<strong><?php echo $orders['shipping_company'];?></strong>
					</div>	
				</div>
			</td>
			
		</tr>
		<!-- tr -->
		<!-- tr -->
		<tr>
			<td>
				<div class="row">
					<div class="col-lg-6">
					Address 1:
					</div>	
					<div class="col-lg-6">
					<strong><?php echo $orders['payment_address_1'];?></strong>
					</div>	
				</div>
			</td>
			<td>
				<div class="row">
					<div class="col-lg-6">
					Address 1:
					</div>	
					<div class="col-lg-6">
					<strong><?php echo $orders['shipping_address_1'];?></strong>
					</div>	
				</div>
			</td>
			
		</tr>
		<!-- tr -->
		<!-- tr -->
		<tr>
			<td>
				<div class="row">
					<div class="col-lg-6">
					Address 2:
					</div>	
					<div class="col-lg-6">
					<strong><?php echo $orders['payment_address_2'];?></strong>
					</div>	
				</div>
			</td>
			<td>
				<div class="row">
					<div class="col-lg-6">
					Address 2:
					</div>	
					<div class="col-lg-6">
					<strong><?php echo $orders['shipping_address_2'];?></strong>
					</div>	
				</div>
			</td>
			
		</tr>
		<!-- tr -->

		<!-- tr -->
		<tr>
			<td>
				<div class="row">
					<div class="col-lg-6">
					City:
					</div>	
					<div class="col-lg-6">
					<strong><?php echo $orders['payment_city'];?></strong>
					</div>	
				</div>
			</td>
			<td>
				<div class="row">
					<div class="col-lg-6">
					City:
					</div>	
					<div class="col-lg-6">
					<strong><?php echo $orders['shipping_city'];?></strong>
					</div>	
				</div>
			</td>
			
		</tr>
		<!-- tr -->
		<!-- tr -->
		<tr>
			<td>
				<div class="row">
					<div class="col-lg-6">
					Postcode:
					</div>	
					<div class="col-lg-6">
					<strong><?php echo $orders['payment_postcode'];?></strong>
					</div>	
				</div>
			</td>
			<td>
				<div class="row">
					<div class="col-lg-6">
					Postcode:
					</div>	
					<div class="col-lg-6">
					<strong><?php echo $orders['shipping_postcode'];?></strong>
					</div>	
				</div>
			</td>
			
		</tr>
		<!-- tr -->
		<!-- tr -->
		<tr>
			<td>
				<div class="row">
					<div class="col-lg-6">
					Country:
					</div>	
					<div class="col-lg-6">
					<strong><?php echo $orders['payment_country'];?> </strong>
					</div>	
				</div>
			</td>
			<td>
				<div class="row">
					<div class="col-lg-6">
					Country:
					</div>	
					<div class="col-lg-6">
					<strong><?php echo $orders['shipping_country'];?></strong>
					</div>	
				</div>
			</td>
			
		</tr>
		<!-- tr -->
		<!-- tr -->
		<tr>
			<td>
				<div class="row">
					<div class="col-lg-6">
					Phone:
					</div>	
					<div class="col-lg-6">
					<strong><?php echo $orders['payment_phone'];?> </strong>
					</div>	
				</div>
			</td>
			<td>
				<div class="row">
					<div class="col-lg-6">
					Phone:
					</div>	
					<div class="col-lg-6">
					<strong><?php echo $orders['shipping_phone'];?></strong>
					</div>	
				</div>
			</td>
			
		</tr>
		<!-- tr -->
		<!-- tr -->
		<tr>
			<td>
				<div class="row">
					<div class="col-lg-6">
					Fax:
					</div>	
					<div class="col-lg-6">
					<strong><?php echo $orders['payment_fax'];?> </strong>
					</div>	
				</div>
			</td>
			<td>
				<div class="row">
					<div class="col-lg-6">
					Fax:
					</div>	
					<div class="col-lg-6">
					<strong><?php echo $orders['shipping_fax'];?></strong>
					</div>	
				</div>
			</td>
			
		</tr>
		<!-- tr -->


		</tbody>
		</table>

		</div>
				<!-- table -->


		<!-- table -->
		<div class="col-lg-12 table-responsive">
				<p>
		<strong>Products:</strong>
		</p>	
		<table class="table table-hover">
		<thead>
			<tr>
			<td class="col-lg-5">Product Name</td>
			<td class="col-lg-2">Quantity</td>
			<td class="col-lg-5">Total price</td>

			</tr>
		</thead>

		<tbody>
		<?php
			$total=count($products);

			$li='';
			if(isset($products[0]['nodeid']))
				for($i=0;$i<$total;$i++)
				{
					$li.='

						<!-- row -->
						<tr>
						<td>'.$products[$i]['title'].'</td>
						<td>'.$products[$i]['quantity'].'</td>
						<td>'.$products[$i]['priceFormat'].'</td>
					

						</tr>
						<!-- row -->
							

					';
				}


				echo $li;
		?>

		</tbody>
		</table>

		</div>
				<!-- table -->

		<?php if(isset($downloads)){ ?>
		<!-- table -->
		<div class="col-lg-12 table-responsive">
				<p>
		<strong>Downloads:</strong>
		</p>	
		<table class="table table-hover">
		<thead>
			<tr>
			<td class="col-lg-7">Product Name</td>
			<td class="col-lg-5">Link download</td>

			</tr>
		</thead>

		<tbody>
		<?php
			$total=count($downloads);

			$li='';
			if(isset($downloads[0]['nodeid']))
				for($i=0;$i<$total;$i++)
				{
					$li.='

						<!-- row -->
						<tr>
						<td>'.$downloads[$i]['title'].'</td>
						<td><a href="'.Url::download($downloads[$i]).'" class="btn btn-primary btn-xs">Download</a></td>

						</tr>
						<!-- row -->
							

					';
				}


				echo $li;
		?>

		</tbody>
		</table>

		</div>
				<!-- table -->
		<?php } ?>


	</div>
   
  </div>
</div>