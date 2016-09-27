<?php

class controlSearch
{
	public function index()
	{
		$pageData=array();

		$curPage=0;

		if($match=Uri::match('page\/(\d+)'))
		{
			$curPage=(int)$match[1];
		}

		$curPage=((int)$curPage >= 0)?$curPage:0;

		$txtKeywords=addslashes(Request::get('txtKeywords',''));

		if($match=Uri::match('\/keyword\/(.*?)\/page'))
		{
			$txtKeywords=base64_decode($match[1]);
		}

		$pageData['listPost']=Post::get(array(
			'limitShow'=>15,
			'limitPage'=>$curPage,
			'cacheTime'=>30,
			'isHook'=>'no',
			'where'=>"where title LIKE '%$txtKeywords%' AND status='1'",
			'orderby'=>"order by postid desc"
			));

		$countPost=Post::get(array(
			'selectFields'=>'count(postid) as totalRow',
			'cacheTime'=>30,
			'where'=>"where title LIKE '%$txtKeywords%' AND status='1'",
			'orderby'=>"order by postid desc"
			));

		$pageData['keywords']=$txtKeywords;	

		$pageData['listPage']=Misc::genSmallPage(array(
			'url'=>'search/keyword/'.base64_encode($txtKeywords),
			'curPage'=>$curPage,
			'limitShow'=>15,
			'limitPage'=>15,
			'showItem'=>count($pageData['listPost']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		System::setTitle('Search result with "'.$txtKeywords.'"');

		Views::make('head');
		
		Views::make('search',$pageData);
		
		Views::make('right');
		
		Views::make('footer');

	}
}