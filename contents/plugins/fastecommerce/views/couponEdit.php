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
      <h3>Edit coupon</h3>
      <hr>      
        <?php echo $alert;?>
        <table class="table table-hover">
          <tbody>
            <tr>
              <td class="col-lg-3"><strong>Code</strong></td>
              <td class="col-lg-9">
                <input type="text" class="form-control prod-title input-size-medium" value="<?php echo Request::get('send.code',$theData['code']);?>" name="send[code]" placeholder="Code" />
              </td>
            </tr>
            <tr>
              <td class="col-lg-3"><strong>Type</strong></td>
              <td class="col-lg-9">
                <select class="form-control" name="send[type]">
                  <option value="percent" <?php if($theData['type']=='percent')echo 'selected';?>>Percent</option>
                  <option value="fixed" <?php if($theData['type']=='fixed')echo 'selected';?>>Fixed Amount</option>
                </select>
              </td>
            </tr>
            <tr>
              <td class="col-lg-3"><strong>Amount</strong></td>
              <td class="col-lg-9">
                <input type="text" class="form-control prod-title input-size-medium" value="<?php echo Request::get('send.amount',$theData['amount']);?>" name="send[amount]" placeholder="Amount" />
              </td>
            </tr>
            <tr>
              <td class="col-lg-3"><strong>Date Start</strong></td>
              <td class="col-lg-9">
                <input type="text" class="form-control prod-title input-size-medium datepicker" value="<?php echo Request::get('send.date_start',date('Y-m-d',strtotime($theData['date_start'])));?>" name="send[date_start]" placeholder="Date Start" />
              </td>
            </tr>
            <tr>
              <td class="col-lg-3"><strong>Date End</strong></td>
              <td class="col-lg-9">
                <input type="text" class="form-control prod-title input-size-medium datepicker" value="<?php echo Request::get('send.date_end',date('Y-m-d',strtotime($theData['date_end'])));?>" name="send[date_end]" placeholder="Date End" />
              </td>
            </tr>
            <tr>
              <td class="col-lg-3"><strong>Free Shipping</strong></td>
              <td class="col-lg-9">
                <span class="margin-right-20"><input type="radio" name="send[freeshipping]" <?php if((int)$theData['freeshipping']==1)echo 'checked';?> value="1"> Yes</span>
                <span><input type="radio" name="send[freeshipping]" <?php if((int)$theData['freeshipping']==0)echo 'checked';?> value="0"> No</span>
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