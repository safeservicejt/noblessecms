<?php

 require(PLUGINS_PATH.$foldername.'/'.$fileName);

 if(isset($func))
 {
 	// $func=base64_decode($func);

 	$func();
 }
?>