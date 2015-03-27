  <link rel="stylesheet" href="<?php echo ROOT_URL; ?>bootstrap/toggle/bootstrap-toggle.min.css">
<script src="<?php echo ROOT_URL; ?>bootstrap/toggle/bootstrap-toggle.min.js"></script>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Setting</h3>
  </div>
  <div class="panel-body">
<div class="row">
	<?php echo $alert;?>
		<div class="col-lg-12">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">

		  <li class="active"><a href="#general" role="tab" data-toggle="tab">General</a></li>
		  <li class="active"><a href="#info" role="tab" data-toggle="tab">Site information</a></li>

		  <li><a href="#logo" role="tab" data-toggle="tab">Banner</a></li>
		  <li><a href="#reading" role="tab" data-toggle="tab">Front Page</a></li>

		</ul>

		  
		<!-- Tab panes -->
		<div class="tab-content">

		  <!-- General		 -->		
		  
		  <div class="tab-pane active" id="general">
		  <form action="" method="post" enctype="multipart/form-data">	
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>System status :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[system_status]" class="form-control">
							<option value="working" <?php if($system_status=='working')echo 'selected';?> >Working</option>
								<option value="underconstruction" <?php if($system_status=='underconstruction')echo 'selected';?> >Under construction</option>
								<option value="comingsoon" <?php if($system_status=='comingsoon')echo 'selected';?> >Coming soon</option>

							</select>
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>System language :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[system_lang]" class="form-control">
							<option value="en" <?php if($system_lang=='en')echo 'selected';?> >English</option>
								<option value="vn" <?php if($system_lang=='vn')echo 'selected';?> >Vietnamese</option>

							</select>
			    		</div>

			    	</div>

			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>Default member user group :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[default_groupid]" class="form-control">
							<?php
								$total=count($usergroups);

								$li='';

								for($i=0;$i<$total;$i++)
								{
									if((int)$default_groupid==$usergroups[$i]['groupid'])
									{
										$li.='<option value="'.$usergroups[$i]['groupid'].'" selected>'.$usergroups[$i]['group_title'].'</option>';

									}
									else
									{
										$li.='<option value="'.$usergroups[$i]['groupid'].'">'.$usergroups[$i]['group_title'].'</option>';

									}
								
								}

								echo $li;
							?>
							</select>
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>Default banned user group :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[default_banned_groupid]" class="form-control">
							<?php
								$total=count($usergroups);

								$li='';

								for($i=0;$i<$total;$i++)
								{
									if((int)$default_banned_groupid==$usergroups[$i]['groupid'])
									{
										$li.='<option value="'.$usergroups[$i]['groupid'].'" selected>'.$usergroups[$i]['group_title'].'</option>';

									}
									else
									{
										$li.='<option value="'.$usergroups[$i]['groupid'].'">'.$usergroups[$i]['group_title'].'</option>';

									}
								
								}

								echo $li;
							?>
							</select>
			    		</div>

			    	</div>

			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>Date format :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[default_dateformat]" class="form-control">
							<option value="Y-m-d h:i:s" <?php if($default_dateformat=='Y-m-d h:i:s')echo 'selected';?> ><?php echo date('Y-m-d h:i:s');?></option>
							<option value="M d, Y" <?php if($default_dateformat=='M d, Y')echo 'selected';?>><?php echo date('M d, Y');?></option>
							<option value="d-m-Y" <?php if($default_dateformat=='d-m-Y')echo 'selected';?>><?php echo date('d-m-Y');?></option>
							<option value="M d, Y A" <?php if($default_dateformat=='M d, Y A')echo 'selected';?>><?php echo date('M d, Y A');?></option>

							</select>
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Turn On/Off register account ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<select name="general[enable_register]" class="form-control">
							<option value="1" <?php if((int)$enable_register==1)echo 'selected';?> >Enable</option>
							<option value="0" <?php if((int)$enable_register==0)echo 'selected';?> >Disabled</option>
							</select>							
			    		</div>

			    	</div>
				    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Turn On/Off comment on posts ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<select name="general[enable_comment]" class="form-control">
							<option value="1" <?php if((int)$enable_comment==1)echo 'selected';?> >Enable</option>
							<option value="0" <?php if((int)$enable_comment==0)echo 'selected';?> >Disabled</option>
							</select>								
			    		</div>

			    	</div>
				    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Turn On/Off RSS feeds ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<select name="general[enable_rss]" class="form-control">
							<option value="1" <?php if((int)$enable_rss==1)echo 'selected';?> >Enable</option>
							<option value="0" <?php if((int)$enable_rss==0)echo 'selected';?> >Disabled</option>
							</select>								
			    		</div>

			    	</div>
		  	<p>
		  	<button type="submit" name="btnSave" class="btn btn-info">Save Changes</button>
		  	</p>

		   </form> 	
		  </div>

		  <!-- General		 -->

		  
		  <div class="tab-pane" id="info">
		  	<form action="" method="post" enctype="multipart/form-data">	
		  <p>Title:</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="Title..." name="general[title]" value="<?php echo stripslashes($title);?>" />
		  	</p>
	<p>Description:</p>
  	<p>
		  	<input type="text" class="form-control" placeholder="Description..." name="general[description]" value="<?php echo stripslashes($description);?>" />
		  	</p>
	<p>Keywords:</p>		  		  			  
  	<p>
		  	<input type="text" class="form-control" placeholder="Keywords..." name="general[keywords]" value="<?php echo stripslashes($keywords);?>" />
		  	</p>
		  	<p>
		  	<button type="submit" name="btnSave" class="btn btn-info">Save Changes</button>
		  	</p>
		  	 </form>
		  </div>

		  <!-- Tab -->
		  
		  <div class="tab-pane" id="logo">
			<form action="" method="post" enctype="multipart/form-data">	
		  	<p>
		  	<input type="text" class="form-control" placeholder="Banner text..." name="general[banner_text]" value="<?php echo stripslashes($banner_text);?>" />
		  	</p>

		  	<p>
		  	<strong>Upload image:</strong>
		  	</p>
	  	<p>
		  <input type="file" class="form-control" name="bannerImg" />
		  	</p>

		  	<p>
		  	<button type="submit" name="btnSave" class="btn btn-info">Save Changes</button>
		  	</p>		  	
		  	</form>
		  </div>
		  <!-- End tab -->

		  <!-- Reading -->
		  
		  <div class="tab-pane" id="reading">
			<form action="" method="post" enctype="multipart/form-data">	
		  	<p>
		  		<strong>Default page:</strong>
		  	</p>
		  	<p>
		  		<select class="form-control selectDefault_page"  name="general[default_page]">
		  		<option value="home" <?php if($default_page=='home')echo 'selected';?>>Home</option>
		  		<option value="custompost" <?php if($default_page=='custompost')echo 'selected';?>>Custom post</option>
		  		<option value="custompage" <?php if($default_page=='custompage')echo 'selected';?>>Custom page</option>
		  		</select>
		  	</p>

		  	<p class="default_page" style="display:none;">
		  	<strong>Post/pageid default:</strong> <br>
		  		<input type="text" class="form-control" name="general[default_page_id]" value="<?php echo $default_page_id;?>" placeholder="1,2,3,4" />
		  	</p>

		  	<p>
		  	<button type="submit" name="btnSave" class="btn btn-info">Save Changes</button>
		  	</p>		  	
		  	</form>
		  </div>
		  <!-- End Reading -->

		</div>
	
		  

		</div>

	</div>    

  </div>
</div>

<script>

$(document).ready(function(){

	$('.selectDefault_page').change(function(){

		var thisVal=$(this).val();

		if(thisVal!='home')
		{
			$('.default_page').show();
		}
		else
		{
			$('.default_page').hide();
		}
	});
});
</script>