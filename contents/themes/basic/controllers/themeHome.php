<?php

class themeHome
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

		$themeSetting=System::getVar('themeSetting');

		$pageData['categoriesData']='';

		if(is_array($themeSetting['site_homepage_categories_content']))
		{
			$pageData['categoriesData']=genCategoriesData($themeSetting['site_homepage_categories_content']);
		}


		$pageData['listPost']=Post::get(array(
								'cache'=>'no',
								'isHook'=>'no',
								'limitPage'=>$curPage,
								'limitShow'=>15,
								'cacheTime'=>220,
								'where'=>"where status='1'",
								'orderby'=>'order by date_added desc'
								));		

		$countPost=Post::get(array(
			'selectFields'=>'count(postid) as totalRow',
			'cacheTime'=>30,
			'isHook'=>'no',
			'where'=>"where status='1'",
			'orderby'=>"order by postid desc"
			));

		$pageData['listPage']=Misc::genSmallPage(array(
			'url'=>'/',
			'curPage'=>$curPage,
			'limitShow'=>15,
			'limitPage'=>15,
			'showItem'=>count($pageData['listPost']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		Theme::view('head');
		
		Theme::view('home',$pageData);
		
		Theme::view('right');
		
		Theme::view('footer');

	}
}