<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo ucfirst($func);?> - <?php echo ucfirst($foldername);?> plugin

	<div class="pull-right">

	<button type="button" class="btn btn-primary btn-xs" id="btnAddMore">Add more</button>
	<button type="button" id="btnSave" class="btn btn-info btn-xs">Save</button>

	</div>
    </h3>


  </div>
  <div class="panel-body">

	<div class="row">

	<form action="" id="formControl" method="post" action="multipart/form-data">
	<input type="hidden" name="foldername" value="<?php echo $foldername;?>" />
	<input type="hidden" name="func" value="<?php echo $func;?>" />
	<input type="hidden" name="btnSave" value="Save" />

		<div class="col-lg-12 listControls">

			<div class="row">
				<div class="col-lg-1">
				Limit
				</div>
				<div class="col-lg-3">
				Image (W x H) and Resize Type
				</div>
				<div class="col-lg-2">
				Layout
				</div>
				<div class="col-lg-2">
				Position
				</div>
				<div class="col-lg-2">
				Status
				</div>
				<div class="col-lg-1">
				Sort order
				</div>
				<div class="col-lg-1">
				
				</div>

			</div>

			<?php
				$total=count($plugins);

				for($i=0;$i<$total;$i++)
				{
?>

			<!-- Plugin -->
			<div class="row">
				<div class="col-lg-1">
				<input type="text" class="form-control" name="limit[]" value="<?php echo $plugins[$i]['limit_number'];?>" />
				</div>
				<div class="col-lg-3">
				<span>W:</span><input type="text" name="width[]" value="5" />
				&nbsp;&nbsp;&nbsp;<span>H:</span><input type="text" name="height[]" value="5" />
				</div>
				<div class="col-lg-2">
				<select name="layout[]" class="form-control">
				<?php
				$totalLayouts=count($layouts);

				$li='';

				if(isset($layouts[0]['layoutid']))
				for($j=0;$j<$totalLayouts;$j++)
				{
					if($plugins[$i]['pagename']==strtolower($layouts[$j]['layoutname']))
					{
						$li.='<option value="'.strtolower($layouts[$j]['layoutname']).'" selected>'.ucfirst($layouts[$j]['layoutname']).'</option>';
					}
					else
					{
						$li.='<option value="'.strtolower($layouts[$j]['layoutname']).'">'.ucfirst($layouts[$j]['layoutname']).'</option>';

					}

				}

				echo $li;

				?>
				</select>
				</div>
				<div class="col-lg-2">
				<select name="position[]" class="form-control">
				<option value="content_top"<?php if($plugins[$i]['zonename']=='content_top')echo ' selected ';?>>Content Top</option>
				<option value="content_left"<?php if($plugins[$i]['zonename']=='content_left')echo ' selected ';?>>Content Left</option>
				<option value="content_right"<?php if($plugins[$i]['zonename']=='content_right')echo ' selected ';?>>Content Right</option>
				<option value="content_bottom"<?php if($plugins[$i]['zonename']=='content_bottom')echo ' selected ';?>>Content Bottom</option>
				</select>
				</div>
				<div class="col-lg-2">
				<select name="status[]" class="form-control">
				<option value="enable"<?php if((int)$plugins[$i]['status']==1)echo ' selected ';?>>Enable</option>
				<option value="disable"<?php if((int)$plugins[$i]['status']==0)echo ' selected ';?>>Disable</option>
				</select>
				</div>
				<div class="col-lg-1">
				<input type="text" class="form-control" name="sort_order[]" value="<?php echo $plugins[$i]['layoutposition'];?>" />
				</div>
				<div class="col-lg-1" id="btnAction">
				<button type="button" class="btn btn-warning btn-xs" id="btnRemove">Remove</button>

				</div>

			</div>




<?php
				}
			?>





		</div>	
	</form>	

		<div class="col-lg-12 hidden" id="Savetemplate">
			<!-- Plugin -->
			<div class="row">
				<div class="col-lg-1">
				<input type="text" class="form-control" name="limit[]" value="5" />
				</div>
				<div class="col-lg-3">
				<span>W:</span><input type="text" name="width[]" value="5" />
				&nbsp;&nbsp;&nbsp;<span>H:</span><input type="text" name="height[]" value="5" />
				</div>
				<div class="col-lg-2">
				<select name="layout[]" class="form-control">
				<?php
				$total=count($layouts);

				if(isset($layouts[0]['layoutid']))

					$li='';
					for($i=0;$i<$total;$i++)
					{
							$li.='<option value="'.strtolower($layouts[$i]['layoutname']).'">'.ucfirst($layouts[$i]['layoutname']).'</option>';


					}

					echo $li;

				?>
				</select>
				</div>
				<div class="col-lg-2">
				<select name="position[]" class="form-control">
				<option value="content_top">Content Top</option>
				<option value="content_left">Content Left</option>
				<option value="content_right">Content Right</option>
				<option value="content_bottom">Content Bottom</option>
				</select>
				</div>
				<div class="col-lg-2">
				<select name="status[]" class="form-control">
				<option value="enable">Enable</option>
				<option value="disable">Disable</option>
				</select>
				</div>
				<div class="col-lg-1">
				<input type="text" class="form-control" name="sort_order[]" value="0" />
				</div>
				<div class="col-lg-1" id="btnAction">
				<button type="button" class="btn btn-warning btn-xs" id="btnRemove">Remove</button>

				</div>

			</div>
		</div>

		<script type="text/javascript">


		$(document).ready(function(){
			
			$('#btnSave').click(function(){

				$('#formControl').submit();
			});
		});

		$( document ).on( "click", "button#btnAddMore", function() {

				// $(this).hide();

				var template=$('#Savetemplate').html();
				// alert($('#listControls').html());
				$('.listControls').append(template);

				// $(this).parent().children('button#btnRemove').show();
		});			
		$( document ).on( "click", "button#btnRemove", function() {

				$(this).parent().parent().remove();
		});			

		</script>



	</div>    
    
  </div>
</div>