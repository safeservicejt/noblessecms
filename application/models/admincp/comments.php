<?php

function searchProcess($txtKeyword)
{

	$curPage=Uri::getNext('news');

	if($curPage=='page')
	{
		$curPage=Uri::getNext('page');
	}
	else
	{
		$curPage=0;
	}

	$resultData=array();

	$resultData['pages']=genPage('news',$curPage);	

	$txtKeyword=trim($txtKeyword);

	Request::make('txtKeyword',$txtKeyword);

	$valid=Validator::make(array(
		'txtKeyword'=>'min:1|slashes'
		));

	if(!$valid)
	{
		$resultData['listData']='';

		$resultData['pages']='';

		return $resultData;
	}

	if(preg_match('/^(\w+)\:(.*?)$/i', $txtKeyword,$matches))
	{
		$method=strtolower($matches[1]);

		$keyword=strtolower(trim($matches[2]));

		$method=($method=='commentid')?'id':$method;
		$method=($method=='postid')?'postid':$method;

		switch ($method) {
			case 'id':
			$resultData['listData']=Comments::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where commentid='$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'postid':
			$resultData['listData']=Comments::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where postid='$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'before':
			$resultData['listData']=Comments::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_added < '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'after':
			$resultData['listData']=Comments::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_added > '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'on':
			$resultData['listData']=Comments::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_added='$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;


		}
		// print_r($matches);die();
	}
	else
	{
		$txtKeyword=String::encode($txtKeyword);

		preg_match('/"(.*?)"/i', $txtKeyword,$matches);

		$txtKeyword=$matches[1];
		
		$resultData['listData']=Comments::get(array(
			'limitShow'=>20,			
			'limitPage'=>$curPage,
			'where'=>"where content LIKE '%$txtKeyword%'",
			'orderby'=>'order by date_added desc',
			'isHook'=>'no'
			));	
	}

	// print_r($txtKeyword);die();

	return $resultData;
}


?>