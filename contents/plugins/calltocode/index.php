<?php

Plugins::install('install_calltocode');

Plugins::uninstall('uninstall_calltocode');

function install_calltocode()
{
	Dir::remove(CACHES_PATH.'dbcache/system/calltocode');
	
	Dir::remove(CACHES_PATH.'calltocode');

	$installPath=dirname(__FILE__).'/install/';

	$dbFile=$installPath.'db.sql';

	if(file_exists($dbFile))
	{
		Database::import($dbFile,Database::getPrefix());
	}

	File::copy($installPath.'CallToCode.php',ROOT_PATH.'includes/CallToCode.php');

	Shortcode::add('call','parse_calltocode');

	// // Add admincp left menu
	Plugins::add('admincp_menu','calltocode_admincp_menu');



}


function calltocode_creatcode()
{
	die('ok');
}

function uninstall_calltocode()
{
	Dir::remove(CACHES_PATH.'dbcache/system/calltocode');
	
	Dir::remove(CACHES_PATH.'calltocode');

	Database::dropTable('calltocode',Database::getPrefix());

	if(file_exists(ROOT_PATH.'includes/CallToCode.php'))
	{
		unlink(ROOT_PATH.'includes/CallToCode.php');
	}

}

function parse_calltocode($loadData=array())
{

	if(!isset($loadData['attr']['uri']))
	{
		return '';
	}

	$uri=md5(trim($loadData['attr']['uri']));

	$result=CallToCode::load($uri,$loadData['attr']);
	
	return $result;
}

function calltocode_admincp_menu()
{
	$menu=array(
			
			array(
				'title'=>'Call To Code',
				'child'=>array(
						0=>array(
							'title'=>'Manage',
							'controller'=>'manage'
							),
						1=>array(
							'title'=>'Add New',
							'link'=>System::getUrl().'admincp/plugins/controller/calltocode/manage/addnew'
							),

					)

				)
		);

	return $menu;
}


?>