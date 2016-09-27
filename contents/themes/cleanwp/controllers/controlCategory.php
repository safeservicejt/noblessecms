<?php

class controlCategory
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

		if(!$match=Uri::match('category\/([a-zA-Z0-9_\-\s\_]+)'))
		{
			Redirect::to('404page');
		}

		$friendly_url=addslashes($match[1]);

		$catData=Categories::get(array(
			'cache'=>'yes',
			'cacheTime'=>30,
			'where'=>"where friendly_url='$friendly_url'"
			));

		if(!isset($catData[0]['catid']))
		{
			Redirect::to('404page');
		}

		$catData[0]['title']=ucwords($catData[0]['title']);

		$pageData['cattitle']=$catData[0]['title'];

		$pageData['listPost']=Post::get(array(
			'limitShow'=>15,
			'isHook'=>'no',
			'limitPage'=>$curPage,
			'cacheTime'=>30,
			'where'=>"where catid='".$catData[0]['catid']."' AND status='1'",
			'orderby'=>"order by postid desc"
			));

		$countPost=Post::get(array(
			'selectFields'=>'count(postid) as totalRow',
			'cacheTime'=>15,
			'isHook'=>'no',
			'where'=>"where catid='".$catData[0]['catid']."' AND status='1'",
			'orderby'=>"order by postid desc"
			));

		$pageData['listPage']=Misc::genSmallPage(array(
			'url'=>'category/'.$friendly_url,
			'curPage'=>$curPage,
			'limitShow'=>15,
			'limitPage'=>15,
			'showItem'=>count($pageData['listPost']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		System::setTitle($catData[0]['title']);

		$descriptions=isset($catData[0]['descriptions'][4])?$catData[0]['descriptions']:System::getDescriptions();

		System::setDescriptions($descriptions);

		$keywords=isset($catData[0]['keywords'][4])?$catData[0]['keywords']:System::getKeywords();

		System::setKeywords($keywords);

		Views::make('head');
		
		Views::make('category',$pageData);
		
		Views::make('right');
		
		Views::make('footer');

	}
}