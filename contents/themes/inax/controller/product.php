<?php

if(!Uri::has('^product\/\d+\/.*?\.html'))
{
	Alert::make('Page not found');
}

$pageName='product';

$pageData=array();

$pageData['reviewAlert']='';

$headData=GlobalCMS::$setting;

$pageData['content_top']=Render::content_top($pageName);

$pageData['content_left']=Render::content_left($pageName);

$pageData['content_right']=Render::content_right($pageName);

$pageData['content_bottom']=Render::content_bottom($pageName);

Theme::model('product');

$pageData['reviewAlert']=sendReview();

$pageData['categories']=categories();

$pageData['lastest']=lastest();

$pageData['product']=prodProcess();

$pageData['listReviews']=listReviews();



// print_r(GlobalCMS::$setting);die();

Theme::view('head',$headData);

Theme::view($pageName,$pageData);

Theme::view('footer');

?>