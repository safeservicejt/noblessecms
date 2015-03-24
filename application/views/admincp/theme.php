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

			<!-- main theme -->
			<div class="row" style="margin-bottom:50px;">
				<div class="col-lg-4">
				<img class="img-responsive" src="<?php echo THEME_URL;?>thumb.jpg" />
				</div>

				<!-- right -->
				<div class="col-lg-8">
				<h4><strong><?php echo ucfirst($theme[0]);?></strong></h4>

				<p>
				<span>Author: <?php echo ucfirst($theme[1]);?></span>
				</p>
				<p>
				<span>Author email: <?php echo ucfirst($theme[2]);?></span>
				</p>
				<p>
				<span>Description: <?php echo ucfirst($theme[3]);?></span>
				</p>

				<!-- row -->
				<div class="row">
					<div class="col-lg-12">
					<a href="<?php echo ROOT_URL;?>admincp/theme/setting/<?php echo THEME_NAME;?>" class="btn btn-primary">Setting</a>
					<a href="<?php echo ROOT_URL;?>admincp/theme/edit/<?php echo THEME_NAME;?>" class="btn btn-warning" style="margin-left:10px;">Edit</a>
					</div>					
				</div>
				<!-- row -->
				</div>



				<!-- right -->
			</div>
			<!-- main theme -->

			<div class="row">


				<?php
					$total=count($listThemes);

					$themeNames=array_keys($listThemes);

					for($i=0;$i<$total;$i++)
					{


				?>
				<!-- Theme Col -->
				<div class="col-lg-3 themeCol">
					<div class="row">
						<div class="col-lg-12 text-center">
							<img src="<?php echo $listThemes[$themeNames[$i]]['thumbnail'];?>" class="img-responsive" />
						
					</div>

						<div class="col-lg-12 themeSummary">
							<div class="themeDesc">
								<h4><?php echo $listThemes[$themeNames[$i]][0];?></h4>
								<span><small><?php echo $listThemes[$themeNames[$i]][1];?></small></span>
								<br>
								<span><small><?php echo $listThemes[$themeNames[$i]][2];?></small></span>

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

