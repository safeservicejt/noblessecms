<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit user group</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    <form action="" method="post" enctype="multipart/form-data">
    	<div class="col-lg-12">
    	
        <?php echo $alert;?>
            <p>
                <label><strong>Title</strong></label>
                <input type="text" class="form-control" name="send[title]" value="<?php echo $edit['title'];?>" placeholder="Title" />
            </p>
 
            <p>
                <label><strong>Permission (separator by new line)</strong></label>
                <textarea id="editor1" rows="15" name="send[permissions]" class="form-control ckeditor"><?php echo $edit['permissions'];?></textarea>
            </p>
    	     
           <button type="submit" class="btn btn-primary" name="btnSave">Save changes</button>
    	</div>

    </form>	
    </div>
  </div>
</div>
