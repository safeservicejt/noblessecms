<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Order</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<form action="" method="post" enctype="multipart/form-data">
    		<!-- row -->
    		<div class="row">
    			<div class="col-lg-3 col-md-3 ">
                    <div class="input-group input-group-sm">
                        <select class="form-control" name="action">
                            <option value="delete">Delete</option>
                            <option value="pending">Set as Pending</option>
                            <option value="shipping">Set as Shipping</option>
                            <option value="approved">Set as Approved</option>
                            <option value="canceled">Set as Canceled</option>
                            <option value="refund">Set as Refund</option>
                            <option value="completed">Set as Completed</option>
                        </select>
                       <span class="input-group-btn">
                        <button class="btn btn-primary" name="btnAction" type="submit">Apply</button>
                      </span>

                    </div><!-- /input-group -->   				
    			</div>
    		</div>
    		<!-- row -->
     		<!-- row -->
    		<div class="row">
    			<div class="col-lg-12 table-responsive">

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td class="col-lg-1 col-md-1 col-sm-1 "><input type="checkbox" id="selectAll" /></td>
                                <td class="col-lg-5 col-md-5 col-sm-5 "><strong>Order ID</strong></td>
                                <td class="col-lg-2 col-md-2 col-sm-2 "><strong>Total</strong></td>
                                <td class="col-lg-2 col-md-2 col-sm-2 "><strong>Status</strong></td>
                                <td class="col-lg-2 col-md-2 col-sm-2 text-right"><strong>Action</strong></td>
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

                                if($theList[$i]['status']=='approved')
                                {
                                    $status='<strong class="text-success">Approved</strong>';
                                }
                                elseif($theList[$i]['status']=='shipping')
                                {
                                    $status='<strong class="text-primary">Approved</strong>';
                                }
                                elseif($theList[$i]['status']=='canceled')
                                {
                                    $status='<strong class="text-default">Approved</strong>';
                                }
                                elseif($theList[$i]['status']=='refund')
                                {
                                    $status='<strong class="text-danger">Approved</strong>';
                                }
                                elseif($theList[$i]['status']=='completed')
                                {
                                    $status='<strong class="text-success">Approved</strong>';
                                }
                                elseif($theList[$i]['status']=='draft')
                                {
                                    $status='<strong class="text-default" style="color:#999;">Draft</strong>';
                                }
                                $li.='
                                <tr>
                                    <td class="col-lg-1 col-md-1 col-sm-1 "><input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['id'].'" /></td>
                                    <td class="col-lg-5 col-md-5 col-sm-5 "><a href="df"><strong>#'.$theList[$i]['id'].'</strong></a>
                                    <br>
                                    <span style="color:#999;font-size:13px;">Date added: '.date('M d, Y H:i',strtotime($theList[$i]['date_added'])).'</span>
                                    </td>
                                    <td class="col-lg-2 col-md-2 col-sm-2 "><strong class="text-success">'.FastEcommerce::money_format($theList[$i]['total']).'</strong></td>                                    
                                    <td class="col-lg-2 col-md-2 col-sm-2 ">'.$status.'</td>

                                    <td class="col-lg-2 col-md-2 col-sm-2 text-right"><a href="'.System::getUrl().'admincp/plugins/privatecontroller/fastecommerce/order/view/'.$theList[$i]['id'].'" class="btn btn-primary btn-sm" target="_blank">View</a>
                                    <button type="button" class="btn btn-danger btn-sm btn-remove-order" data-id="4">Remove</button>
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
    		<!-- row -->
    	</form>
    	</div>
    	
    </div>
  </div>
</div>
