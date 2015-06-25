<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Add new user</h3>
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


                              if(isset($listGroups[0]['groupid']))
                                for ($i=0; $i < $total; $i++) { 
                                    
                                    $li.='<option value="'.$listGroups[$i]['groupid'].'">'.$listGroups[$i]['group_title'].'</option>';
                                }

                                echo $li;
                              ?>
                          </select>
                      </p>  

                      <p>
                            <strong>First name:</strong>
                          <input type="text" class="form-control" placeholder="First name" name="send[firstname]" />
                      </p>

                      <p>
                            <strong>Last name:</strong>
                          <input type="text" class="form-control" placeholder="Last name" name="send[lastname]" />
                      </p>

                      <p>
                            <strong>Username:</strong>
                          <input type="text" class="form-control" placeholder="Username" name="send[username]"  />
                      </p>

                      <p>
                            <strong>Email:</strong>
                          <input type="email" class="form-control" placeholder="Email" name="send[email]" />
                      </p>

                </div>
                <div class="col-lg-6">
                      <p>
                            <strong>Address 1:</strong>
                          <input type="text" class="form-control" placeholder="Address 1" name="address[address_1]"  />
                      </p>
                      <p>
                            <strong>Address 2:</strong>
                          <input type="text" class="form-control" placeholder="Address 2" name="address[address_2]" />
                      </p>
                      <p>
                            <strong>City:</strong>
                          <input type="text" class="form-control" placeholder="City" name="address[city]" />
                      </p>
                      <p>
                            <strong>State:</strong>
                          <input type="text" class="form-control" placeholder="State" name="address[state]" />
                      </p>
                      <p>
                            <strong>Post code:</strong>
                          <input type="text" class="form-control" placeholder="Post code" name="address[postcode]" />
                      </p>
                      <p>
                            <strong>Country:</strong>
                          <input type="text" class="form-control" placeholder="Country" name="address[country]" />
                      </p>

                </div>

            </div>
            <!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" name="btnAdd" class="btn btn-primary">Add new</button>
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