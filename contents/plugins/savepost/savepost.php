<?php

Plugins::install('install_savepost');



function install_savepost()
{
	Plugins::add('after_insert_post',array('text'=>'Test save post','func'=>'saveData_savepost'));
	//Plugins::add('admin_left_menu',array('text'=>'Left menu demo','filename'=>'left_menu.php'));
	//Plugins::add('admin_nav_menu',array('text'=>'Nav menu demo 1','filename'=>'left_menu.php'));
	//Plugins::add('admin_nav_menu',array('text'=>'Nav menu demo 2','filename'=>'left_menu.php'));
	//Plugins::add('setting_menu',array('text'=>'Setting menu demo','filename'=>'setting_menu.php'));
	//Plugins::add('themes_menu',array('text'=>'Setting menu demo','filename'=>'setting_menu.php'));

}

function saveData_savepost($inputData=array())
{
	$data=json_encode($inputData);

	File::create(ROOT_PATH.'savepost_'.$inputData['postid'].'.txt',$data);

}

?>