                    </div>
                </div>
                <!-- /.row -->
        
        <?php if(!isset(System::$setting['admincp_hide_author'])){ ?>                
        <!-- Author -->
                <div class="row">
                    <div class="col-lg-5">
                        <span>Noblesse CMS <?php echo System::$setting['system_version'];?></span>
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

    var control='<?php if($match=Uri::match("plugins\/controller\/(\w+)")){ echo $match[1];}elseif($match=Uri::match("npanel\/(\w+)")){echo $match[1];} ?>';


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
    <script src="<?php echo System::getUrl();?>bootstraps/sbnoblesse/js/bootstrap.min.js"></script>

    
    <script src="<?php echo System::getUrl();?>bootstraps/js/gridline.js"></script>    


    <script src="<?php echo System::getUrl();?>bootstraps/sbnoblesse/js/custom.js"></script>
    <script src="<?php echo ROOT_URL;?>bootstraps/jsupload/js/vendor/jquery.ui.widget.js"></script>
    <script src="<?php echo ROOT_URL;?>bootstraps/jsupload/js/jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="<?php echo ROOT_URL;?>bootstraps/jsupload/js/jquery.fileupload.js"></script>


    <?php echo System::getVar('jsGlobal','global',true);?>

    <?php echo System::getVar('admincp_footer','global',true);?>
    
    <script type="text/javascript">
        $(document).ready(function(){

        });    


        $(function () {
            'use strict';
            // Change this to the location of your server-side upload handler:
            var url = '<?php echo ROOT_URL;?>api/media/upload_file';

            $('#mediaupload').fileupload({
                url: url,
                dataType: 'json',
                limitMultiFileUploads : 1000,
                done: function (e, data) {
                  // console.log('Ảnh upload về');
                  // console.log(data);
                    $.each(data.result.files, function (index, file) {

                        $('<p/>').text(file.name).appendTo('#files');

                        // clearlog();
                        

                    });
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#mediaupload_progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                }
            }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
        });           
    </script>    


</body>

</html>
