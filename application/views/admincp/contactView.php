<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Contact #<?php echo $edit['contactid'];?>

    <div class="pull-right">
    <a href="<?php echo ROOT_URL;?>admincp/contactus/remove/<?php echo $edit['contactid'];?>" class="btn btn-info btn-xs">Remove</a>
    </div>
    </h3>
  </div>
  <div class="panel-body">
	<div class="row">
		<div class="col-lg-12">
		<p><strong>Fullname: <?php echo $edit['fullname'];?></strong></p>
		<p><strong>Email: <?php echo $edit['email'];?></strong></p>
		<p><strong>Date: <?php echo $edit['date_added'];?></strong></p>
		<p><strong>Details: </strong></p>
		<p>
			 <?php echo stripslashes($edit['content']);?>
		</p>
		</div>
	</div>    
    
  </div>
</div>