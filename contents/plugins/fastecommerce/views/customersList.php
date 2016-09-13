
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Customers</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<form action="" method="post" enctype="multipart/form-data">
    		
     		<!-- row -->
    		<div class="row">
    			<div class="col-lg-12 table-responsive">
    				<table class="table table-hover">
    					<thead>
    						<tr>
    							<td class="col-lg-1"><input type="checkbox" id="selectAll" /></td>
                         
                                <td class="col-lg-10">Information</td>
    							<td class="col-lg-1 text-right">#</td>
    						</tr>
    					</thead>

    					<tbody>
    					<?php
    						$total=count($theList);

    						$li='';

    						if(isset($theList[0]['userid']))
    						for ($i=0; $i < $total; $i++) { 

                                $orders='';


                                $orders='<span style="font-size:13px;color:#888;margin-right:10px;">Id: #'.number_format($theList[$i]['userid']).'</span>';
                                $orders.='<span style="font-size:13px;color:#888;margin-right:10px;">Orders: '.number_format($theList[$i]['orders']).'</span>';
                                $orders.='<span style="font-size:13px;color:#888;margin-right:10px;">Reviews: '.number_format($theList[$i]['reviews']).'</span>';
                                $orders.='<span style="font-size:13px;color:#888;margin-right:10px;">Reviews: '.number_format($theList[$i]['reviews']).'</span>';
                                $orders.='<span style="font-size:13px;color:#888;margin-right:10px;">Commission: '.number_format($theList[$i]['commission']).' %</span>';
                                $orders.='<span style="font-size:13px;color:#888;margin-right:10px;">Balance: '.FastEcommerce::money_format($theList[$i]['balance']).'</span>';

    							$li.='
	    						<!-- tr -->
	    						<tr>
                                    <td class="col-lg-1">
                                        <input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['userid'].'" />
                                    </td>
                                    <td class="col-lg-10"><a target="_blank" href="#">'.$theList[$i]['username'].'</a>

                                    <br>
                                    '.$orders.'
                                    </td>
                                    <td class="col-lg-1 text-right">
                                    <a href="'.System::getAdminUrl().'plugins/privatecontroller/fastecommerce/customer/edit/'.$theList[$i]['userid'].'" class="btn btn-warning btn-xs">Edit</a>
                                    </td>
	    						</tr>    						
	    						<!-- tr -->
    							';
    						}

    						echo $li;
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
    		<!-- row -->
    	</form>
    	</div>
    	
    </div>
  </div>
</div>
