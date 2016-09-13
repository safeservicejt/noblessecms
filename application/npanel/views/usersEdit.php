<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit User</h3>
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
                            <strong>Group:</strong>
                          <select class="form-control" name="send[groupid]">

                              <?php 
                              $total=count($listGroups);

                              $li='';

                              if(isset($listGroups[0]['id']))
                                for ($i=0; $i < $total; $i++) { 
                                    if((int)$edit['groupid']==(int)$listGroups[$i]['id'])
                                    {
                                      $li.='<option value="'.$listGroups[$i]['id'].'" selected>'.$listGroups[$i]['title'].'</option>';
                                    }
                                    else
                                    {
                                      $li.='<option value="'.$listGroups[$i]['id'].'">'.$listGroups[$i]['title'].'</option>';
                                    }
                                    
                                }

                                echo $li;
                              ?>
                          </select>
                      </p>  

                      <p>
                            <strong>Firstname:</strong>
                          <input type="text" class="form-control" placeholder="Firstname" name="address[firstname]" value="<?php echo $edit['firstname'];?>" />
                      </p>

                      <p>
                            <strong>Lastname:</strong>
                          <input type="text" class="form-control" placeholder="Lastname" name="address[lastname]"  value="<?php echo $edit['lastname'];?>" />
                      </p>

                      <p>
                            <strong>Username:</strong>
                          <input type="text" class="form-control" placeholder="Username" name="send[username]"  value="<?php echo $edit['username'];?>" />
                      </p>

                      <p>
                            <strong>Email:</strong>
                          <input type="email" class="form-control" placeholder="Email" name="send[email]"  value="<?php echo $edit['email'];?>" />
                      </p>

                </div>
                <div class="col-lg-6">
                      <p>
                            <strong>Address 1:</strong>
                          <input type="text" class="form-control" placeholder="Address 1" name="address[address_1]"  value="<?php echo $edit['address_1'];?>" />
                      </p>
                      <p>
                            <strong>Address 2:</strong>
                          <input type="text" class="form-control" placeholder="Address 2" name="address[address_2]"  value="<?php echo $edit['address_2'];?>" />
                      </p>
                      <p>
                            <strong>City:</strong>
                          <input type="text" class="form-control" placeholder="City" name="address[city]"  value="<?php echo $edit['city'];?>" />
                      </p>
                      <p>
                            <strong>State:</strong>
                          <input type="text" class="form-control" placeholder="State" name="address[state]"  value="<?php echo $edit['state'];?>" />
                      </p>
                      <p>
                            <strong>Zipcode:</strong>
                          <input type="text" class="form-control" placeholder="Zipcode" name="address[zipcode]"  value="<?php echo $edit['zipcode'];?>" />
                      </p>
                      <p>
                            <strong>Country:</strong>
                          <input type="text" class="form-control" placeholder="Country" name="address[countrycode]"  value="<?php echo $edit['countrycode'];?>" />
                      </p>

                </div>

            </div>
            <!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" name="btnSave" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
        </div>
        
    </div>
  </div>
</div>
<div class="panel panel-warning">
  <div class="panel-heading">
    <h3 class="panel-title">Change Password</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<form action="" method="post" enctype="multipart/form-data">
    		<!-- row -->
    		<div class="row">
                <div class="col-lg-12">
                      <p>
                            <strong>New Password:</strong>
                          <input type="text" class="form-control" name="thepass" placeholder="New Password" />
                      </p>

                </div>

    		</div>
    		<!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" name="btnChangePassword" class="btn btn-primary">Change Password</button>
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