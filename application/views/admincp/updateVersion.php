<form action="" method="post" enctype="multipart/form-data">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Auto Update System

    <div class="pull-right">
      <button type="submit" class="btn btn-primary btn-xs" name="btnStart">Start update</button>
    </div>
    </h3>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-lg-12">
      <?php echo $alert;?>
        <strong>Noblesse CMS</strong> version <span><?php echo $data['data']['version'];?></span>
        
       
      </div>
      
    </div>
  </div>
</div>


<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Change logs:</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
          <?php echo $data['data']['log'];?>
    	</div>
    	
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Manual Update System
    </h3>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-lg-12">
      <?php echo $alertManual;?>
      
       <p>
       <label>Upload file (.zip)</label>
       <input type="file" name="upload_file" />
       </p>

       <button type="submit" class="btn btn-danger" name="btnUpload">Start Update</button>
      </div>
      
    </div>
  </div>  
</div>
</form>

