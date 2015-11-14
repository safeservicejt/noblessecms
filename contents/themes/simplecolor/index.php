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

if($loadData=Cache::loadKey('dbcache/'.Database::getPrefix().'simplecolor',-1))
{
	$loadData=unserialize($loadData);

	System::defineGlobalVar('themeSetting',$loadData);

	System::defineGlobalVar('site_name',$loadData['site_name']);



}


$links=Links::get(array(
	'cache'=>'yes',
	'cacheTime'=>130,
	'orderby'=>'order by sort_order asc'
	));

// if(!is_array($links))
// {
// 	$links=unserialize($links);
// }

System::defineVar('linkList',$links,'head');

Controller::loadWithPath('theme'.ucfirst($pageName),'index',System::getThemePath().'controller/');

// Theme::view('footer');

?>