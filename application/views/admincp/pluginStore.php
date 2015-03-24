
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Lastest Plugins</h3>
  </div>
  <div class="panel-body">
    
    <!-- row -->
  <div class="row">
  	<?php

  	$total=count($theList);

  	$li='';

  	if(isset($theList[0]['postid']))
  	for($i=0;$i<$total;$i++)
  	{
  		$li.='

				<!-- Theme Col -->
				<div class="col-lg-3 themeCol">
					<div class="row">
						<div class="col-lg-12 text-center">
							<a href="'.$theList[$i]['preview_url'].'" target="_blank"><img src="'.$theList[$i]['imageUrl'].'" class="img-responsive" /></a>
						
					</div>

						<div class="col-lg-12 themeSummary">
							<div class="themeDesc">
								<h4>'.$theList[$i]['title'].'</h4>
							</div>
						</div>
						<div class="col-lg-12 themeButton">
							<button type="button" class="btn btn-primary btnDownloadTemplate" data-title="'.$theList[$i]['title'].'" data-url="'.$theList[$i]['download_url'].'"><span class="glyphicon glyphicon-download-alt"></span> Download</button>

							<a href="'.$theList[$i]['preview_url'].'" target="_blank" class="btn btn-warning pull-right"><span class="glyphicon glyphicon-th-large"></span> Demo</a>
						
						</div>
					</div>
				</div>

  		';
  	}
  	else
  	{
  		$li='<strong style="margin-left:15px;">There not have any plugin for download.</strong>';
  	}

  	echo $li;

  	?>
  	
  </div>



    <!-- row -->
  </div>
</div>

<div class="row">
	<div class="col-lg-12 text-right">
		<?php  echo $pages; ?>
	</div>
</div>


<script>

var root_url='<?php echo ROOT_URL;?>';

$(document).ready(function(){

	$('button.btnDownloadTemplate').click(function(){
		if(confirm('Are you wanna download this plugin ?'))
		{
			var theTitle=$(this).attr('data-title');

			var theUrl=$(this).attr('data-url');

			$(this).val('Loading...');

			$.ajax({
		   type: "POST",
		   url: root_url+'api/download/plugin',
		   data: ({
				  fileUrl : theUrl,
				  fileTitle : theTitle
				  }),
		   dataType: "json",
		   success: function(msg)
							{
								 if(msg['error']=='yes')
								 {
								 	alert('Error! Contact us for get more information');

								 	$(this).val('Error !');
								 }
								 else
								 {
								 	alert('Success. Check you plugin list for see this plugin');

								 	$(this).val('Completed !');
								 }

							 }
				 });			
		}

	});


});

</script>
