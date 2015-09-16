<?php

Plugins::install('install_fastindex');

Plugins::uninstall('uninstall_fastindex');

function install_fastindex()
{
	Dir::remove(CACHES_PATH.'dbcache/system/fastindex');
	
	Dir::remove(CACHES_PATH.'fastindex');

	// Cronjobs::add(1440,'min',PLUGINS_PATH.'fastindex/index.php','fastindex_ping');
	
	Cronjobs::add(PLUGINS_PATH.'fastindex/index.php','fastindex_ping',1440,'min');

}

function fastindex_ping()
{
	$filePath=PLUGINS_PATH.'fastindex/install/ping.php';

	include($filePath);
}


function uninstall_fastindex()
{
	Dir::remove(CACHES_PATH.'dbcache/system/fastindex');
	
	Dir::remove(CACHES_PATH.'fastindex');

	Cronjobs::delete(PLUGINS_PATH.'fastindex/index.php','fastindex_ping');


}

?>