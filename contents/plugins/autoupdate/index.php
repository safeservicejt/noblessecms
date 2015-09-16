<?php

Plugins::install('install_autoupdate');

Plugins::uninstall('uninstall_autoupdate');

function detect_update_system()
{
	$loadData=Update::get();

	$encodeData=serialize($loadData);

	$md5Data=md5($encodeData);

	$path=CACHES_PATH.'dbcache/plugin/autoupdate/';

	$filePath=$path.$md5Data.'.cache';

	if(!file_exists($filePath))
	{
		Update::make();

		File::create($filePath,'ok');
	}
}

function install_autoupdate()
{
	Dir::remove(CACHES_PATH.'dbcache/plugin/autoupdate');

	// Cronjobs::add(1440,'min',PLUGINS_PATH.'autoupdate/index.php','detect_update_system');
	Cronjobs::add(PLUGINS_PATH.'autoupdate/index.php','detect_update_system',1440,'min');

}

function uninstall_autoupdate()
{
	Dir::remove(CACHES_PATH.'dbcache/plugin/autoupdate');

	Cronjobs::delete(PLUGINS_PATH.'autoupdate/index.php','detect_update_system');


}


?>