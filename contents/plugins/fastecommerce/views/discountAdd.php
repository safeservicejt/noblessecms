  <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/chosen/bootstrap-chosen.css">
<script src="<?php echo System::getUrl(); ?>bootstrap/ckeditor/ckeditor.js"></script>
    <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/datepicker/css/datepicker.css">
  <script src="<?php echo ROOT_URL;?>bootstrap/datepicker/js/bootstrap-datepicker.js"></script>


<form action="" method="post" enctype="multipart/form-data">

<!-- row -->
<div class="row">
  <!-- left -->
  <div class="col-lg-12 ">
    <!-- panel -->
    <div class="panel panel-default">
      <div class="panel-body">
      <h3>Add new discount</h3>
      <hr>      
        <?php echo $alert;?>
        <table class="table table-hover">
          <tbody>
            <tr>
              <td class="col-lg-3"><strong>Percent (%)</strong></td>
              <td class="col-lg-9">
                <input type="text" class="form-control prod-title input-size-medium" value="0" name="send[percent]" placeholder="Percent" />
              </td>
            </tr>
            <tr>
              <td class="col-lg-3"><strong>Date Start</strong></td>
              <td class="col-lg-9">
                <input type="text" class="form-control prod-title input-size-medium datepicker" name="send[date_discount]" placeholder="Date Start" />
              </td>
            </tr>
            <tr>
              <td class="col-lg-3"><strong>Date End</strong></td>
              <td class="col-lg-9">
                <input type="text" class="form-control prod-title input-size-medium datepicker" name="send[date_enddiscount]" placeholder="Date End" />
              </td>
            </tr>
            <tr>
              <td class="col-lg-3"><strong>Status</strong></td>
              <td class="col-lg-9">
                <select class="form-control" name="send[status]">
                  <option value="1">Enable</option>
                  <option value="0">Disable</option>
                </select>
              </td>
            </tr>
          </tbody>
        </table>

        <p>
          <button type="submit" name="btnAdd" class="btn btn-primary">Add new</button>
        </p>
      </div>
    </div>
    <!-- panel -->



  </div>
  <!-- left -->
</div>
<!-- row -->



</form>

<script src="<?php echo ROOT_URL;?>bootstrap/chosen/chosen.jquery.js"></script>  
<script>
$(document).ready(function(){
  $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    })
});
</script>
<script>
  $(function() {
    $('.chosen-select').chosen();
  });
</script>

  <script type="text/javascript">
  var root_url='<?php echo System::getUrl();?>';

  $(document).ready(function(){
     


  });
    
  </script>