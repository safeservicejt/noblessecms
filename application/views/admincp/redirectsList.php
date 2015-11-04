<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Redirects list</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-8">
    	<form action="" method="post" enctype="multipart/form-data">
    		<!-- row -->
    		<div class="row">
    			<div class="col-lg-4">
                    <div class="input-group input-group-sm">
                        <select class="form-control" name="action">
                            <option value="delete">Delete</option>
                            <option value="enable">Enable</option>
                            <option value="disable">Disable</option>
                        </select>
                       <span class="input-group-btn">
                        <button class="btn btn-primary" name="btnAction" type="submit">Apply</button>
                      </span>

                    </div><!-- /input-group -->   				
    			</div>
    			<div class="col-lg-4 col-lg-offset-4 text-right">
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
                                <td class="col-lg-4">From Url</td>
    							<td class="col-lg-5">To Url</td>
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

                                $status=((int)$theList[$i]['status']==1)?'<span class="label label-success">Enable</span>':'<span class="label label-danger">Disable</span>';

    							$li.='
	    						<!-- tr -->
	    						<tr>
	    							<td class="col-lg-1">
	    								<input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['id'].'" />
	    							</td>
	    							<td class="col-lg-4">'.$theList[$i]['from_url'].'</td>
                                    <td class="col-lg-5">'.$theList[$i]['to_url'].'</td>
	    							<td class="col-lg-1">'.$status.'</td>
	    							<td class="col-lg-1 text-right">
	    							<a href="'.System::getAdminUrl().'redirects/edit/'.$theList[$i]['id'].'" class="btn btn-warning btn-xs">Edit</a>
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
    	<div class="col-lg-4">
        

        <?php if(!Uri::has('\/edit\/\d+')){ ?>
    		<div class="divAddnew">
            <form action="" method="post" enctype="multipart/form-data"> 
            <?php echo $alert;?>
	     		<h4>Add new</h4>
                <p>
                    <label><strong>Url</strong></label>
                    <input type="text" class="form-control" name="send[from_url]" placeholder="/post/test_post.html" id="txtTitle" />
                </p>
                <p>
                    <label><strong>To url</strong></label>
                    <input type="text" class="form-control" name="send[to_url]" placeholder="http://google.com/" id="txtTitle" />
                </p>
	    		<p>
	    			<label><strong>Status</strong></label>
	    			<select class="form-control" name="send[status]">
                        <option value="1">Activate</option>
                        <option value="0">Deactivate</option>
                    </select>
	    		</p>
                  
	    		<p>
	    			<button type="submit" class="btn btn-primary" name="btnAdd">Add new</button>
	    		</p>   	

                </form>		
    		</div>
            <?php }else{ ?>

    		<div class="divEdit">
            <form action="" method="post" enctype="multipart/form-data"> 
            <?php echo $alert;?>
	     		<h4>Edit</h4>
                <p>
                    <label><strong>Url</strong></label>
                    <input type="text" class="form-control" name="send[from_url]" placeholder="/post/test_post.html" id="txtTitle" />
                </p>
                <p>
                    <label><strong>To url</strong></label>
                    <input type="text" class="form-control" name="send[to_url]" placeholder="http://google.com/" id="txtTitle" />
                </p>
                <p>
                    <label><strong>Status</strong></label>
                    <select class="form-control" name="send[status]">
                        <option value="1">Enable</option>
                        <option value="0">Disable</option>
                    </select>
                </p>

	    		<p>
	    			<button type="submit" class="btn btn-primary" name="btnSave">Save changes</button>
                    <a href="<?php echo System::getAdminUrl();?>redirects" class="btn btn-default pull-right">Back</a>
	    		</p>   		
                </form> 	
    		</div>
            <?php } ?>
        
    	</div>
    	
    </div>
  </div>
</div>

