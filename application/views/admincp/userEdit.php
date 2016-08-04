<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo Lang::get('cmsadmin.editUser');?></h3>
  </div>
  <div class="panel-body">
    <div class="row">
        <div class="col-lg-12">
        <?php echo $alert;?>
        <form action="" method="post" enctype="multipart/form-data">
            <!-- row -->
            <div class="row">
                <div class="col-lg-6">
                      <p>
                            <strong><?php echo Lang::get('cmsadmin.group');?>:</strong>
                          <select class="form-control" name="send[groupid]">

                              <?php 
                              $total=count($listGroups);

                              $li='';


                                $li.='<option value="'.$edit['groupid'].'" selected>'.$edit['group_title'].'</option>';


                              if(isset($listGroups[0]['groupid']))
                                for ($i=0; $i < $total; $i++) { 
                                    
                                    $li.='<option value="'.$listGroups[$i]['groupid'].'">'.$listGroups[$i]['group_title'].'</option>';
                                }

                                echo $li;
                              ?>
                          </select>
                      </p>  

                      <p>
                            <strong><?php echo Lang::get('cmsadmin.firstName');?>:</strong>
                          <input type="text" class="form-control" placeholder="<?php echo Lang::get('cmsadmin.firstName');?>" name="send[firstname]" value="<?php echo $edit['firstname'];?>" />
                      </p>

                      <p>
                            <strong><?php echo Lang::get('cmsadmin.lastName');?>:</strong>
                          <input type="text" class="form-control" placeholder="<?php echo Lang::get('cmsadmin.lastName');?>" name="send[lastname]"  value="<?php echo $edit['lastname'];?>" />
                      </p>

                      <p>
                            <strong><?php echo Lang::get('cmsadmin.username');?>:</strong>
                          <input type="text" class="form-control" placeholder="<?php echo Lang::get('cmsadmin.username');?>" name="send[username]"  value="<?php echo $edit['username'];?>" />
                      </p>

                      <p>
                            <strong><?php echo Lang::get('cmsadmin.email');?>:</strong>
                          <input type="email" class="form-control" placeholder="<?php echo Lang::get('cmsadmin.email');?>" name="send[email]"  value="<?php echo $edit['email'];?>" />
                      </p>

                </div>
                <div class="col-lg-6">
                      <p>
                            <strong><?php echo Lang::get('cmsadmin.address1');?>:</strong>
                          <input type="text" class="form-control" placeholder="<?php echo Lang::get('cmsadmin.address1');?>" name="address[address_1]"  value="<?php echo $edit['address_1'];?>" />
                      </p>
                      <p>
                            <strong><?php echo Lang::get('cmsadmin.address2');?>:</strong>
                          <input type="text" class="form-control" placeholder="<?php echo Lang::get('cmsadmin.address2');?>" name="address[address_2]"  value="<?php echo $edit['address_2'];?>" />
                      </p>
                      <p>
                            <strong><?php echo Lang::get('cmsadmin.city');?>:</strong>
                          <input type="text" class="form-control" placeholder="<?php echo Lang::get('cmsadmin.city');?>" name="address[city]"  value="<?php echo $edit['city'];?>" />
                      </p>
                      <p>
                            <strong><?php echo Lang::get('cmsadmin.state');?>:</strong>
                          <input type="text" class="form-control" placeholder="<?php echo Lang::get('cmsadmin.state');?>" name="address[state]"  value="<?php echo $edit['state'];?>" />
                      </p>
                      <p>
                            <strong><?php echo Lang::get('cmsadmin.postCode');?>:</strong>
                          <input type="text" class="form-control" placeholder="<?php echo Lang::get('cmsadmin.postCode');?>" name="address[postcode]"  value="<?php echo $edit['postcode'];?>" />
                      </p>
                      <p>
                            <strong><?php echo Lang::get('cmsadmin.country');?>:</strong>
                          <input type="text" class="form-control" placeholder="<?php echo Lang::get('cmsadmin.country');?>" name="address[country]"  value="<?php echo $edit['country'];?>" />
                      </p>

                </div>

            </div>
            <!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" name="btnSave" class="btn btn-primary"><?php echo Lang::get('cmsadmin.saveChanges');?></button>
                </div>
            </div>
        </form>
        </div>
        
    </div>
  </div>
</div>
<div class="panel panel-warning">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo Lang::get('cmsadmin.changePassword');?></h3>
  </div>
  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<form action="" method="post" enctype="multipart/form-data">
    		<!-- row -->
    		<div class="row">
                <div class="col-lg-12">
                      <p>
                            <strong><?php echo Lang::get('cmsadmin.newPassword');?>:</strong>
                          <input type="text" class="form-control" name="thepass" placeholder="<?php echo Lang::get('cmsadmin.newPassword');?>" />
                      </p>

                </div>

    		</div>
    		<!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" name="btnChangePassword" class="btn btn-primary"><?php echo Lang::get('cmsadmin.change');?></button>
                </div>
            </div>
    	</form>
    	</div>
    	
    </div>
  </div>
</div>

<script>

$(document).ready(function(){


});
</script>