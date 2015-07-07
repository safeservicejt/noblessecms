<?php

class themeHome
{
	public function index()
	{
		// Cache::loadPage(30);

		$leftData=array();

		$rightData=array();

		$curPage=0;

		Model::loadWithPath('home',System::getThemePath().'model/');

		if($match=Uri::match('page\/(\d+)'))
		{
			$curPage=(int)$match[1];
		}

		$curPage=((int)$curPage >= 0)?$curPage:0;

		$leftData['lastUpdate']=MangaChapters::get(array(
			'limitShow'=>5,
			'query'=>"select mc.number,m.* from manga_list m, chapter_list mc where mc.mangaid=m.mangaid group by mc.mangaid order by mc.chapterid desc"
			));

		$leftData['hotManga']=Manga::get(array(
			'limitShow'=>40,
			'where'=>"where is_featured='1'",
			'orderby'=>'order by date_added desc'
			));

		$rightData['hotManga']=hotManga();

		// print_r($rightData['hotManga']);die();



		$themePath=System::getThemePath().'view/';

		View::makeWithPath('head',array(),$themePath);

		View::makeWithPath('left_home',$leftData,$themePath);

		View::makeWithPath('right_home',$rightData,$themePath);

		View::makeWithPath('footer',array(),$themePath);


		// Cache::savePage();
	}



}

?>