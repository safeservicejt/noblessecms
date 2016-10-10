<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Contacts list</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<form action="" method="post" enctype="multipart/form-data">
    		<!-- row -->
    		<div class="row">
    			<div class="col-lg-4">
                    <div class="input-group input-group-sm">
                        <select class="form-control" name="action">
                            <option value="delete">Delete</option>

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
                                <td class="col-lg-10">Info</td>

    							<td class="col-lg-1 text-right">#</td>
    						</tr>
    					</thead>

    					<tbody>
    					<?php
    						$total=count($theList);

    						$li='';

    						if(isset($theList[0]['id']))
    						for ($i=0; $i < $total; $i++) { 

    							$li.='
	    						<!-- tr -->
	    						<tr>
                                    <td class="col-lg-1">
                                        <input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['id'].'" />
                                    </td>
 	    							<td class="col-lg-2">
	    								<span style="font-size:14px;color:#888;">'.date('M d, Y H:i',strtotime($theList[$i]['date_added'])).'</span>
	    							</td>

                                    <td class="col-lg-10">
                                    <span>'.$theList[$i]['fullname'].'</span> - <span>Email: '.$theList[$i]['email'].'</span>
                                    </td>
                                 
                                    <td class="col-lg-1 text-right">
                                    <a href="'.System::getAdminUrl().'contacts/view/'.$theList[$i]['id'].'" class="btn btn-warning btn-xs">View</a>
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

