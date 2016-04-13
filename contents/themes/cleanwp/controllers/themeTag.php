<?php

class themeTag
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

		if(!$match=Uri::match('tag\/([a-zA-Z0-9_\-\s\_]+)'))
		{
			Redirect::to('404page');
		}

		$friendly_url=trim(addslashes($match[1]));


		$pageData['listPost']=Post::get(array(
			'limitShow'=>15,
			'limitPage'=>$curPage,
			'cacheTime'=>30,
			'isHook'=>'no',
			'where'=>"where postid IN (select postid from post_tags where title='$friendly_url') AND status='1'",
			'orderby'=>"order by postid desc"
			));

		$countPost=Post::get(array(
			'selectFields'=>'count(postid) as totalRow',
			'cacheTime'=>30,
			'where'=>"where postid IN (select postid from post_tags where title='$friendly_url') AND status='1'",
			'orderby'=>"order by postid desc"
			));

		$pageData['keywords']=$friendly_url;	

		$pageData['listPage']=Misc::genSmallPage(array(
			'url'=>'tag/'.$friendly_url,
			'curPage'=>$curPage,
			'limitShow'=>15,
			'limitPage'=>15,
			'showItem'=>count($pageData['listPost']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		System::setTitle('Result with tag "'.$friendly_url.'"');

		Theme::view('head');
		
		Theme::view('tag',$pageData);
		
		Theme::view('right');
		
		Theme::view('footer');

	}
}