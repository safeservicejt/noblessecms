<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Page list</h3>
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
                            <option value="publish">Publish</option>
                            <option value="unpublish">unPublish</option>
                            <option value="allowcomment">Allow comment</option>
                            <option value="unallowcomment">Not allow comment</option>
                            <option value="ishomepage">Set is homepage</option>

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
                                <td class="col-lg-9">Title</td>
                                <td class="col-lg-1 text-right">Status</td>
    							<td class="col-lg-1 text-right">#</td>
    						</tr>
    					</thead>

    					<tbody>
    					<?php
    						$total=count($theList);

    						$li='';

    						if(isset($theList[0]['pageid']))
    						for ($i=0; $i < $total; $i++) { 

                                $status='<span style="font-size:13px;color:green;">Publish</span>';

                                if((int)$theList[$i]['status']==0)
                                {
                                    $status='<span style="font-size:13px;color:red;">unPublish</span>';
                                }


                                // $allowcomment='<span class="label label-danger">Not allow comment</span>';
                                if((int)$theList[$i]['allowcomment']==1)
                                {
                                    $allowcomment='<span  style="font-size:13px;color:green;margin-right:10px;">Allow comment</span>';
                                }

                                $dateAdded='<span  style="font-size:13px;color:#888;margin-right:10px;"><span class="glyphicon glyphicon-calendar"></span> '.date('Y-m-d H:i',strtotime($theList[$i]['date_added'])).'</span>';

                                $views='<span style="font-size:13px;color:#888;margin-right:10px;"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;&nbsp;'.number_format($theList[$i]['views']).'</span>';
                                
    							$li.='
	    						<!-- tr -->
	    						<tr>
	    							<td class="col-lg-1">
	    								<input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['pageid'].'" />
	    							</td>
                                    <td class="col-lg-5"><a href="'.Pages::url($theList[$i]).'" target="_blank">'.$theList[$i]['title'].'</a>
                                    <br>
                                    '.$allowcomment.' '.$dateAdded.' '.$views.'
                                    </td>
                                    <td class="col-lg-1 text-right">'.$status.'</td>
                                    <td class="col-lg-1 text-right">
                                    <a href="'.System::getAdminUrl().'pages/edit/'.$theList[$i]['pageid'].'" class="btn btn-warning btn-xs">Edit</a>
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

