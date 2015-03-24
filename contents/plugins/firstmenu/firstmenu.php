<?php

Plugins::install('install_firstmenu');



function install_firstmenu()
{
	Plugins::add('plugins_menu',array('text'=>'Plugin menu demo','filename'=>'ac.php'));
	//Plugins::add('admin_left_menu',array('text'=>'Left menu demo','filename'=>'left_menu.php'));
	//Plugins::add('admin_nav_menu',array('text'=>'Nav menu demo 1','filename'=>'left_menu.php'));
	//Plugins::add('admin_nav_menu',array('text'=>'Nav menu demo 2','filename'=>'left_menu.php'));
	//Plugins::add('setting_menu',array('text'=>'Setting menu demo','filename'=>'setting_menu.php'));
	//Plugins::add('themes_menu',array('text'=>'Setting menu demo','filename'=>'setting_menu.php'));

}

?>