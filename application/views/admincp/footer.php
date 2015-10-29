                    </div>
                </div>
                <!-- /.row -->
        
        <?php if(!isset(System::$setting['admincp_hide_author']) || System::$setting['admincp_hide_author']!='yes'){ ?>                
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

        <?php } ?>

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <script type="text/javascript">

    var control='<?php if($match=Uri::match("plugins\/controller\/(\w+)")){ echo $match[1];}elseif($match=Uri::match("admincp\/(\w+)")){echo $match[1];} ?>';


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
    <script src="<?php echo System::getUrl();?>bootstrap/sbnoblesse/js/bootstrap.min.js"></script>

    
    <script src="<?php echo System::getUrl();?>bootstrap/js/gridline.js"></script>    


    <script src="<?php echo System::getUrl();?>bootstrap/sbnoblesse/js/custom.js"></script>


    <?php echo unserialize(System::getVar('jsGlobal'));?>

    <?php echo System::getVar('admincp_footer');?>



</body>

</html>
