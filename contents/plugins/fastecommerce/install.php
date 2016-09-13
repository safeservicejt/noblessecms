<?php

Dir::remove(ROOT_PATH.'contents/fastecommerce');

Dir::remove(CACHES_PATH.'dbcache/system/fastecommerce');

Dir::remove(CACHES_PATH.'fastecommerce');

$pluginPath=dirname(__FILE__).'/';

$installPath=$pluginPath.'install/';

$dbFile=$installPath.'db.sql';

if(file_exists($dbFile))
{
	Database::import($dbFile);
}

File::copyMatch(ROOT_PATH.'contents/plugins/fastecommerce/install/*.php',ROOT_PATH.'includes/');

// System::saveSetting(array(
// 	'default_adminpage_method'=>'url',
// 	'default_adminpage_url'=>'plugins/privatecontroller/fastecommerce/stats'
// 	));

Plugins::add('before_system_start',array(
	'type'=>'fly',
	'class'=>'FastEcommerce',
	'funcname'=>'before_system_start'
	));

Plugins::add('before_frontend_start',array(
	'type'=>'fly',
	'class'=>'FastEcommerce',
	'funcname'=>'before_frontend_start'
	));


Plugins::add('before_admincp_start',array(
	'type'=>'fly',
	'class'=>'FastEcommerce',
	'funcname'=>'before_admincp_start'
	));

Plugins::add('after_insert_user',array(
	'type'=>'fly',
	'class'=>'FastEcommerce',
	'funcname'=>'after_insert_user'
	));

Plugins::add('after_remove_user',array(
	'type'=>'fly',
	'class'=>'FastEcommerce',
	'funcname'=>'after_remove_user'
	));


Plugins::add('before_register_user',array(
	'type'=>'fly',
	'class'=>'FastEcommerce',
	'funcname'=>'before_register_user'
	));

Plugins::add('before_register_user',array(
	'type'=>'fly',
	'class'=>'FastEcommerce',
	'funcname'=>'before_register_user'
	));


Usergroups::changePermissionAll(array(
	'can_control_plugin'=>'yes',
	'can_manage_link'=>'no',
	'is_fastecommerce_owner'=>'no',
	'can_addnew_product'=>'no',
	'can_update_product'=>'no',
	'can_remove_product'=>'no',
	));

Usergroups::changePermissionAll(array(
	'can_change_profile'=>'yes',
	'can_manage_post'=>'no',
	'can_manage_link'=>'no',
	'can_addnew_category'=>'no',
	'can_addnew_redirect'=>'no',
	'can_manage_contactus'=>'no',
	'can_addnew_page'=>'no',
	'can_addnew_user'=>'no',
	'can_addnew_usergroup'=>'no',
	'can_edit_usergroup'=>'no',
	'can_setting_system'=>'no',
	'can_manage_plugins'=>'no',
	'can_manage_themes'=>'no',
	'can_import_theme'=>'no',
	'can_activate_plugin'=>'no',
	'can_uninstall_plugin'=>'no',
	'can_deactivate_plugin'=>'no',
	'can_install_plugin'=>'no',
	'can_import_plugin'=>'no',
	'can_manage_category'=>'no',
	'can_manage_user'=>'no',
	'can_manage_usergroup'=>'no',
	'show_category_manager'=>'no',
	'show_post_manager'=>'no',
	'show_comment_manager'=>'no',
	'show_page_manager'=>'no',
	'show_link_manager'=>'no',
	'show_user_manager'=>'no',
	'show_usergroup_manager'=>'no',
	'show_contact_manager'=>'no',
	'show_theme_manager'=>'no',
	'show_plugin_manager'=>'no',
	'show_setting_manager'=>'no',
	));		

$groupid=(int)Users::getCookieGroupId();

Usergroups::changePermission($groupid,array(
	'is_fastecommerce_owner'=>'yes',
	'can_addnew_product'=>'yes',
	'can_update_product'=>'yes',
	'can_remove_product'=>'yes',		
	'can_manage_post'=>'yes',
	'can_addnew_post'=>'yes',
	'can_manage_link'=>'yes',
	'can_addnew_category'=>'yes',
	'can_addnew_redirect'=>'yes',
	'can_manage_contactus'=>'yes',
	'can_addnew_page'=>'yes',
	'can_addnew_user'=>'yes',
	'can_addnew_usergroup'=>'yes',
	'can_edit_usergroup'=>'yes',
	'can_setting_system'=>'yes',
	'can_manage_plugins'=>'yes',
	'can_manage_themes'=>'yes',
	'can_import_theme'=>'yes',
	'can_activate_plugin'=>'yes',
	'can_uninstall_plugin'=>'yes',
	'can_deactivate_plugin'=>'yes',
	'can_install_plugin'=>'yes',
	'can_import_plugin'=>'yes',
	'can_manage_category'=>'yes',
	'can_manage_user'=>'yes',
	'can_manage_usergroup'=>'yes',
	'show_category_manager'=>'yes',
	'show_post_manager'=>'yes',
	'show_comment_manager'=>'yes',
	'show_page_manager'=>'yes',
	'show_link_manager'=>'yes',
	'show_user_manager'=>'yes',
	'show_usergroup_manager'=>'yes',
	'show_contact_manager'=>'yes',
	'show_theme_manager'=>'yes',
	'show_plugin_manager'=>'yes',
	'show_setting_manager'=>'yes',	
	'can_control_plugin'=>'yes',	
	));		

    Database::addField('categories','orders',array(
        'type'=>'INT',
        'length'=>9,
        'default'=>0
    ));	
    Database::addField('categories','products',array(
        'type'=>'INT',
        'length'=>9,
        'default'=>0
    ));	