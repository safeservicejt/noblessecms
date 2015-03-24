  <div class="container">
      <div class="row " >
          <div class="col-lg-8 col-lg-offset-2">
              <div class="row">
                  <div class="col-lg-12 text-center" style="margin-bottom:20px;">
                    <a href="<?php echo ROOT_URL;?>"><img src="<?php echo ROOT_URL;?>bootstrap/images/logo128.png" /></a>
                  </div>

                    <form method="post" action="" enctype="multipart/form-data">
                  <div class="col-lg-12">
                    <?php echo $alert;?>

                    <!-- Panel -->
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h3 class="panel-title">Register an account</h3>
                      </div>
                      <div class="panel-body">
                          <div class="row">
                        <div class="col-lg-6">
                         <p>
                            <span>Firstname:</span>
                              <input type="text" name="send[firstname]" class="form-control" placeholder="Firstname..." required />
                              </p>
                             <p>
                            <span>Lastname:</span>
                              <input type="text" name="send[lastname]" class="form-control" placeholder="Lastname..." required />
                              </p>
                                                            
                             <p>
                            <span>Email:</span>
                              <input type="email" name="send[email]" class="form-control" placeholder="Email..." required />
                              </p>

                                <p>
                            <span>Password:</span>
                              <input type="text" name="send[password]" class="form-control" placeholder="Password..." required />
                              </p>
                                 <p>
                            <span>Confirm Password:</span>
                              <input type="text" name="send[repassword]" class="form-control" placeholder="Confirm Password..." required />
                              </p>
                                 <p>
                            <span>Address 1:</span>
                              <input type="text" name="address[address_1]" class="form-control" placeholder="Address 1..." required />
                              </p>

                      
                        </div>
                         <div class="col-lg-6">
                                 <p>
                            <span>Address 2:</span>
                              <input type="text" name="address[address_2]" class="form-control" placeholder="Address 2..." />
                              </p>
                    
                                 <p>
                            <span>City:</span>
                              <input type="text" name="address[city]" class="form-control" placeholder="City..." required />
                              </p>
                                <p>
                            <span>Postcode:</span>
                              <input type="text" name="address[postcode]" class="form-control" placeholder="Postcode..." required />
                              </p>
                                <p>
                            <span>Country:</span>
                              <input type="text" name="address[country]" class="form-control" placeholder="Country..." required />
                              </p>
                              <p>
                                <?php echo Captcha::makeForm(); ?>
                              </p>
                      
                        </div>

                        <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary" name="btnRegister">Register</button>
                          <div class="pull-right">
                          <a href="<?php echo USERCP_URL;?>login" class="btn btn-info">Cancel</a>
                          </div>
                        </div>
                        
                      </div>
                      </div>
                    </div>      
                     <!-- Panel -->


                     
                  </div>
                  </form>


              </div>
          </div>
      </div>

  </div>

      <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script src="<?php echo ROOT_URL;?>bootstrap/fcadmincp/js/bootstrap.min.js"></script>

    
  </body>
</html>