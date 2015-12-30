  <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/chosen/bootstrap-chosen.css">

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Categories list</h3>
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
                            <option value="none">Select an action</option>
                            <option value="deleteallpost">Delete all post</option>
                            <option value="delete">Delete</option>
                            <option value="deleteall">Delete All</option>
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
    							<td class="col-lg-2">Sort order</td>
    							<td class="col-lg-2">#</td>
    						</tr>
    					</thead>

    					<tbody>
    					<?php
    						$total=count($theList);

    						$li='';

    						if(isset($theList[0]['catid']))
    						for ($i=0; $i < $total; $i++) { 
    							$li.='
	    						<!-- tr -->
	    						<tr>
	    							<td class="col-lg-1">
	    								<input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['catid'].'" />
	    							</td>
	    							<td class="col-lg-9"><a href="'.$theList[$i]['url'].'" target="_blank">'.$theList[$i]['title'].'</a></td>
	    							<td class="col-lg-2 text-right">'.$theList[$i]['sort_order'].'</td>
	    							<td class="col-lg-2 text-right">
	    							<a href="'.System::getAdminUrl().'categories/edit/'.$theList[$i]['catid'].'" class="btn btn-warning btn-xs">Edit</a>
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
	    			<label><strong>Title</strong></label>
	    			<input type="text" class="form-control" name="send[title]" placeholder="Title" id="txtTitle" />
	    		</p>
                    <p class="pChosen">
                    <div class="row">
                    <div class="col-lg-12">
                    <label><strong>Parent</strong></label>
                    <select name="send[parentid]" class="form-control chosen-select">
                        <?php if(isset($listCat[0]['catid'])){ ?>
                        <?php
                        $total=count($listCat);

                        $li='';

                        for ($i=0; $i < $total; $i++) { 
                            $li.='<option value="'.$listCat[$i]['catid'].'">'.$listCat[$i]['title'].'</option>';
                        }

                        echo $li;
                        ?>
                        <?php } ?>
                    </select>
                    </div>
                    </div>

                    </p>
                <p>
                    <label><strong>Thumbnail</strong></label>
                    <input type="file" class="form-control" name="image" />
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
                    <input type="text" class="form-control" name="send[title]" value="<?php if(isset($edit['title']))echo $edit['title'];?>" placeholder="Title" id="txtTitle" />
                </p>
	    		<p>
	    			<label><strong>Friendly Url</strong></label>
	    			<input type="text" class="form-control" name="send[friendly_url]" value="<?php if(isset($edit['friendly_url']))echo $edit['friendly_url'];?>" placeholder="Friendly Url" id="txtTitle" />
	    		</p>

                <p class="pChosen">
                        <div class="row">
                        <div class="col-lg-12">
                        <label><strong>Parent</strong></label>
                        <select name="send[parentid]" class="form-control chosen-select selected-parentid">
                            <?php if(isset($listCat[0]['catid'])){ ?>
                            <?php
                            $total=count($listCat);

                            $selected="";

                            $li='';

                            for ($i=0; $i < $total; $i++) { 

                                $selected="";

                                if((int)$listCat[$i]['catid']==(int)$edit['parentid'])
                                {
                                    $selected="selected";
                                }

                                $li.='<option value="'.$listCat[$i]['catid'].'" '.$selected.'>'.$listCat[$i]['title'].'</option>';
                            }

                            echo $li;
                            ?>
                            <?php } ?>
                        </select>
                        </div>
                        </div>

                        </p>
                <p>
                    <label><strong>Sort Order</strong></label>
                    <input type="text" class="form-control" name="send[sort_order]" value="<?php if(isset($edit['sort_order']))echo $edit['sort_order'];?>" placeholder="Sort order" id="txtOrder" />
                </p>                         
                <p>
                    <label><strong>Thumbnail</strong></label>
                    <input type="file" class="form-control" name="image" />
                </p>   

                <p>
                    <img src="<?php echo System::getUrl().$edit['image']?>" class="img-responsive" />
                </p>  

	    		<p>
	    			<button type="submit" class="btn btn-primary" name="btnSave">Save changes</button>
                    <a href="<?php echo System::getAdminUrl();?>categories" class="btn btn-default pull-right">Back</a>
	    		</p>   		
                </form> 	
    		</div>
            <?php } ?>
        
    	</div>
    	
    </div>
  </div>
</div>

<script src="<?php echo ROOT_URL;?>bootstrap/chosen/chosen.jquery.js"></script>  
<script>
  $(function() {
    $('.chosen-select').chosen();
  });
</script>

<script type="text/javascript">
    var root_url='<?php echo System::getUrl();?>';

    var parentid=0;

    <?php if(isset($edit['catid'])){ ?>
     parentid='<?php echo $edit["parentid"];?>';   
    <?php } ?>

    $(document).ready(function(){

        if(parseInt(parentid) > 0)
        {

            $('.selected-parentid').children('option').each(function(){
                var thisID=$(this).val();
                // console.log(thisID);
                if(parseInt(thisID)==parseInt(parentid))
                {
                    $(this).attr('selected',true);

                    return;
                }

            });            
        }

    });

       
</script>