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
      <h3>Edit discount</h3>
      <hr>      
        <?php echo $alert;?>
        <table class="table table-hover">
          <tbody>
            <tr>
              <td class="col-lg-3"><strong>Percent (%)</strong></td>
              <td class="col-lg-9">
                <input type="text" class="form-control prod-title input-size-medium" value="<?php echo Request::get('send.percent',$theData['percent']);?>" name="send[percent]" placeholder="Percent" />
              </td>
            </tr>
            <tr>
              <td class="col-lg-3"><strong>Date Start</strong></td>
              <td class="col-lg-9">
                <input type="text" class="form-control prod-title input-size-medium datepicker" name="send[date_discount]" placeholder="Date Start" value="<?php echo Request::get('send.date_discount',date('Y-m-d',strtotime($theData['date_discount'])));?>" />
              </td>
            </tr>
            <tr>
              <td class="col-lg-3"><strong>Date End</strong></td>
              <td class="col-lg-9">
                <input type="text" class="form-control prod-title input-size-medium datepicker" name="send[date_enddiscount]" placeholder="Date End" value="<?php echo Request::get('send.date_enddiscount',date('Y-m-d',strtotime($theData['date_enddiscount'])));?>" />
              </td>
            </tr>
            <tr>
              <td class="col-lg-3"><strong>Status</strong></td>
              <td class="col-lg-9">
                <select class="form-control" name="send[status]">
                  <option value="1" <?php if((int)$theData['status']==1)echo 'selected';?>>Enable</option>
                  <option value="0" <?php if((int)$theData['status']==0)echo 'selected';?>>Disable</option>
                </select>
              </td>
            </tr>
          </tbody>
        </table>

        <p>
          <button type="submit" name="btnSave" class="btn btn-primary">Save Changes</button>
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