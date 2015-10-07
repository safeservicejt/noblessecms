<?php

Plugins::install('install_ninjascripts');

Plugins::uninstall('uninstall_ninjascripts');

function install_ninjascripts()
{
	Dir::remove(CACHES_PATH.'dbcache/system/ninjascripts');
	
	Dir::remove(CACHES_PATH.'ninjascripts');

	// // Add admincp left menu
	Plugins::add('admincp_menu','ninjascripts_admincp_menu');

	Plugins::add('admincp_header','ninjascripts_admincp_header');

	Plugins::add('admincp_footer','ninjascripts_admincp_footer');

	Plugins::add('site_header','ninjascripts_site_header');

	Plugins::add('site_footer','ninjascripts_site_footer');


}

function uninstall_ninjascripts()
{


	Dir::remove(CACHES_PATH.'dbcache/system/ninjascripts');
	
	Dir::remove(CACHES_PATH.'ninjascripts');

}

function ninjascripts_admincp_header()
{
	// return '<script>alert("ok");</script>';
		
	if(!$loadData=Cache::loadKey('ninjascripts/admincpHeader',-1))
	{
		return '';
	}

	$loadData=stripslashes($loadData);

	return $loadData;
}
function ninjascripts_admincp_footer()
{
	if(!$loadData=Cache::loadKey('ninjascripts/admincpFooter',-1))
	{
		return '';
	}

	$loadData=stripslashes($loadData);

	return $loadData;
}

function ninjascripts_site_header()
{
	if(!$loadData=Cache::loadKey('ninjascripts/siteHeader',-1))
	{
		return '';
	}

	$loadData=stripslashes($loadData);

	return $loadData;
}
function ninjascripts_site_footer()
{
	if(!$loadData=Cache::loadKey('ninjascripts/siteFooter',-1))
	{
		return '';
	}

	$loadData=stripslashes($loadData);

	return $loadData;
}

function ninjascripts_admincp_menu()
{
	$menu=array(
			
			array(
				'title'=>'Ninja Scripts',
				'child'=>array(
						0=>array(
							'title'=>'Admincp',
							'controller'=>'modifyadmincp'
							),
						1=>array(
							'title'=>'Front Page',
							'controller'=>'modifyfrontend'
							)
					)

				)
		);

	return $menu;
}


?>