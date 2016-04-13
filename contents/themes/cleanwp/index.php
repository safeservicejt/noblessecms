<?php


if($loadData=Cache::loadKey('dbcache/'.Database::getPrefix().'cleanwp',-1))
{
	$loadData=unserialize($loadData);

	System::defineGlobalVar('themeSetting',$loadData);

}

$links=Links::getRecursive();

$links=array_reverse($links);

$suggestPost=Post::get(array(
		'limitShow'=>10,
		'isHook'=>'no',
		'cache'=>'no',
		'cacheTime'=>380,
		'where'=>"where status='1'",
		'orderby'=>'order by RAND()'
		));	

$listTag=PostTags::get(array(
		'limitShow'=>20,
		'cache'=>'yes',
		'cacheTime'=>510,
		'orderby'=>'group by title order by title asc'
		));

System::defineVar('siteTitle',System::getTitle());

System::defineVar('linkList',$links,'head');

System::defineVar('tagList',$listTag,'right');

System::defineVar('suggestPost',$suggestPost,'right');

Theme::settingUri(array(
	''=>'home@index',
	'page'=>'home@index',
	'search'=>'search@index',
	'post'=>'post@index',
	'tag'=>'tag@index',
	'404page'=>'404page@index',
	'category'=>'category@index'
	));

Theme::render();
