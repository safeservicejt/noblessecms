
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Affiliates</h3>
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
                        </select>
                       <span class="input-group-btn">
                        <button class="btn btn-primary" name="btnAction" type="submit">Apply</button>
                      </span>

                    </div><!-- /input-group -->   				
    			</div>
    			<div class="col-lg-4 col-lg-offset-5 text-right">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" name="txtKeywords" placeholder="Search..." />
                       <span class="input-group-btn">
                        <button class="btn btn-primary" name="btnSearch" type="submit">Search</button>
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
                         
                                <td class="col-lg-9">Information</td>
                                <td class="col-lg-1 text-right">Status</td>
    							<td class="col-lg-1 text-right">#</td>
    						</tr>
    					</thead>

    					<tbody>
    					<?php
    						$total=count($theList);

    						$li='';

    						if(isset($theList[0]['id']))
    						for ($i=0; $i < $total; $i++) { 

                                $date_added='<span title="Click to release this product" class="pointer product-release" data-id="'.$theList[$i]['id'].'" style="font-size:13px;color:#888;margin-right:10px;">Date: '.date('M d, Y H:i',strtotime($theList[$i]['date_added'])).'</span>';

                                $status='<span title="Click to unPublish this product" class="pointer product-status" data-type="unpublish" data-id="'.$theList[$i]['id'].'" style="font-size:13px;color:green;">'.ucfirst($theList[$i]['status']).'</span>';


                                $featured='';
                                if((int)$theList[$i]['is_featured']==1)
                                {
                                    $featured='<span title="Click to unFeatured this product" class="pointer product-featured" data-type="unfeatured" data-id="'.$theList[$i]['id'].'" style="font-size:13px;color:green;margin-right:10px;">Featured</span>';
                                }


                                $views='<span style="font-size:13px;color:#888;margin-right:10px;"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;&nbsp;'.number_format($theList[$i]['views']).'</span>';
    							$li.='
	    						<!-- tr -->
	    						<tr>
	    							<td class="col-lg-1">
	    								<input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['id'].'" />
	    							</td>
                                    <td class="col-lg-9"><a target="_blank" href="'.$theList[$i]['url'].'">'.$theList[$i]['title'].'</a>

                                    <br>
                                    '.$featured.' '.$date_added.' '.$views.'
                                    </td>
                                    <td class="col-lg-1 text-right">'.$status.'</td>
                                    <td class="col-lg-1 text-right">
                                    <a href="'.System::getAdminUrl().'plugins/privatecontroller/fastecommerce/product/edit/'.$theList[$i]['id'].'" class="btn btn-warning btn-xs">Edit</a>
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
