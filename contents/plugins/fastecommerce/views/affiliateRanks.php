<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Ranks list</h3>
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
                            <option value="activate">Activate</option>
                            <option value="deactivate">Deactivate</option>
                            
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
                                <td class="col-lg-2">Date</td>
                                <td class="col-lg-4">Title</td>
                                <td class="col-lg-2">Commission</td>
                                <td class="col-lg-2 text-right">Status</td>
    							<td class="col-lg-1 text-right">#</td>
    						</tr>
    					</thead>

    					<tbody>
    					<?php
    						$total=count($theList);

    						$li='';

                            $status='';

    						if(isset($theList[0]['id']))
    						for ($i=0; $i < $total; $i++) { 

                                $status='<span class="label label-danger">Deactivate</span>';

                                if((int)$theList[$i]['status']==1)
                                {
                                    $status='<span class="label label-success">Activate</span>';
                                }

    							$li.='
	    						<!-- tr -->
	    						<tr>
	    							<td class="col-lg-1">
	    								<input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['id'].'" />
	    							</td>
                                    <td class="col-lg-2">'.date('M d, Y',strtotime($theList[$i]['date_added'])).'</td>
	    							<td class="col-lg-4">'.$theList[$i]['title'].'</td>
                                    <td class="col-lg-2">'.$theList[$i]['commission'].' %</td>
                                    <td class="col-lg-2 text-right">'.$status.'</td>
 	    							<td class="col-lg-1 text-right">
                                    <a href="'.System::getUrl().'admincp/plugins/privatecontroller/fastecommerce/affiliate/ranks/edit/'.$theList[$i]['id'].'" class="btn btn-warning btn-xs">Edit</a>
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
    	<div class="col-lg-4">
        

        <?php if(!Uri::has('\/edit\/\d+')){ ?>
    		<div class="divAddnew">
            <form action="" method="post" enctype="multipart/form-data"> 
            <?php echo $alert;?>
	     		<h4>Add new</h4>
                <p>
                    <label><strong>Title</strong></label>
                    <input type="text" class="form-control input-size-medium" name="send[title]" placeholder="Title" id="txtTitle" />
                </p>

                <p>
                    <label><strong>Commission (Percent)</strong></label>
                    <input type="text" class="form-control input-size-medium" name="send[commission]" value="5" id="txtTitle" />
                </p>

                <p>
                    <label><strong>Require Orders</strong></label>
                    <input type="text" class="form-control input-size-medium" name="send[orders]" value="1" id="txtTitle" />
                </p>

                <p>
                    <label><strong>Parent</strong></label>
                    <select class="form-control" name="send[parentid]">
                        <option value="0">None</option>
                        <?php 
                        if(isset($ranksList[0]['id']))
                        {
                            $li='';

                            $total=count($ranksList);

                            for ($i=0; $i < $total; $i++) { 
                                $li.='<option value="'.$ranksList[$i]['id'].'">'.$ranksList[$i]['title'].'</option>';
                            }

                            echo $li;
                        }

                        ?>
                        
                    </select>
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
                    <label><strong>Title</strong></label>
                    <input type="text" class="form-control input-size-medium" name="send[title]" value="<?php echo $rankData['title'];?>" placeholder="Title" id="txtTitle" />
                </p>

                <p>
                    <label><strong>Commission (Percent)</strong></label>
                    <input type="text" class="form-control input-size-medium" name="send[commission]"  value="<?php echo $rankData['commission'];?>" id="txtTitle" />
                </p>

                <p>
                    <label><strong>Require Orders</strong></label>
                    <input type="text" class="form-control input-size-medium" name="send[orders]" value="<?php echo $rankData['orders'];?>" id="txtTitle" />
                </p>

                <p>
                    <label><strong>Parent</strong></label>
                    <select class="form-control" name="send[parentid]">
                        <option value="0">None</option>
                        <?php 
                        if(isset($ranksList[0]['id']))
                        {
                            $li='';

                            $total=count($ranksList);

                            for ($i=0; $i < $total; $i++) { 

                                if((int)$rankData['parentid']==(int)$ranksList[$i]['id'])
                                {
                                    $li.='<option value="'.$ranksList[$i]['id'].'" selected>'.$ranksList[$i]['title'].'</option>';
                                }
                                else
                                {
                                    $li.='<option value="'.$ranksList[$i]['id'].'">'.$ranksList[$i]['title'].'</option>';
                                }
                                
                            }

                            echo $li;
                        }

                        ?>
                        
                    </select>
                </p>
                <p>
                    <label><strong>Status</strong></label>
                    <select class="form-control" name="send[status]">
                    <option value="1" <?php if((int)$rankData['status']==1)echo 'selected';?>>Activate</option>
                    <option value="0" <?php if((int)$rankData['status']==0)echo 'selected';?>>Deactivate</option>
                    </select>
                </p>   
	    		<p>
	    			<button type="submit" class="btn btn-primary" name="btnSave">Save changes</button>
                    <a href="<?php echo System::getUrl();?>admincp/plugins/privatecontroller/fastecommerce/affiliate/ranks" class="btn btn-default pull-right">Back</a>
	    		</p>   		
                </form> 	
    		</div>
            <?php } ?>
        
    	</div>
    	
    </div>
  </div>
</div>

<script type="text/javascript">
<?php if($match=Uri::match('\/edit\/\d+')){ ?>

var parentid=<?php echo $edit['parentid'];?>;
var status="<?php echo $edit['status'];?>";

$(document).ready(function(){
    $('.select-parent').children('option').each(function(index, el) {
        var id=$(this).val();

        if(parseInt(id)==parseInt(parentid))
        {
            $(this).attr('selected',true);
        }
    });

    $('.select-status').children('option').each(function(index, el) {
        var id=$(this).val();

        if(id==status)
        {
            $(this).attr('selected',true);
        }
    });

});

<?php } ?>
</script>