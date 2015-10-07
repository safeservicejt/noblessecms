<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Add more content into your front page header, footer</h3>
  </div>
  <div class="panel-body">
    <form action="" method="post" enctype="multipart/form-data">
    <?php if(isset($alert))echo $alert; ?>
    <p>
    	<label>Front Page Header</label>
    	<textarea class="form-control" rows="10" name="send[site_header]" placeholder="Type content wanna add to admincp header"><?php if(isset($header)) echo $header;?></textarea>
    </p>
    <p>
    	<label>Front Page Footer</label>
    	<textarea class="form-control" rows="10" name="send[site_footer]" placeholder="Type content wanna add to admincp footer"><?php if(isset($footer)) echo $footer;?></textarea>
    </p>

    <p>
    	<button type="submit" class="btn btn-primary" name="btnSave">Save changes</button>
    </p>

    </form>
  </div>
</div>