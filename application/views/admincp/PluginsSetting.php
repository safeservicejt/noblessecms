<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Setting - <?php echo ucfirst($foldername);?></h3>


  </div>
  <div class="panel-body">

	<?php

	$path=$filePath;

	if(file_exists($filePath))
	{
		require($filePath);

		if(!function_exists($func))
		{
			Alert::make('This plugin have not function for setting.');
		}
		else
		{
			$func();
		}
	}

	?>  
    
  </div>
</div>