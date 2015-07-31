<?php

$pageData=array();

$pageName='home';


if(Uri::isNull())
{
	$pageName='home';
}

if($matches=Uri::match('^(\w+)\/?'))
{
	$pageName=$matches[1];
}

if($matches=Uri::match('^page\/(\d+)'))
{
	$pageName='home';
}

// Theme::view('head');

$links=Links::get(array(
	'cacheTime'=>3,
	'orderby'=>'order by sort_order asc'
	));

System::defineVar('linkList',$links,'head');

$codeHead=Plugins::load('site_header');

$codeHead=is_array($codeHead)?'':$codeHead;

// print_r($codeHead);die();

System::defineVar('header',$codeHead,'head');

Controller::loadWithPath('theme'.ucfirst($pageName),'index',System::getThemePath().'controller/');

// Theme::view('footer');

?>