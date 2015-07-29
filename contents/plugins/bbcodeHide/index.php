<?php

Plugins::install('install_bbcodeHide');

function install_bbcodeHide()
{

	Shortcode::add('hide','parse_bbcodeHide');


}

function parse_bbcodeHide($loadData=array())
{
	if(!isset($_SESSION['userid']))
	{
		return '<p><i>This content hidden with guest. You must login to see this content!</i></p>';
	}

	return $loadData['value'];
	
}

?>