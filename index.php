<?php
ob_start();
session_start();
error_reporting(0);

// Check install or not
if(file_exists('install/index.php'))
{
	header("Location: install/");
}

require('./config.php');

require('./functions.php');

require(ROOT_PATH . 'routes.php');

/* Codeme PHP Framework v2.0 - Write & Develop by [Minh Tien] - Email: safeservicejt@gmail.com
 * You will create & define route here. Route will check then load controller which you create.
 *
 *
 *
 */
?>