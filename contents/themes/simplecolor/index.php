<?php

$pageData=array();

$pageName=System::getCurrentPage();

$pageName=($pageName=='')?'home':$pageName;

if($matches=Uri::match('^(\w+)\/?'))
{
	$pageName=$matches[1];
}

if($matches=Uri::match('^page\/(\d+)'))
{
	$pageName='home';
}

// Theme::view('head');
$codeHead=Plugins::load('site_header');

$codeHead=is_array($codeHead)?'':$codeHead;

$codeFooter=Plugins::load('site_footer');

$codeFooter=is_array($codeFooter)?'':$codeFooter;

// print_r($codeHead);die();

System::defineGlobalVar('site_header',$codeHead);

System::defineGlobalVar('site_footer',$codeFooter);


$links=Links::get(array(
	'cacheTime'=>3,
	'orderby'=>'order by sort_order asc'
	));

System::defineVar('linkList',$links,'head');

Controller::loadWithPath('theme'.ucfirst($pageName),'index',System::getThemePath().'controller/');

// Theme::view('footer');

?>