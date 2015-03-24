
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Affiliate Information</h3>
  </div>
  <div class="panel-body">
    

<div class="row">
<form action="" method="post" enctype="multipart/form-data">

		<div class="col-lg-12">
			
		<!-- row -->
		<div class="row">
			<div class="col-lg-5">
			<strong>Your affiliate url</strong>
			</div>
			<div class="col-lg-7">
			<a href="<?php echo ROOT_URL;?>affiliate/<?php echo Session::get('userid');?>"><?php echo ROOT_URL;?>affiliate/<?php echo Session::get('userid');?></a>
			</div>

		</div>
		<!-- row -->
		<!-- row -->
		<div class="row" style="margin-top:30px;">
			<div class="col-lg-5">
			<strong>Commission</strong>
			</div>
			<div class="col-lg-7">
			<span><?php echo $edit['commission'];?> %</span>
			</div>

		</div>
		<!-- row -->

		<!-- row -->
		<div class="row" style="margin-top:30px;">
			<div class="col-lg-5">
			<strong>Total earned</strong>
			</div>
			<div class="col-lg-7">
			<span><?php echo $edit['earnedFormat'];?></span>

			<?php
			if((double)$edit['earned'] > 0)
			{
				echo '&nbsp;&nbsp;&nbsp;<a href="'.USERCP_URL.'users/rqpayment" class="btn btn-primary btn-xs">Send request payment</a>';
			}

			?>
			</div>

		</div>
		<!-- row -->

		</div>




</form>



	</div>    
  </div>
</div>
