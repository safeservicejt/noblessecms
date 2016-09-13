<div class="panel panel-default">

  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">

		    <div class="row">
		    	<div class="col-lg-12">
			    	<h3><?php echo Lang::get('usercp/index.linkBuilding');?></h3>
			    	<hr>		    	
				    <div class="input-group">
				      <input type="text" class="form-control txtUrl" name="txtUrl" required>
				      <span class="input-group-btn">
				        <button class="btn btn-primary btn-create-url" name="btnSend" type="button"><?php echo Lang::get('usercp/index.create');?></button>
				      </span>
				    </div><!-- /input-group -->
		    	</div>
		    </div>    	
    	</div>
    </div>
  </div>
</div>

<script type="text/javascript">
var api_url='<?php echo System::getUrl();?>api/plugins/fastecommerce/';

var userid='<?php echo Users::getCookieUserId();?>'

$(document).ready(function(){

	$('.btn-create-url').click(function(){

		var url=$('.txtUrl').val();

		if(url.length < 5)
		{
			alert('You have to enter link into text field.');

			return;
		}

		url+='?a='+userid;

		$('.txtUrl').val(url);
	});
});	

</script>