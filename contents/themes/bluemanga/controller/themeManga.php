<?php

class themeManga
{
	public function index()
	{
		// Cache::loadPage(30);

		$leftData=array();

		$rightData=array();

		if(!$match=Uri::match('manga\/(.*?)\.html$'))
		{
			Redirect::to('404page');
		}

		$friendly_url=$match[1];

		$curPage=0;

		Model::loadWithPath('manga',System::getThemePath().'model/');

		if(!$matchChapter=Uri::match('manga\/(.*?)-chapter-(\d+)\.html'))
		{
			$rightData['hotManga']=hotManga();

			// print_r($rightData['hotManga']);die();

			$loadData=Manga::getDetails($friendly_url);

			$leftData=$loadData[0];

			System::setTitle(ucwords($leftData['title']).' - '.System::getTitle());

			$keywords=$leftData['keywords'];

			if(isset($keywords[2]))
			{
				System::setKeywords($keywords);
			}

			// print_r($loadData);die();

			Manga::upView($loadData[0]['mangaid']);

			$themePath=System::getThemePath().'view/';

			View::makeWithPath('head',array(),$themePath);

			View::makeWithPath('mangaView',$leftData,$themePath);

			View::makeWithPath('right_home',$rightData,$themePath);

			View::makeWithPath('footer',array(),$themePath);


		}
		else
		{
			$friendly_url=$matchChapter[1];

			$chapter_number=$matchChapter[2];

			$loadData=MangaChapters::get(array(
				'query'=>"select m.title as manga_title,m.friendly_url as manga_friendly_url,mc.* from manga_list m left join chapter_list mc on m.friendly_url='$friendly_url' AND m.mangaid=mc.mangaid AND mc.number='$chapter_number'"
				));

			$leftData=$loadData[0];

			$leftData['listChapters']=MangaChapters::get(array(
				'cacheTime'=>1,
				'query'=>"select m.title as manga_title,m.friendly_url as manga_friendly_url,mc.number from manga_list m left join chapter_list mc on m.friendly_url='$friendly_url' AND m.mangaid=mc.mangaid order by mc.number asc"
				));

			// print_r($leftData);die();

			System::setTitle($leftData['manga_title'].' - Chapter '.$chapter_number);


			MangaChapters::upView($loadData[0]['chapterid']);

			$themePath=System::getThemePath().'view/';

			View::makeWithPath('head',array(),$themePath);

			View::makeWithPath('chapterView',$leftData,$themePath);

			// View::makeWithPath('right_home',$rightData,$themePath);

			View::makeWithPath('footer',array(),$themePath);


		}


		Cache::savePage();
	}



}

?>