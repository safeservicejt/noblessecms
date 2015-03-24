  <div class="container">
      <div class="row divLogin" >
          <div class="col-lg-4 col-lg-offset-4">
              <div class="row">
                  <div class="col-lg-12 text-center" style="margin-bottom:20px;">
                    <a href="<?php echo ROOT_URL;?>"><img src="<?php echo ROOT_URL;?>bootstrap/images/logo128.png" /></a>
                  </div>
                  <div class="col-lg-12 boxLogin">
                      <div class="row">
                        <form method="post" action="" enctype="multipart/form-data">
                          <div class="col-lg-12">
                            <?php echo $alert;?>
                            <p>
                            <span>Email:</span>
                              <input type="email" name="email" class="form-control" placeholder="Email..." required />
                              </p>
                          </div>
                          <div class="col-lg-12">
                          <button type="submit" name="btnRequest" class="btn btn-primary">Send new password</button>
                          <a href="<?php echo ADMINCP_URL;?>" class="btn btn-default pull-right">Go back</a>
                          </div>
                        </form>
                      </div>
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