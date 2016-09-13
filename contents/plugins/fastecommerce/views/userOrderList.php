<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo Lang::get('usercp/index.order');?></h3>
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
                            <option value="delete"><?php echo Lang::get('usercp/index.delete');?></option>
                        </select>
                       <span class="input-group-btn">
                        <button class="btn btn-primary" name="btnAction" type="submit"><?php echo Lang::get('usercp/index.apply');?></button>
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
                                <td class="col-lg-3 col-md-3 col-sm-3 "><strong><?php echo Lang::get('usercp/index.order');?></strong></td>
                                <td class="col-lg-2 col-md-2 col-sm-2 "><strong><?php echo Lang::get('usercp/index.date');?></strong></td>
                                <td class="col-lg-3 col-md-3 col-sm-3 "><strong><?php echo Lang::get('usercp/index.total');?></strong></td>
                                <td class="col-lg-2 col-md-2 col-sm-2 "><strong><?php echo Lang::get('usercp/index.status');?></strong></td>
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

                                $status='<strong class="text-warning">'.Lang::get('usercp/index.pending').'</strong>';

                                if($theList[$i]['status']=='approved')
                                {
                                    $status='<strong class="text-success">'.Lang::get('usercp/index.approved').'</strong>';
                                }
                                elseif($theList[$i]['status']=='shipping')
                                {
                                    $status='<strong class="text-primary">'.Lang::get('usercp/index.shipping').'</strong>';
                                }
                                elseif($theList[$i]['status']=='canceled')
                                {
                                    $status='<strong class="text-default">'.Lang::get('usercp/index.canceled').'</strong>';
                                }
                                elseif($theList[$i]['status']=='refund')
                                {
                                    $status='<strong class="text-danger">'.Lang::get('usercp/index.refund').'</strong>';
                                }
                                elseif($theList[$i]['status']=='completed')
                                {
                                    $status='<strong class="text-success">'.Lang::get('usercp/index.completed').'</strong>';
                                }
                                elseif($theList[$i]['status']=='draft')
                                {
                                    $status='<strong class="text-default" style="color:#999;">'.Lang::get('usercp/index.draft').'</strong>';
                                }

                                $li.='
                                <tr>
                                    <td class="col-lg-3 col-md-3 col-sm-3 "><a href="'.$theList[$i]['url'].'"><strong>Order #'.$theList[$i]['id'].'</strong></a></td>
                                    <td class="col-lg-2 col-md-2 col-sm-2 "><strong>'.date('M d, Y H:i',strtotime($theList[$i]['date_added'])).'</strong></td>                                    
                                    <td class="col-lg-3 col-md-3 col-sm-3 "><strong class="text-success">'.FastEcommerce::money_format($theList[$i]['total']).'</strong></td>                                    
                                    <td class="col-lg-2 col-md-2 col-sm-2 ">'.$status.'</td>

                                    <td class="col-lg-2 col-md-2 col-sm-2 text-right">
                                    <a href="'.System::getUrl().'admincp/plugins/privatecontroller/fastecommerce/order/view/'.$theList[$i]['id'].'" class="btn btn-primary btn-sm" target="_blank">'.Lang::get('usercp/index.view').'</a>
                                    <button type="button" data-href="'.System::getUrl().'admincp/plugins/privatecontroller/fastecommerce/order/cancel/'.$theList[$i]['id'].'" class="btn btn-danger btn-customer-cancel-order btn-sm">'.Lang::get('usercp/index.cancel').'</button>
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
