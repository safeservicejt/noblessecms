<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Post list</h3>
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
                            <option value="deleteall">Delete All Post</option>
                            <option value="release">Release</option>
                            <option value="publish">Publish</option>
                            <option value="unpublish">unPublish</option>
                            <option value="featured">Featured</option>
                            <option value="unfeatured">unFeatured</option>
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
                                <td class="col-lg-2">Category</td>
                                <td class="col-lg-7">Title</td>
                                <td class="col-lg-1 text-right">Status</td>
    							<td class="col-lg-1 text-right">#</td>
    						</tr>
    					</thead>

    					<tbody>
    					<?php
    						$total=count($theList);

    						$li='';

    						if(isset($theList[0]['postid']))
    						for ($i=0; $i < $total; $i++) { 

                                $date_added='<span style="font-size:13px;color:#888;margin-right:10px;">Date: '.date('M d, Y H:i',strtotime($theList[$i]['date_added'])).'</span>';

                                $status='<span style="font-size:13px;color:green;">Publish</span>';

                                if((int)$theList[$i]['status']==0)
                                {
                                    $status='<span style="font-size:13px;color:red;">unPublish</span>';
                                }

                                $featured='';
                                if((int)$theList[$i]['is_featured']==1)
                                {
                                    $featured='<span style="font-size:13px;color:green;margin-right:10px;">Featured</span>';
                                }

                                $allowcomment='';
                                if((int)$theList[$i]['allowcomment']==1)
                                {
                                    $allowcomment='<span  style="font-size:13px;color:green;margin-right:10px;">Allow comment</span>';
                                }

                                $author=' <span  style="font-size:13px;color:#888;margin-right:10px;"><span class="glyphicon glyphicon-user"></span> '.$theList[$i]['username'].'</span>';

                                $views='<span style="font-size:13px;color:#888;margin-right:10px;"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;&nbsp;'.number_format($theList[$i]['views']).'</span>';
    							$li.='
	    						<!-- tr -->
	    						<tr>
	    							<td class="col-lg-1">
	    								<input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['postid'].'" />
	    							</td>
                                    <td class="col-lg-2"><a href="'.System::getAdminUrl().'post/category/'.$theList[$i]['catid'].'">'.$theList[$i]['cattitle'].'</a></td>
                                    <td class="col-lg-5"><a target="_blank" href="'.Post::url($theList[$i]).'">'.$theList[$i]['title'].'</a>

                                    <br>
                                    '.$author.' '.$allowcomment.' '.$featured.' '.$date_added.' '.$views.'
                                    </td>
                                    <td class="col-lg-1 text-right">'.$status.'</td>
                                    <td class="col-lg-1 text-right">
                                    <a href="'.System::getAdminUrl().'post/edit/'.$theList[$i]['postid'].'" class="btn btn-warning btn-xs">Edit</a>
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

