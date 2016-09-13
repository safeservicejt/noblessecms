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
      <h3>Paypal Standart Setting</h3>
      <hr>      
        <?php echo $alert;?>
        <p>
        	<label>Paypal Email</label>
        	<?php if(!isset(FastEcommerce::$setting['paypal_email'])){ ?>
        	<input type="email" value="<?php echo Request::get('paypal_email','');?>" class="form-control prod-title input-size-medium" name="paypal_email" placeholder="Paypal Email" />
        	<?php }else{ ?>
        	<input type="email" value="<?php echo Request::get('paypal_email',FastEcommerce::$setting['paypal_email']);?>" class="form-control prod-title input-size-medium" name="paypal_email" placeholder="Paypal Email" />
        	<?php } ?>
        </p>

        <p>
          <button type="submit" name="btnAdd" class="btn btn-primary">Save Changes</button>
        </p>
      </div>
    </div>
    <!-- panel -->



  </div>
  <!-- left -->
</div>
<!-- row -->



</form>
