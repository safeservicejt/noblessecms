
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Reviews</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<form action="" method="post" enctype="multipart/form-data">
    		<!-- row -->
    		<div class="row">
    			<div class="col-lg-3">
                    <div class="input-group input-group-sm">
                        <select class="form-control" name="action">
                            <option value="delete">Delete</option>
                            <option value="deleteall">Delete All</option>
                            <option value="publish">Publish</option>
                            <option value="unpublish">unPublish</option>
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
    							<td class="col-lg-1"><input type="checkbox" id="selectAll" /></td>
                         
                                <td class="col-lg-2">Date added</td>
                                <td class="col-lg-8">Information</td>
                                <td class="col-lg-1 text-right">Status</td>
    						</tr>
    					</thead>

    					<tbody>
    					<?php
    						$total=count($theList);

    						$li='';

    						if(isset($theList[0]['id']))
    						for ($i=0; $i < $total; $i++) { 

                                $date_added='<span title="Click to release this product" class="pointer product-release" data-id="'.$theList[$i]['id'].'" style="font-size:13px;color:#888;margin-right:10px;">Date: '.date('M d, Y H:i',strtotime($theList[$i]['date_added'])).'</span>';

                                $status='<span class="pointer product-status" data-type="unpublish" data-id="'.$theList[$i]['id'].'" style="font-size:13px;color:green;">Activated</span>';


                                if((int)$theList[$i]['status']==0)
                                {
                                    $status='<span class="pointer product-status" data-type="unpublish" data-id="'.$theList[$i]['id'].'" style="font-size:13px;color:red;">Deactivated</span>';
                                }


    							$li.='
	    						<!-- tr -->
	    						<tr>
	    							<td class="col-lg-1">
	    								<input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['id'].'" />
	    							</td>
                                    <td class="col-lg-2">
                                    '.$date_added.'
                                    </td>
                                    <td class="col-lg-8">
                                    '.$theList[$i]['user']['username'].' wrote: <span style="color:#999;">'.$theList[$i]['content'].'</span> on <a href="'.$theList[$i]['product']['url'].'" target="_blank">'.$theList[$i]['product']['title'].'</a>
                                    </td>
                                    <td class="col-lg-1 text-right">'.$status.'</td>
                                   
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
