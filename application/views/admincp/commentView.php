<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Comment #<?php echo $edit['commentid'];?> . Post: <?php echo stripslashes($thePost['title']);?>

    <div class="pull-right">
    <a href="<?php echo ROOT_URL;?>admincp/comments/approved/<?php echo $edit['commentid'];?>" class="btn btn-info btn-xs">Approved</a>
   <a href="<?php echo ROOT_URL;?>admincp/comments/remove/<?php echo $edit['commentid'];?>" class="btn btn-danger btn-xs">Remove</a>

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