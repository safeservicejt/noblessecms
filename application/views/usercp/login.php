  <div class="container">
      <div class="row divLogin" >
          <div class="col-lg-4 col-lg-offset-4">
              <div class="row">
                  <div class="col-lg-12 text-center" style="margin-bottom:20px;">
                    <a href="<?php echo ROOT_URL;?>"><img src="<?php echo ROOT_URL;?>bootstrap/images/logo128.png" /></a>
                  </div>
                  <div class="col-lg-12 boxLogin">
                      <div class="row">
                          <div class="col-lg-12">
                          <form method="post" action="" enctype="multipart/form-data">
                            <?php echo $alert;?>
                            <p>
                            <span>Email:</span>
                              <input type="text" name="email" class="form-control" placeholder="Email..." required>
                              </p>
                            <p>
                             <span>Password:</span>
                              <input type="password" name="password" class="form-control" placeholder="Password...">
                              </p>



                          </div>
                          <div class="col-lg-12">
                          <button type="submit" name="btnLogin" class="btn btn-primary">Login</button>

                          <a href="<?php echo USERCP_URL;?>register" class="btn btn-info pull-right">Register an account</a>
                          </div>
                          </form>
                      </div>
                  </div>

                  <div class="col-lg-12" style="margin-top:20px;">
                  <a href="<?php echo USERCP_URL;?>forgot-password" >Forgot your password?</a>
                  </div>

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