<?php

if(Cart::isEmpty())
{
	Redirect::to(ROOT_URL);
}

$pageName='cart';

$pageData=array();

$pageData['alert']='';

$pageData['alertLogin']='';

$pageData['content_top']=Render::content_top($pageName);

$pageData['content_left']=Render::content_left($pageName);

$pageData['content_right']=Render::content_right($pageName);

$pageData['content_bottom']=Render::content_bottom($pageName);

$pageName='checkout';

Theme::model('checkout');

if(Request::has('btnConfirm'))
{
	$resultData=Checkout::processCheckout();

	if($resultData['status']=='error')
	{
		$pageData['alert']='<div class="alert alert-warning">Error. '.$resultData['error'].'!</div>';		
	}
	else
	{
		$pageName='order.completed';
	}

	if($resultData['status']=='process_page')
	{
		$pageName='order.continue';

		$pageData['process']['content']=$resultData['content'];
	}


}
else
{
	$pageData=before_checkout($pageData);
}

// echo $pageName;



$headData=GlobalCMS::$setting;

Theme::view('head',$headData);

Theme::view($pageName,$pageData);

Theme::view('footer');

?>