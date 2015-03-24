<?php

function getApi()
{
	$curPage=0;

	$limitShow=15;

	if($match=Uri::match('\/limitPage\/(\d+)'))
	{
		$curPage=$match[1];
	}

	if($match=Uri::match('\/limitShow\/(\d+)'))
	{
		$limitShow=$match[1];
	}

	$queryData=array();

	$queryData['limitShow']=$limitShow;

	$queryData['limitPage']=$curPage;

	$queryData['where']="where post_type='plugin'";

	$loadData=array();

	$loadData['data']=Post::get($queryData);
	
	if(!isset($loadData['data'][0]['postid']))
	{
		$loadData['error']='yes';

		return json_encode($loadData);
	}

	return json_encode($loadData);
}

?>