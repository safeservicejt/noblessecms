<form action="" method="post" enctype="multipart/form-data">
	

<div class="panel panel-default">

  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<h3>Email Templates</h3>
		<table class="table table-hover margin-top-30">
			<tbody>
				<tr>
					<td class="col-lg-4 col-md-4 col-sn-4 "><a href="<?php echo CtrPlugin::url('setting','edit_email_template');?>contact_customer"><strong>Contact customer</strong></a></td>
					<td class="col-lg-8 col-md-8 col-sn-8 "><span>Sent to customer when you contact them from the orders page.</span></td>
				</tr>
				<tr>
					<td class="col-lg-4 col-md-4 col-sn-4 "><a href="<?php echo CtrPlugin::url('setting','edit_email_template');?>customer_account_welcome"><strong>Customer account welcome</strong></a></td>
					<td class="col-lg-8 col-md-8 col-sn-8 "><span>Sent automatically to customer when they complete their account activation</span></td>
				</tr>
				<tr>
					<td class="col-lg-4 col-md-4 col-sn-4 "><a href="<?php echo CtrPlugin::url('setting','edit_email_template');?>draft_order_invoice"><strong>Draft order invoice</strong></a></td>
					<td class="col-lg-8 col-md-8 col-sn-8 "><span>Sent to customer when a draft invoice created.</span></td>
				</tr>
				<tr>
					<td class="col-lg-4 col-md-4 col-sn-4 "><a href="<?php echo CtrPlugin::url('setting','edit_email_template');?>fulfillment_request"><strong>Fulfillment request</strong></a></td>
					<td class="col-lg-8 col-md-8 col-sn-8 "><span>Sent automatically to a third-party fulfillment service provider when order items are fulfilled.</span></td>
				</tr>
				<tr>
					<td class="col-lg-4 col-md-4 col-sn-4 "><a href="<?php echo CtrPlugin::url('setting','edit_email_template');?>new_order"><strong>New order</strong></a></td>
					<td class="col-lg-8 col-md-8 col-sn-8 "><span>Sent to order notifacation subscribers when a customer place an order.</span></td>
				</tr>
				<tr>
					<td class="col-lg-4 col-md-4 col-sn-4 "><a href="<?php echo CtrPlugin::url('setting','edit_email_template');?>order_canceled"><strong>Order canceled</strong></a></td>
					<td class="col-lg-8 col-md-8 col-sn-8 "><span>Sent automatically to the customer if their order is canceled.</span></td>
				</tr>
				<tr>
					<td class="col-lg-4 col-md-4 col-sn-4 "><a href="<?php echo CtrPlugin::url('setting','edit_email_template');?>order_confirmation"><strong>Order confirmation</strong></a></td>
					<td class="col-lg-8 col-md-8 col-sn-8 "><span>Sent automatically to the customer after they place their order.</span></td>
				</tr>
				<tr>
					<td class="col-lg-4 col-md-4 col-sn-4 "><a href="<?php echo CtrPlugin::url('setting','edit_email_template');?>order_refund"><strong>Order refund</strong></a></td>
					<td class="col-lg-8 col-md-8 col-sn-8 "><span>Sent automatically to the customer if their order refunded.</span></td>
				</tr>
				<tr>
					<td class="col-lg-4 col-md-4 col-sn-4 "><a href="<?php echo CtrPlugin::url('setting','edit_email_template');?>shipping_confirmation"><strong>Shipping confirmation</strong></a></td>
					<td class="col-lg-8 col-md-8 col-sn-8 "><span>Sent automatically to the customer when their order is fulfilled.</span></td>
				</tr>
				<tr>
					<td class="col-lg-4 col-md-4 col-sn-4 "><a href="<?php echo CtrPlugin::url('setting','edit_email_template');?>shipping_update"><strong>Shipping update</strong></a></td>
					<td class="col-lg-8 col-md-8 col-sn-8 "><span>Sent automatically to the customer if their fulfilled order's tracking number is updated.</span></td>
				</tr>
			</tbody>
		</table>
    	</div>
    </div>
  </div>
</div>
</form>