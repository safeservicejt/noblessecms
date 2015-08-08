                    </div>
                </div>
                <!-- /.row -->
                        
        <!-- Author -->
                <div class="row">
                    <div class="col-lg-5">
                        <span>Noblesse CMS <?php echo SYSTEM_VERSION;?></span>
                    </div>
                <div class="col-lg-7 text-right">
                      <span>Contact us: Safeservicejt@gmail.com</span> - <span>Skype: <a href="skype:freshcodeteam">freshcodeteam</a></span> - <span>Facebook: <a href="https://www.facebook.com/isafeservicejt" target="_blank">Safeservicejt</a></span>
                  </div>

                </div>     
        <!-- Author -->

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <script type="text/javascript">

    var control='<?php if($match=Uri::match("admincp\/(\w+)")){ echo $match[1];} ?>';

    $(document).ready(function(){
        var target='li-'+control;

        if($('.'+target).length==1)
        {
            $('.'+target).children('a').removeClass('collapsed').attr('aria-expanded','true');
            $('.'+target).children('ul').removeClass('collapse').addClass('collapse in').attr('aria-expanded','true');
      
        }


    });
    </script>


    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo ROOT_URL;?>bootstrap/sbnoblesse/js/bootstrap.min.js"></script>

    
    <script src="<?php echo ROOT_URL;?>bootstrap/js/gridline.js"></script>    


    <script src="<?php echo ROOT_URL;?>bootstrap/sbnoblesse/js/custom.js"></script>

</body>

</html>
