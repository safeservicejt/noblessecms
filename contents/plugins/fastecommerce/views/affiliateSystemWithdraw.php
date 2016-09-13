
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Request details</h4>
      </div>
      <div class="modal-body">
        <span>Withdraw <span class="text-success total_money_request">$67.67</span> via:</span>
        <hr>
        <p>
        	<div class="payment_details"></div>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="panel panel-default">

  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<h3>Lastest withdraws</h3>
    	<hr>
		    <div class="row">
		    	<div class="col-lg-12">
					<table class="table table-hover">
						<thead>
							<tr>
								<td class="col-lg-2 col-md-2 col-sm-2 "><strong>Date Added</strong></td>
								<td class="col-lg-5 col-md-5 col-sm-5 "><strong>Information</strong></td>
								<td class="col-lg-3 col-md-3 col-sm-3 text-right"><strong>Status</strong></td>
								<td class="col-lg-2 col-md-2 col-sm-2 text-right"><strong>#</strong></td>
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

								$status='<strong class="text-warning">Pending</strong>';

								if($theList[$i]['status']=='canceled')
								{
									$status='<strong class="text-danger">Canceled</strong>';
								}
								elseif($theList[$i]['status']=='completed')
								{
									$status='<strong class="text-success">Completed</strong>';
								}

								$li.='
								<tr>
									<td>'.date('M d, Y',strtotime($theList[$i]['date_added'])).'</td>
									<td><span data-toggle="modal" data-target="#myModal" class="text-success btn-show-details" data-id="'.$theList[$i]['id'].'" data-userid="'.$theList[$i]['userid'].'">'.FastEcommerce::money_format($theList[$i]['money']).'</span></td>
									<td class="text-right"><span  data-id="'.$theList[$i]['id'].'" data-userid="'.$theList[$i]['userid'].'" data-toggle="modal" data-target="#myModal">'.$status.'</span></td>
									<td class="text-right">
									<a  data-id="'.$theList[$i]['id'].'" data-userid="'.$theList[$i]['userid'].'" data-toggle="modal" data-target="#myModal"  class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-list-alt"></span></a>
									<a href="'.System::getUrl().'admincp/plugins/privatecontroller/fastecommerce/affiliate/withdraw/set/completed/'.$theList[$i]['id'].'" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok-sign"></span></a>
									<a href="'.System::getUrl().'admincp/plugins/privatecontroller/fastecommerce/affiliate/withdraw/set/cancel/'.$theList[$i]['id'].'" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove-sign"></span></a>
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


<script type="text/javascript">
	
var api_url='<?php echo System::getUrl();?>api/plugin/fastecommerce/';

$(document).ready(function(){

	$('.btn-show-details').click(function(){

		var id=$(this).data('id');

		var userid=$(this).data('userid');

	    var request = new XMLHttpRequest();
	    request.open('POST', api_url+'get_withdraw_details', true);
	    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

	    request.onload = function() {
	      if (request.status >= 200 && request.status < 400) {
	        // Success!
	        // var data = JSON.parse(request.responseText);
	        var msg = JSON.parse(request.responseText);

	        if(msg['error']=='yes')
	        {
	        	alert('Error.');
	        }
	        else
	        {
	        	$('.total_money_request').html(msg['data']['total_money_requestFormat']);

	        	$('.payment_details').html(msg['data']['payment_details']);
	        }

	      } else {
	        // We reached our target server, but it returned an error
	       
	      }
	    };

	    request.onerror = function() {
	      // There was a connection error of some sort
	       
	    };

	    request.send("send_id="+id+"&send_userid="+userid);		

	});

});	
</script>