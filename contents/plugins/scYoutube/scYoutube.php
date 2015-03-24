<?php

Plugins::install('install_scyoutube');



function install_scyoutube()
{
	Shortcode::add('youtube','parse_scyoutube');

}


function parse_scyoutube($loadData=array())
{
	return '<span>Test shortcode: '.$loadData['value'].'</span>';
}

?>