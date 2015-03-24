<?php

Plugins::$control='second_menu_lastest_news';

Plugins::install('install_secondsmenu');


function install_secondsmenu()
{
	// Plugins::add('admin_header',array('content'=>'<script>var Contentcontrol="demo";</script>'));

}


function second_menu_lastest_news($inputData=array())
{
	return 'Lastest news menu 2';
}
?>