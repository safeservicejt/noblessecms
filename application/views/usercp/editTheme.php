<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit Theme: <span class="text-primary"><?php echo $themeName;?></span></h3>
  </div>
  <div class="panel-body">
<div class="row">

		<div class="col-lg-12">
			<h5>List Dir: <?php if(isset($lastDir[1])) echo '<a href="'.ROOT_URL.$lastDir.'" class="text-danger"><- Go Back</a>';?></h5>
			<ul class="listFiles">
			<?php
				$total=count($listDir);

				for($i=0;$i<$total;$i++)
				{
					echo '<li><a href="'.ROOT_URL.'admincp/theme/edit/'.$themeName.'/path/'.$scanPath.'/'.$listDir[$i].'">'.$listDir[$i].'</a></li>';
				}
			?>

			</ul>
		</div>
		<div class="col-lg-12">
			<h5>List Files:</h5>
			<ul class="listFiles">

				<?php
				$total=count($listFiles);

				for($i=0;$i<$total;$i++)
				{
					echo '<li><a href="'.ROOT_URL.'admincp/theme/edit/'.$themeName.'/path/'.$scanPath.'/'.$listFiles[$i].'">'.$listFiles[$i].'</a></li>';
				}
				?>

			</ul>
		</div>

		<div class="col-lg-8">
		<form action="" method="post" enctype="multipart/form-data">

			<h5>Source: <span class="text-danger"><?php echo $fileName;?></span></h5>

			<?php echo $alert;?>

		</div>		

		<div class="col-lg-4 text-right">
				<?php
					if(isset($fileName[1]))
					{
				?>
			<button type="submit" name="btnSave" class="btn btn-xs btn-info">Save Changes</button>
				<?php } ?>
		</div>		


		<div class="col-lg-12">

			<textarea id="showCode" name="fileSource" rows="20" class="form-control showCode"><?php echo $fileSource;?></textarea>
			
			</form>
		</div>

	</div>    
    
  </div>
</div>