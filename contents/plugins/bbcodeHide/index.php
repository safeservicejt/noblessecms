<?php

Plugins::install('install_bbcodeHide');

function install_bbcodeHide()
{

	Shortcode::add('hide','parse_bbcodeHide');


}

function parse_bbcodeHide($loadData='')
{

	if(!isset($_SESSION['groupid']))
	{
		$loadData=preg_replace('/\[hide\].*?\[\/hide\]/is', '<p><strong><i>You must login to see this content.</i></strong></p>', $loadData);
	}

	return $loadData;
}

?>