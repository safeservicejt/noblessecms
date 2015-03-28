

<div class="panel panel-default">
  <div class="panel-body">

<div class="row">
		<div class="col-lg-12">
		<?php

		 require(PLUGINS_PATH.$foldername.'/'.$fileName);

		 if(isset($func))
		 {
		 	// $func=base64_decode($func);

		 	$func();
		 }

		?>
		</div>




	</div>    
    
  </div>
</div>