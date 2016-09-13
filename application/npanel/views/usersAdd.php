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


                              if(isset($listGroups[0]['id']))
                                for ($i=0; $i < $total; $i++) { 
                                    
                                    $li.='<option value="'.$listGroups[$i]['id'].'">'.$listGroups[$i]['title'].'</option>';
                                }

                                echo $li;
                              ?>
                          </select>
                      </p>  

                      <p>
                            <strong>First name:</strong>
                          <input type="text" class="form-control" placeholder="First name" name="address[firstname]" />
                      </p>

                      <p>
                            <strong>Last name:</strong>
                          <input type="text" class="form-control" placeholder="Last name" name="address[lastname]" />
                      </p>

                      <p>
                            <strong>Username:</strong>
                          <input type="text" class="form-control" placeholder="Username" name="send[username]" required/>
                      </p>

                      <p>
                            <strong>Email:</strong>
                          <input type="email" class="form-control" placeholder="Email" name="send[email]" required/>
                      </p>
                      <p>
                            <strong>Password:</strong>
                          <input type="text" class="form-control" placeholder="Password" name="thepass" required />
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
                            <strong>Zip code:</strong>
                          <input type="text" class="form-control" placeholder="Zip code" name="address[zipcode]" />
                      </p>
                      <p>
                            <strong>Country:</strong>
                          <input type="text" class="form-control" placeholder="Country" name="address[countrycode]" />
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