<?php

Plugins::install('install_fastbb');

Plugins::uninstall('uninstall_fastbb');

function install_fastbb()
{

	$installPath=dirname(__FILE__).'/install/';

	$dbFile=$installPath.'db.sql';

	if(file_exists($dbFile))
	{
		Database::import($dbFile);
	}

	File::copy($installPath.'FastbbActivities.php',ROOT_PATH.'includes/FastbbActivities.php');
	File::copy($installPath.'FastbbFiles.php',ROOT_PATH.'includes/FastbbFiles.php');
	File::copy($installPath.'FastbbForums.php',ROOT_PATH.'includes/FastbbForums.php');
	File::copy($installPath.'FastbbForumsPermission.php',ROOT_PATH.'includes/FastbbForumsPermission.php');
	File::copy($installPath.'FastbbNotify.php',ROOT_PATH.'includes/FastbbNotify.php');
	File::copy($installPath.'FastbbOnlines.php',ROOT_PATH.'includes/FastbbOnlines.php');
	File::copy($installPath.'FastbbPost.php',ROOT_PATH.'includes/FastbbPost.php');
	File::copy($installPath.'FastbbPostIcons.php',ROOT_PATH.'includes/FastbbPostIcons.php');
	File::copy($installPath.'FastbbSmiles.php',ROOT_PATH.'includes/FastbbSmiles.php');
	File::copy($installPath.'FastbbThreads.php',ROOT_PATH.'includes/FastbbThreads.php');
	File::copy($installPath.'FastbbUserGroups.php',ROOT_PATH.'includes/FastbbUserGroups.php');
	File::copy($installPath.'FastbbUsers.php',ROOT_PATH.'includes/FastbbUsers.php');
	File::copy($installPath.'FastbbCore.php',ROOT_PATH.'includes/FastbbCore.php');

	Plugins::add('admincp_menu','fastbb_admincp_menu');

}

function fastbb_admincp_menu()
{
	$menu=array(
			
			array(
				'title'=>'FastBB System',
				'child'=>array(
						0=>array(
							'title'=>'Statistics',
							'controller'=>'stats'
							),
						1=>array(
							'title'=>'System Setting',
							'controller'=>'systemsetting'
							)


					)

				),
			array(
				'title'=>'Forum Manager',
				'child'=>array(
						0=>array(
							'title'=>'List Forums',
							'controller'=>'listforums'
							),
						1=>array(
							'title'=>'Add new forum',
							'controller'=>'listforums/addnew'
							)


					)

				),
			array(
				'title'=>'Thread Manager',
				'child'=>array(
						0=>array(
							'title'=>'List Threads',
							'controller'=>'listthreads'
							)

					)

				),
			array(
				'title'=>'Users Manager',
				'child'=>array(
						0=>array(
							'title'=>'List Users',
							'controller'=>'users'
							),
						1=>array(
							'title'=>'Delete Users',
							'controller'=>'users/delete'
							),
						2=>array(
							'title'=>'Ban Users',
							'controller'=>'users/ban'
							),
						3=>array(
							'title'=>'View Banned Users',
							'controller'=>'users'
							)


					)

				),
			array(
				'title'=>'Usergroups Manager',
				'child'=>array(
						0=>array(
							'title'=>'List Usergroups',
							'controller'=>'usergroups'
							),
						1=>array(
							'title'=>'Add New Usergroups',
							'controller'=>'usergroups/addnew'
							)


					)

				),

			array(
				'title'=>'User Titles',
				'child'=>array(
						0=>array(
							'title'=>'List User Titles',
							'controller'=>'usertitles'
							)

					)

				),
			array(
				'title'=>'Smiles',
				'child'=>array(
						0=>array(
							'title'=>'List smiles',
							'controller'=>'smiles'
							)

					)

				),
			array(
				'title'=>'BBCodes Manager',
				'child'=>array(
						0=>array(
							'title'=>'List BBCodes',
							'controller'=>'bbcodes'
							)

					)

				),
			array(
				'title'=>'Plugins Manager',
				'child'=>array(
						0=>array(
							'title'=>'List plugins',
							'controller'=>'plugins'
							),
						1=>array(
							'title'=>'Import',
							'controller'=>'plugins/import'
							)

					)

				),
			array(
				'title'=>'Themes Manager',
				'child'=>array(
						0=>array(
							'title'=>'List themes',
							'controller'=>'themes'
							),
						1=>array(
							'title'=>'Import',
							'controller'=>'themes/import'
							)

					)

				)

		);

	return $menu;	
}

function uninstall_fastbb()
{
	Database::query('drop table fastbb_activity');	
	Database::query('drop table fastbb_files');	
	Database::query('drop table fastbb_forums');	
	Database::query('drop table fastbb_forum_permission');	
	Database::query('drop table fastbb_notify');	
	Database::query('drop table fastbb_online');	
	Database::query('drop table fastbb_post');	
	Database::query('drop table fastbb_post_icons');	
	Database::query('drop table fastbb_smiles');	
	Database::query('drop table fastbb_thread');	
	Database::query('drop table fastbb_usergroups');	
	Database::query('drop table fastbb_users');	

	if(file_exists(ROOT_PATH.'includes/FastbbActivities.php'))
	{
		unlink(ROOT_PATH.'includes/FastbbActivities.php');
	}
	if(file_exists(ROOT_PATH.'includes/FastbbFiles.php'))
	{
		unlink(ROOT_PATH.'includes/FastbbFiles.php');
	}
	if(file_exists(ROOT_PATH.'includes/FastbbForums.php'))
	{
		unlink(ROOT_PATH.'includes/FastbbForums.php');
	}
	if(file_exists(ROOT_PATH.'includes/FastbbForumsPermission.php'))
	{
		unlink(ROOT_PATH.'includes/FastbbForumsPermission.php');
	}
	if(file_exists(ROOT_PATH.'includes/FastbbNotify.php'))
	{
		unlink(ROOT_PATH.'includes/FastbbNotify.php');
	}
	if(file_exists(ROOT_PATH.'includes/FastbbOnlines.php'))
	{
		unlink(ROOT_PATH.'includes/FastbbOnlines.php');
	}
	if(file_exists(ROOT_PATH.'includes/FastbbPost.php'))
	{
		unlink(ROOT_PATH.'includes/FastbbPost.php');
	}
	if(file_exists(ROOT_PATH.'includes/FastbbPostIcons.php'))
	{
		unlink(ROOT_PATH.'includes/FastbbPostIcons.php');
	}
	if(file_exists(ROOT_PATH.'includes/FastbbSmiles.php'))
	{
		unlink(ROOT_PATH.'includes/FastbbSmiles.php');
	}
	if(file_exists(ROOT_PATH.'includes/FastbbThreads.php'))
	{
		unlink(ROOT_PATH.'includes/FastbbThreads.php');
	}
	if(file_exists(ROOT_PATH.'includes/FastbbUserGroups.php'))
	{
		unlink(ROOT_PATH.'includes/FastbbUserGroups.php');
	}
	if(file_exists(ROOT_PATH.'includes/FastbbUsers.php'))
	{
		unlink(ROOT_PATH.'includes/FastbbUsers.php');
	}
	if(file_exists(ROOT_PATH.'includes/FastbbCore.php'))
	{
		unlink(ROOT_PATH.'includes/FastbbCore.php');
	}

}

?>