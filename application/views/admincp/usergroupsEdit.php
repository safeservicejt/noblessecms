
  <link rel="stylesheet" href="<?php echo ROOT_URL; ?>bootstrap/toggle/bootstrap-toggle.min.css">
<script src="<?php echo ROOT_URL; ?>bootstrap/toggle/bootstrap-toggle.min.js"></script>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit user group</h3>
  </div>
  <div class="panel-body">

<div class="row">
		<form action="" method="post" enctype="multipart/form-data">
			<div class="col-lg-12">

				<?php echo $alert;?>
			</div>		


		<div class="col-lg-12">


			<div role="tabpanel">

			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			  	<li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a></li>

			    <li role="presentation"><a href="#post" aria-controls="post" role="tab" data-toggle="tab">Post</a></li>
			    <li role="presentation"><a href="#category" aria-controls="category" role="tab" data-toggle="tab">Category</a></li>
			    <li role="presentation"><a href="#page" aria-controls="page" role="tab" data-toggle="tab">Page</a></li>
				<li role="presentation"><a href="#ecommerce" aria-controls="ecommerce" role="tab" data-toggle="tab">Ecommerce</a></li>
				 
			  
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content">

			  <!-- general -->
			    <div role="tabpanel" class="tab-pane active" id="general">

			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-12">
			    		<strong>Group title</strong>
			    		</div>
			    		<div class="col-lg-12">
							<input type="text" class="form-control" name="title" value="<?php echo stripslashes($title) ;?>" placeholder="Title..." />
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can view post ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_view_post]" value="1" <?php if(isset($data['can_view_post']) && (int)$data['can_view_post']==1) echo 'checked' ;?> data-toggle="toggle">
			    		</div>

			    	</div>

			    </div>
			    <!-- general -->

			  <!-- usercpAccess -->
			    <div role="tabpanel" class="tab-pane" id="post">

			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can manage post ?</strong>
			    		<br>
			    		User can manage, add new, edit post follow your below select if this option is turn ON
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_manage_post]" value="1"  <?php if(isset($data['can_manage_post']) && (int)$data['can_manage_post']==1) echo 'checked' ;?> data-toggle="toggle">
			    		</div>

			    	</div>
				    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can manage comments ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_manage_comment]" value="1"  <?php if(isset($data['can_manage_comment']) && (int)$data['can_manage_comment']==1) echo 'checked' ;?> data-toggle="toggle">
			    		</div>

			    	</div>

			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can add new post ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_addnew_post]" value="1"  <?php if(isset($data['can_addnew_post']) && (int)$data['can_addnew_post']==1) echo 'checked' ;?> data-toggle="toggle">
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can edit all post ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_editall_post]" value="1"  <?php if(isset($data['can_editall_post']) && (int)$data['can_editall_post']==1) echo 'checked' ;?> data-toggle="toggle">
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can delete post ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_delete_post]" value="1"  <?php if(isset($data['can_delete_post']) && (int)$data['can_delete_post']==1) echo 'checked' ;?> data-toggle="toggle">
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Default owner post status is Pending ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[default_post_status]" value="0"  <?php if(isset($data['default_post_status']) && (int)$data['default_post_status']==1) echo 'checked' ;?> data-toggle="toggle">
			    		</div>

			    	</div>

			    </div>
			  <!-- usercpAccess -->

			  <!-- category -->
			    <div role="tabpanel" class="tab-pane" id="category">
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can manage category ?</strong>
			    		<br>
			    		User can manage, add new, edit category follow your below select if this option is turn ON
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_manage_category]" value="1"  <?php if(isset($data['can_manage_category']) && (int)$data['can_manage_category']==1) echo 'checked' ;?> data-toggle="toggle">
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can add new category ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_addnew_category]" value="1"  <?php if(isset($data['can_addnew_category']) && (int)$data['can_addnew_category']==1) echo 'checked' ;?> data-toggle="toggle">
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can edit category ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_edit_category]" value="1"  <?php if(isset($data['can_edit_category']) && (int)$data['can_edit_category']==1) echo 'checked' ;?> data-toggle="toggle">
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can delete category ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_delete_category]" value="1"  <?php if(isset($data['can_delete_category']) && (int)$data['can_delete_category']==1) echo 'checked' ;?> data-toggle="toggle">
			    		</div>

			    	</div>

			    </div>
			    <!--category  -->
			  <!-- page -->
			    <div role="tabpanel" class="tab-pane" id="page">
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can manage page ?</strong>
			    		<br>
			    		User can manage, add new, edit page follow your below select if this option is turn ON
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_manage_page]" value="1"  <?php if(isset($data['can_manage_page']) && (int)$data['can_manage_page']==1) echo 'checked' ;?> data-toggle="toggle">
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can add new page ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_addnew_page]" value="1"  <?php if(isset($data['can_addnew_page']) && (int)$data['can_addnew_page']==1) echo 'checked' ;?> data-toggle="toggle">
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can edit page ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_edit_page]" value="1"  <?php if(isset($data['can_edit_page']) && (int)$data['can_edit_page']==1) echo 'checked' ;?> data-toggle="toggle">
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can delete page ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_delete_page]" value="1"  <?php if(isset($data['can_delete_page']) && (int)$data['can_delete_page']==1) echo 'checked' ;?> data-toggle="toggle">
			    		</div>

			    	</div>

			    </div>
			    <!--page  -->

				  <!-- Ecommerce -->
			    <div role="tabpanel" class="tab-pane" id="ecommerce">
			    	
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can manage all products ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_manage_own_product]" value="1" checked data-toggle="toggle">
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can add product ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_add_product]" value="1" checked data-toggle="toggle">
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can edit all products ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_edit_all_product]" value="1" checked data-toggle="toggle">
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can delete all products ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_delete_all_product]" value="1" checked data-toggle="toggle">
			    		</div>

			    	</div>

			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Turn ON/OFF Affiliates System ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[enable_affiliate]" value="1" checked data-toggle="toggle">
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can manage reviews ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_manage_review]" value="1" checked data-toggle="toggle">
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can manage gift vouchers ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_manage_voucher]" value="1" checked data-toggle="toggle">
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Can manage coupons ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<input type="checkbox" name="groupdata[can_manage_coupon]" value="1" checked data-toggle="toggle">
			    		</div>

			    	</div>


			    </div>
			    <!--Ecommerce  -->
			  </div>

			</div>



		</div>
		<div class="col-lg-12">
			<p>
			<button type="submit" class="btn btn-info" name="btnSave">Save changes</button>
			</p>
		</div>		
		</form>


	</div>    
    
  </div>
</div>
