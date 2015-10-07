<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Code list</h3>
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
                                <td class="col-lg-10">Title</td>

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
	    								<span>'.$theList[$i]['date_addedFormat'].'</span>
	    							</td>

                                    <td class="col-lg-10">
                                    <span>'.$theList[$i]['title'].'</span> <br> <span>Code: [call uri="'.$theList[$i]['friendly_url'].'"]</span>
                                    </td>
                                 
                                    <td class="col-lg-1 text-right">
                                    <a href="'.ADMINCP_URL.'plugins/controller/calltocode/manage/edit/'.$theList[$i]['id'].'" class="btn btn-warning btn-xs">Edit</a>
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

				<div class="col-lg-12 text-right">
					<?php  echo $pages; ?>
				</div>    			
    		</div>
    		<!-- row -->
    	</form>
    	</div>
    	
    </div>
  </div>
</div>

