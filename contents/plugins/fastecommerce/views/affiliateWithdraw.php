<div class="panel panel-default">

  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">

		    <div class="row">
		    	<div class="col-lg-6 col-md-6 col-sm-6">
			    	<h3><?php echo Lang::get('usercp/index.withdraw');?></h3>
			    	<hr>

		    		<div class="text-success text-center" style="font-size:32px;"><?php echo FastEcommerce::money_format($userData['balance']);?></div>
		    		<div class="text-center"><span><?php echo Lang::get('usercp/index.balance');?></span></div>
		    	</div>
		    	<div class="col-lg-6 col-md-6 col-sm-6">
			    	<h3><?php echo Lang::get('usercp/index.makeRequestWithdraw');?></h3>
			    	<hr>		    	
			    	<?php echo $requestAlert;?>
			    	<form action="" method="post" enctype="multipart/form-data">
				    <div class="input-group">
				      <input type="text" class="form-control" name="money_request" value="0.00" required>
				      <span class="input-group-btn">
				        <button class="btn btn-primary" name="btnSend" type="submit"><?php echo Lang::get('usercp/index.request');?></button>
				      </span>
				    </div><!-- /input-group -->
				    </form>
		    	</div>
		    </div>    	
    	</div>
    </div>
  </div>
</div>

<div class="panel panel-default">

  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<h3><?php echo Lang::get('usercp/index.lastestWithdraws');?></h3>
    	<hr>
		    <div class="row">
		    	<div class="col-lg-12">
					<table class="table table-hover">
						<thead>
							<tr>
								<td class="col-lg-3 col-md-3 col-sm-3 "><strong><?php echo Lang::get('usercp/index.dateAdded');?></strong></td>
								<td class="col-lg-6 col-md-6 col-sm-6 text-center"><strong><?php echo Lang::get('usercp/index.total');?></strong></td>
								<td class="col-lg-3 col-md-3 col-sm-3 text-right"><strong><?php echo Lang::get('usercp/index.status');?></strong></td>
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

								$status='<strong class="text-warning">'.Lang::get('usercp/index.pending').'</strong>';

								if($theList[$i]['status']=='canceled')
								{
									$status='<strong class="text-danger">'.Lang::get('usercp/index.canceled').'</strong>';
								}
								elseif($theList[$i]['status']=='completed')
								{
									$status='<strong class="text-success">'.Lang::get('usercp/index.completed').'</strong>';
								}

								$li.='
								<tr>
									<td class="col-lg-3 col-md-3 col-sm-3 ">'.date('M d, Y',strtotime($theList[$i]['date_added'])).'</td>
									<td class="col-lg-6 col-md-6 col-sm-6 text-center"><strong class="text-success">'.FastEcommerce::money_format($theList[$i]['money']).'</strong></td>
									<td class="col-lg-3 col-md-3 col-sm-3 text-right">'.$status.'</td>
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
