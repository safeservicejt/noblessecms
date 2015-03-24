<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">List themes</h3>
  </div>
  <div class="panel-body">

<div class="row">
		<div class="col-lg-12">
		<?php echo $alert; ?>
		</div>
		<div class="col-lg-12">

			<div class="row">


				<?php
					$total=count($themes);

					$themeNames=array_keys($themes);

					for($i=0;$i<$total;$i++)
					{


				?>
				<!-- Theme Col -->
				<div class="col-lg-3 themeCol">
					<div class="row">
						<div class="col-lg-12 text-center">
							<img src="<?php echo $themes[$themeNames[$i]]['thumbnail'];?>" class="img-responsive" />
						
					</div>

						<div class="col-lg-12 themeSummary">
							<div class="themeDesc">
								<h4><?php echo $themes[$themeNames[$i]][0];?></h4>
								<span><small><?php echo $themes[$themeNames[$i]][1];?></small></span>
								<br>
								<span><small><?php echo $themes[$themeNames[$i]][2];?></small></span>

							</div>
						</div>
						<div class="col-lg-12 themeButton">
							<a href="<?php echo ROOT_URL;?>admincp/theme/activate/<?php echo $themeNames[$i];?>" class="btn btn-info">Activate</a>
							<a href="<?php echo ROOT_URL;?>admincp/theme/edit/<?php echo $themeNames[$i];?>" class="btn btn-danger pull-right">Edit</a>
						
						</div>
					</div>
				</div>

				<?php } ?>





			</div>
		</div>

	</div>
  </div>
</div>

