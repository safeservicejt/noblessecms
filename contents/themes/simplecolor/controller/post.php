<?php

if(!Uri::has('^post\/\d+\-.*?\.html'))
{
	// Alert::make('Page not found');
}

$pageName='post';

$pageData=array();

$pageData['content_top']=Render::content_top($pageName);

$pageData['content_left']=Render::content_left($pageName);

$pageData['content_right']=Render::content_right($pageName);

$pageData['content_bottom']=Render::content_bottom($pageName);

Theme::model('post');

$headData=GlobalCMS::$setting;

$pageData['commentAlert']=sendComment();

// $pageData['categories']=categories();

$pageData=postProcess($pageData);

$pageData['listComments']=listComments();

Theme::view('head',$headData);

Theme::view($pageName,$pageData);

Theme::view('footer');

?>