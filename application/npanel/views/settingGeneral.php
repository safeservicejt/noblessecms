
<form action="" method="post" enctype="multipart/form-data">	
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">System Setting</h3>
  </div>
  <div class="panel-body">
<div class="row">
		<div class="col-lg-12">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">

		  <li class="active"><a href="#general" role="tab" data-toggle="tab">General</a></li>
		  <li><a href="#info" role="tab" data-toggle="tab">Site information</a></li>
		  <li><a href="#adminpage" role="tab" data-toggle="tab">Admin Page</a></li>
		  <li><a href="#reading" role="tab" data-toggle="tab">Front Page</a></li>
		  <li><a href="#sitemap" role="tab" data-toggle="tab">Sitemap</a></li>

		</ul>

		  
		<!-- Tab panes -->
		<div class="tab-content">

		  <!-- General		 -->		
		  
		  <div class="tab-pane active" id="general">
		  
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>System status :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[system_status]" id="system_status" class="form-control">
							<option value="working">Working</option>
								<option value="underconstruction">Under construction</option>
								<option value="comingsoon">Coming soon</option>

							</select>
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>System mode :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[system_mode]" id="system_mode" class="form-control">
								<option value="basic">Basic (Fast)</option>
								<option value="debug">Debug</option>
								<option value="ultimate">Ultimate (Coming soon)</option>
							</select>
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>System captcha :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[system_captcha]" id="system_captcha" class="form-control">
								<option value="enable">Enable</option>
								<option value="disable">Disable</option>
							</select>
			    		</div>

			    	</div>

			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>System language :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[system_lang]" id="system_lang" class="form-control">
							<option value="en">English</option>
								<option value="vn">Vietnamese</option>

							</select>
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>Register user status :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[register_user_status]" id="register_user_status" class="form-control">
							<option value="enable">Enable</option>
								<option value="disable">Disable</option>

							</select>
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>Verify email user after register completed :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[register_verify_email]" id="register_verify_email" class="form-control">
							<option value="enable">Enable</option>
								<option value="disable">Disable</option>

							</select>
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>Default member user group :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[default_member_groupid]" id="default_member_groupid" class="form-control">
							<?php
								$total=count($usergroups);

								$li='';

								for($i=0;$i<$total;$i++)
								{
									if((int)$default_member_groupid==$usergroups[$i]['id'])
									{
										$li.='<option value="'.$usergroups[$i]['id'].'" selected>'.$usergroups[$i]['title'].'</option>';

									}
									else
									{
										$li.='<option value="'.$usergroups[$i]['id'].'">'.$usergroups[$i]['title'].'</option>';

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
							<select name="general[default_member_banned_groupid]" id="default_member_banned_groupid" class="form-control">
							<?php
								$total=count($usergroups);

								$li='';

								for($i=0;$i<$total;$i++)
								{
									if((int)$default_member_banned_groupid==$usergroups[$i]['id'])
									{
										$li.='<option value="'.$usergroups[$i]['id'].'" selected>'.$usergroups[$i]['title'].'</option>';

									}
									else
									{
										$li.='<option value="'.$usergroups[$i]['id'].'">'.$usergroups[$i]['title'].'</option>';

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
							<select name="general[default_dateformat]" id="default_dateformat" class="form-control">
							<option value="m/d/Y h:i:s" ><?php echo date('m/d/Y h:i:s');?></option>
							<option value="M d, Y"><?php echo date('M d, Y');?></option>
							<option value="m-d-Y"><?php echo date('m-d-Y');?></option>
							<option value="M d, Y A" ><?php echo date('M d, Y A');?></option>
							<option value="m-d-Y h:i" ><?php echo date('m-d-Y h:i');?></option>
							<option value="M d, Y h:i"><?php echo date('M d, Y h:i');?></option>
							<option value="m-d-Y h:i"><?php echo date('m-d-Y h:i');?></option>
							<option value="M d, Y h:i A" ><?php echo date('M d, Y h:i A');?></option>

							</select>
			    		</div>

			    	</div>
				    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Turn On/Off comment on posts ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<select name="general[comment_status]" id="comment_status" class="form-control">
							<option value="enable" >Enable</option>
							<option value="disabled" >Disabled</option>
							</select>								
			    		</div>

			    	</div>
				    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Turn On/Off RSS feeds ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<select name="general[rss_status]" id="rss_status" class="form-control">
							<option value="enable">Enable</option>
							<option value="disabled" >Disabled</option>
							</select>								
			    		</div>

			    	</div>


		  	<p>
		  	<button type="submit" name="btnSave" class="btn btn-info">Save Changes</button>
		  	</p>

		  
		  </div>

		  <!-- General		 -->

		  
		  <div class="tab-pane" id="info">
		  	
		  <p>Title:</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="Title..." name="general[title]" id="title" value="<?php echo $title;?>" />
		  	</p>
	<p>Description:</p>
  	<p>
		  	<input type="text" class="form-control" placeholder="Description..." name="general[descriptions]" id="descriptions" value="<?php echo $descriptions;?>" />
		  	</p>
	<p>Keywords:</p>		  		  			  
  	<p>
		  	<input type="text" class="form-control" placeholder="Keywords..." name="general[keywords]" id="keywords" value="<?php echo $keywords;?>" />
		  	</p>
		  	<p>
		  	<button type="submit" name="btnSave" class="btn btn-info">Save Changes</button>
		  	</p>
		 
		  </div>


		  <!-- Reading -->
		  
		  <div class="tab-pane" id="reading">
			
		  	<p>
		  		<strong>Default page:</strong>
		  	</p>
		  	<p>
		  		<select class="form-control selectDefault_page" id="default_page_method"  name="general[default_page_method]">
		  		<option value="none">Home</option>
		  		<option value="url">Custom uri</option>
		  		</select>
		  	</p>

		  	<p class="default_page" style="display:none;">
		  	<strong>Post/pageid default:</strong> <br>
		  		<input type="text" class="form-control" name="general[default_page_url]" id="default_page_url" value="<?php echo $default_page_url;?>" placeholder="post/test_post.html" />
		  	</p>

		  	<p>
		  	<button type="submit" name="btnSave" class="btn btn-info">Save Changes</button>
		  	</p>		  	
		 
		  </div>
		  <!-- End Reading -->

		  <!-- Admin Page -->
		  
		  <div class="tab-pane" id="adminpage">
			
		  	<p>
		  		<strong>Default page:</strong>
		  	</p>
		  	<p>
		  		<select class="form-control selectDefault_adminpage" id="default_adminpage_method"  name="general[default_adminpage_method]">
		  		<option value="none">Home</option>
		  		<option value="url">Custom uri</option>
		  		</select>
		  	</p>

		  	<p class="default_adminpage" style="display:none;">
		  	<strong>Post/pageid default:</strong> <br>
		  		<input type="text" class="form-control" name="general[default_adminpage_url]" id="default_adminpage_url" value="<?php if(isset($default_adminpage_url))echo $default_adminpage_url;?>" placeholder="/post" />
		  	</p>

		  	<p>
		  	<button type="submit" name="btnSave" class="btn btn-info">Save Changes</button>
		  	</p>		  	
		 
		  </div>
		  <!-- End Admin Page -->
		  <!-- Site Map -->
		  
		  <div class="tab-pane" id="sitemap">
			
	    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
	    		<div class="col-lg-9">
	    		<strong>Enable Site Map :</strong>
	    		</div>
	    		<div class="col-lg-3 text-right">
					<select name="general[enable_sitemap]" id="enable_sitemap" class="form-control">
					
					<option value="no">No</option>
					<option value="yes" <?php if(isset($enable_sitemap) && $enable_sitemap=='yes') echo 'selected';?>>Yes</option>
					</select>
	    		</div>

	    	</div>
			
	    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
	    		<div class="col-lg-9">
	    		<strong>Show Page's Urls :</strong>
	    		</div>
	    		<div class="col-lg-3 text-right">
					<select name="general[show_page_url_in_sitemap]" id="show_page_url_in_sitemap" class="form-control">
					<option value="yes">Yes</option>
					<option value="no" <?php if(isset($show_page_url_in_sitemap) && $show_page_url_in_sitemap=='no') echo 'selected';?>>No</option>
					</select>
	    		</div>

	    	</div>
			
	    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
	    		<div class="col-lg-9">
	    		<strong>Limit Page's Url :</strong>
	    		</div>
	    		<div class="col-lg-3 text-right">
					<input type="text" name="general[limit_page_url_in_sitemap]" class="form-control" value="<?php echo Request::get('general.limit_page_url_in_sitemap',System::getSetting('limit_page_url_in_sitemap',0));?>">
	    		</div>

	    	</div>
			
	    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
	    		<div class="col-lg-9">
	    		<strong>Show Post's Urls :</strong>
	    		</div>
	    		<div class="col-lg-3 text-right">
					<select name="general[show_post_url_in_sitemap]" id="show_post_url_in_sitemap" class="form-control">
					<option value="yes">Yes</option>
					<option value="no" <?php if(isset($show_post_url_in_sitemap) && $show_post_url_in_sitemap=='no') echo 'selected';?>>No</option>
					</select>
	    		</div>

	    	</div>
			
	    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
	    		<div class="col-lg-9">
	    		<strong>Limit Post's Url :</strong>
	    		</div>
	    		<div class="col-lg-3 text-right">
					<input type="text" name="general[limit_post_url_in_sitemap]" class="form-control" value="<?php echo Request::get('general.limit_post_url_in_sitemap',System::getSetting('limit_post_url_in_sitemap',0));?>">
	    		</div>

	    	</div>
			
	    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
	    		<div class="col-lg-9">
	    		<strong>Show Category's Urls :</strong>
	    		</div>
	    		<div class="col-lg-3 text-right">
					<select name="general[show_category_url_in_sitemap]" id="show_category_url_in_sitemap" class="form-control">
					<option value="yes">Yes</option>
					<option value="no" <?php if(isset($show_category_url_in_sitemap) && $show_category_url_in_sitemap=='no') echo 'selected';?>>No</option>
					</select>
	    		</div>

	    	</div>
	    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
	    		<div class="col-lg-9">
	    		<strong>Limit Category's Url :</strong>
	    		</div>
	    		<div class="col-lg-3 text-right">
					<input type="text" name="general[limit_category_url_in_sitemap]" class="form-control" value="<?php echo Request::get('general.limit_category_url_in_sitemap',System::getSetting('limit_category_url_in_sitemap',0));?>">
	    		</div>

	    	</div>
			
	    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
	    		<div class="col-lg-9">
	    		<strong>Show Link's Urls :</strong>
	    		</div>
	    		<div class="col-lg-3 text-right">
					<select name="general[show_link_url_in_sitemap]" id="show_link_url_in_sitemap" class="form-control">
					<option value="yes">Yes</option>
					<option value="no" <?php if(isset($show_link_url_in_sitemap) && $show_link_url_in_sitemap=='no') echo 'selected';?>>No</option>
					</select>
	    		</div>

	    	</div>
	    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
	    		<div class="col-lg-9">
	    		<strong>Limit Link's Url :</strong>
	    		</div>
	    		<div class="col-lg-3 text-right">
					<input type="text" name="general[limit_link_url_in_sitemap]" class="form-control" value="<?php echo Request::get('general.limit_link_url_in_sitemap',System::getSetting('limit_link_url_in_sitemap',0));?>">
	    		</div>

	    	</div>


		  	<p>
		  	<button type="submit" name="btnSave" class="btn btn-info">Save Changes</button>
		  	<button type="submit" name="btnRefreshSiteMap" class="btn btn-danger">Refresh Site Map</button>
		  	</p>		  	
		 
		  </div>
		  <!-- End Site Map -->

		</div>
	
		  

		</div>

	</div>    

  </div>
</div>
</form>
<script>

$(document).ready(function(){

	$('.selectDefault_page').change(function(){

		var thisVal=$(this).val();

		if(thisVal!='none')
		{
			$('.default_page').show();
		}
		else
		{
			$('.default_page').hide();
		}
	});

	$('.selectDefault_adminpage').change(function(){

		var thisVal=$(this).val();

		if(thisVal!='none')
		{
			$('.default_adminpage').show();
		}
		else
		{
			$('.default_adminpage').hide();
		}
	});


	setSelect('default_adminpage_method','<?php if(isset($default_adminpage_method))echo $default_adminpage_method;?>');
	setSelect('default_page_method','<?php echo $default_page_method;?>');
	setSelect('rss_status','<?php echo $rss_status;?>');
	setSelect('comment_status','<?php echo $comment_status;?>');
	setSelect('default_dateformat','<?php echo $default_dateformat;?>');
	setSelect('default_member_banned_groupid','<?php echo $default_member_banned_groupid;?>');
	setSelect('default_member_groupid','<?php echo $default_member_groupid;?>');
	setSelect('register_user_status','<?php echo $register_user_status;?>');
	setSelect('system_lang','<?php echo $system_lang;?>');
	setSelect('system_status','<?php echo $system_status;?>');
	setSelect('register_verify_email','<?php echo $register_verify_email;?>');
	setSelect('default_timezone','<?php echo $default_timezone;?>');
	setSelect('system_mode','<?php echo $system_mode;?>');
	setSelect('system_captcha','<?php echo $system_captcha;?>');

});

function setSelect(id,value)
{
	$('#'+id+' option').each(function(){
		var thisVal=$(this).val();

		if(thisVal==value)
		{
			$(this).attr('selected',true);
		}


	});
}
</script>