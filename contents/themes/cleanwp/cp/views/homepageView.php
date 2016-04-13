     <link href="<?php echo ROOT_URL; ?>bootstrap/chosen/bootstrap-chosen.css" rel="stylesheet">


<script src="<?php echo ROOT_URL; ?>bootstrap/ckeditor/ckeditor.js"></script>

<script src="<?php echo ROOT_URL; ?>bootstrap/chosen/chosen.jquery.js"></script>


<!-- right -->
  <div class="col-lg-9">
  
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Setting your website design</h3>
      </div>
      <div class="panel-body">

      <form action="" method="post" enctype="multipart/form-data">
      <?php if(Request::has('btnSend'))echo $alert;?>

        <div class="row" style="margin-bottom:20px;">
          <div class="col-lg-12">
            <strong>Select categories show on home page:</strong>
          </div>
          <div class="col-lg-12">
            <select class="form-control category-method chosen-select" multiple name="send_categories[]">
              <?php
              $total=count($categories);

              $li='';

              for ($i=0; $i < $total; $i++) { 
                $li.='<option value="'.$categories[$i]['catid'].'">'.$categories[$i]['title'].'</option>';
              }
              echo $li;
              ?>
            </select>
          </div>

        </div>        
       
        <div class="row" style="margin-bottom:20px;">
          <div class="col-lg-12">
            <strong>Top Content:</strong>
          </div>
          <div class="col-lg-12">
            <textarea rows="5" name="send[site_home_top_content]" id="editor2" class="form-control"><?php if(isset($site_home_top_content))echo $site_home_top_content;?></textarea>
          </div>

        </div>
       
        <div class="row" style="margin-bottom:20px;">
          <div class="col-lg-12">
            <strong>Bottom Content:</strong>
          </div>
          <div class="col-lg-12">
            <textarea rows="5" name="send[site_home_bottom_content]" id="editor3" class="form-control"><?php if(isset($site_home_bottom_content))echo $site_home_bottom_content;?></textarea>
          </div>

        </div>

        <p>
          <button type="submit" name="btnSend" class="btn btn-primary btn-xs">Save changes</button>
        </p>
      </form>
      </div>
    </div> 


  </div>
<!-- right -->

</div>
<script>
  // Replace the <textarea id="editor1"> with a CKEditor
  // instance, using default configuration.
  // CKEDITOR.replace( 'editor' );
CKEDITOR.replace( 'editor2' ,{
  filebrowserBrowseUrl : '<?php echo System::getUrl();?>bootstrap/ckeditor/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
  filebrowserImageBrowseUrl : '<?php echo System::getUrl();?>bootstrap/ckeditor/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
});   

</script>
<script>
  // Replace the <textarea id="editor1"> with a CKEditor
  // instance, using default configuration.
  // CKEDITOR.replace( 'editor' );
CKEDITOR.replace( 'editor3' ,{
  filebrowserBrowseUrl : '<?php echo System::getUrl();?>bootstrap/ckeditor/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
  filebrowserImageBrowseUrl : '<?php echo System::getUrl();?>bootstrap/ckeditor/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
});   

</script>
<script>
  // Replace the <textarea id="editor1"> with a CKEditor
  // instance, using default configuration.

var listCat=[];


<?php

if(isset($list_category) && is_array($list_category))
{
  $total=count($list_category);

  for($i=0;$i<$total;$i++)
  {
    echo "listCat[".$i."]='".$list_category[$i]."';\r\n";
  }
}

?>


$(document).ready(function(){

  var total=listCat.length;

  var id=0;

  for(var i=0;i<total;i++)
  {
    id=listCat[i];

    $('.category-method').children('option').each(function(index, el) {
      if(parseInt(id) == parseInt($(this).val()))
      {

        $(this).attr('selected',true);
      }
    });
  }



});


</script>
<script>
  $(function() {
    $('.chosen-select').chosen();
  });
</script>