<?php

class controlHome
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



		$pageData['listPost']=Post::get(array(
								'cache'=>'no',
								'isHook'=>'no',
								'limitPage'=>$curPage,
								'limitShow'=>15,
								'cacheTime'=>220,
								'where'=>"where status='publish'",
								'orderby'=>'order by date_added desc'
								));		

		$countPost=Post::get(array(
			'selectFields'=>'count(id) as totalRow',
			'cacheTime'=>30,
			'isHook'=>'no',
			'where'=>"where status='publish'",
			'orderby'=>"order by id desc"
			));

		$pageData['listPage']=Misc::genSmallPage(array(
			'url'=>'/',
			'curPage'=>$curPage,
			'limitShow'=>15,
			'limitPage'=>15,
			'showItem'=>count($pageData['listPost']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		Views::make('head');
		
		Views::make('home',$pageData);
		
		Views::make('right');
		
		Views::make('footer');

	}
}