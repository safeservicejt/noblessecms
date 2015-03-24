<script src="<?php echo ROOT_URL; ?>bootstrap/ckeditor/ckeditor.js"></script>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Add new page</h3>
  </div>
  <div class="panel-body">

<div class="row">
		<div class="col-lg-12">
		<form action="" method="post" enctype="multipart/form-data">

			<!-- Add new -->
			<div style="display:block;">
			<?php echo $alert;?>
			<p>
			<label><strong>Title:</strong></label>
			<input type="text" name="send[title]" class="form-control" placeholder="Page title..." />
			</p>
			<p>
			<label><strong>Content:</strong></label>
			<textarea id="editor1" class="form-control ckeditor" rows="15" name="send[content]">Page content here (support BBCode)</textarea>
			</p>
			<p>
			<label><strong>SEO Keywords:</strong></label>
			<input type="text" name="send[keywords]" class="form-control" placeholder="Keywords..." />
			</p>

			<p>
			<button type="submit" class="btn btn-info" name="btnAdd">Add new</button>
			</p>
			</div>



		</form>
		</div>




	</div>    
    
  </div>
</div>
<script src="<?php echo ROOT_URL;?>bootstrap/admincp/js/chosen.jquery.min.js"></script>
  <script type="text/javascript">
      $("#jsCategory").chosen({max_selected_options: 1});
  </script>