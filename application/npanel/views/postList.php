  <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstraps/chosen/bootstrap-chosen.css">

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

    						if(isset($theList[0]['id']))
    						for ($i=0; $i < $total; $i++) { 

                                $date_added='<span title="Click to release this post" class="pointer post-release" data-id="'.$theList[$i]['id'].'" style="font-size:13px;color:#888;margin-right:10px;">Date: '.date('M d, Y H:i',strtotime($theList[$i]['date_added'])).'</span>';

                                $status='<span title="Click to unPublish this post" class="pointer post-status" data-type="unpublish" data-id="'.$theList[$i]['id'].'" style="font-size:13px;color:green;">Publish</span>';

                                if($theList[$i]['status']=='pending')
                                {
                                    $status='<span title="Click to Publish this post" class="pointer post-status" data-type="publish" data-id="'.$theList[$i]['id'].'" style="font-size:13px;color:red;">unPublish</span>';
                                }

                                $featured='';
                                if((int)$theList[$i]['is_featured']==1)
                                {
                                    $featured='<span title="Click to unFeatured this post" class="pointer post-featured" data-type="unfeatured" data-id="'.$theList[$i]['id'].'" style="font-size:13px;color:green;margin-right:10px;">Featured</span>';
                                }

                                $allowcomment='';
                                if((int)$theList[$i]['allowcomment']==1)
                                {
                                    $allowcomment='<span title="Click to set not allow comment this post"  class="pointer post-allow-comment" data-type="1" data-id="'.$theList[$i]['id'].'" style="font-size:13px;color:green;margin-right:10px;">Allow comment</span>';
                                }

                                $author=' <span  style="font-size:13px;color:#888;margin-right:10px;"><span class="glyphicon glyphicon-user"></span> '.$theList[$i]['username'].'</span>';

                                $views='<span style="font-size:13px;color:#888;margin-right:10px;"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;&nbsp;'.number_format($theList[$i]['views']).'</span>';
    							$li.='
	    						<!-- tr -->
	    						<tr>
	    							<td class="col-lg-1">
	    								<input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['id'].'" />
	    							</td>
                                    <td class="col-lg-2"><a href="'.System::getAdminUrl().'post/index/category/'.$theList[$i]['catid'].'">'.$theList[$i]['cattitle'].'</a></td>
                                    <td class="col-lg-5"><a target="_blank" href="'.$theList[$i]['url'].'">'.$theList[$i]['title'].'</a>

                                    <br>
                                    '.$author.' '.$allowcomment.' '.$featured.' '.$date_added.' '.$views.'
                                    </td>
                                    <td class="col-lg-1 text-right">'.$status.'</td>
                                    <td class="col-lg-1 text-right">
                                    <a href="'.System::getAdminUrl().'post/edit/'.$theList[$i]['id'].'" class="btn btn-warning btn-xs">Edit</a>
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

<script src="<?php echo ROOT_URL;?>bootstraps/chosen/chosen.jquery.js"></script>  
<script>
  $(function() {
    $('.chosen-select').chosen();
  });
</script>

<script type="text/javascript">

    var api_url='<?php echo System::getUrl();?>api/post/';

    
    $(document).ready(function(){

        $('.post-release').click(function(){

            var thisEl=$(this);

            var id=$(this).attr('data-id');

            if(confirm('Are you wanna to release this post ?'))
            {
                var request = new XMLHttpRequest();
                request.open('POST', api_url+'release', true);
                request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

                request.onload = function() {
                  if (request.status >= 200 && request.status < 400) {
                    // Success!
                    // var data = JSON.parse(request.responseText);

                    var msg = JSON.parse(request.responseText);

                    if(msg['error']=='yes')
                    {
                        alert(msg['message']);
                    }
                    else
                    {
                        alert('Success.');
                    }

                  } else {
                    // We reached our target server, but it returned an error
                      alert(request.responseText);

                  }
                };

                request.onerror = function() {
                  // There was a connection error of some sort
                    alert(request.responseText);
                };

                request.send("send_postid="+id);

            }

        });

        $('.post-status').click(function(){

            var thisEl=$(this);

            var id=$(this).attr('data-id');

            var type=$(this).attr('data-type');

            var send_type=1;

            if(type=='unpublish')
            {
                send_type=0;
            }

            if(confirm('Are you wanna to '+type+' this post ?'))
            {
                var request = new XMLHttpRequest();
                request.open('POST', api_url+'change_status', true);
                request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

                request.onload = function() {
                  if (request.status >= 200 && request.status < 400) {
                    // Success!
                    // var data = JSON.parse(request.responseText);

                    var msg = JSON.parse(request.responseText);

                    if(msg['error']=='yes')
                    {
                        alert(msg['message']);
                    }
                    else
                    {

                        if(type=='unpublish')
                        {
                            thisEl.css({
                                'color': 'red'
                            }).attr('data-type','publish').html('unPublish');

                        }
                        else
                        {
                            thisEl.css({
                                'color': 'green'
                            }).attr('data-type','unpublish').html('Publish');                           
                        }
                    }

                  } else {
                    // We reached our target server, but it returned an error
                      alert(request.responseText);

                  }
                };

                request.onerror = function() {
                  // There was a connection error of some sort
                    alert(request.responseText);
                };

                request.send("send_postid="+id+"&send_status="+send_type);

            }

        });

        $('.post-featured').click(function(){

            var thisEl=$(this);

            var id=$(this).attr('data-id');

            var type=$(this).attr('data-type');

            var send_type=1;

            if(type=='unfeatured')
            {
                send_type=0;
            }

            if(confirm('Are you wanna to '+type+' this post ?'))
            {
                var request = new XMLHttpRequest();
                request.open('POST', api_url+'set_featured', true);
                request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

                request.onload = function() {
                  if (request.status >= 200 && request.status < 400) {
                    // Success!
                    // var data = JSON.parse(request.responseText);

                    var msg = JSON.parse(request.responseText);

                    if(msg['error']=='yes')
                    {
                        alert(msg['message']);
                    }
                    else
                    {

                        if(type=='unfeatured')
                        {
                            thisEl.remove();

                        }
                        else
                        {
                            alert('Success.');                         
                        }
                    }

                  } else {
                    // We reached our target server, but it returned an error
                      alert(request.responseText);

                  }
                };

                request.onerror = function() {
                  // There was a connection error of some sort
                    alert(request.responseText);
                };

                request.send("send_postid="+id+"&send_status="+send_type);

            }

        });



    });


</script>