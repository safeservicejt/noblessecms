<?php

class themeAuthor
{
	public function index()
	{
		// Cache::loadPage(30);
		
		$leftData=array();
		$rightData=array();

		$postid=0;

		$curPage=0;

		Model::loadWithPath('author',System::getThemePath().'model/');

		if(!$match=Uri::match('author\/([a-zA-Z0-9_-]+)-(\d+)$'))
		{
			Redirect::to('404page');
		}

		// die('dfdf');

		$friendly_url=$match[1];

		$authorid=$match[2];

		if($match=Uri::match('page\/(\d+)'))
		{
			$curPage=(int)$match[1];
		}

		$loadData=MangaAuthors::get(array(
			'where'=>"where friendly_url='$friendly_url' AND authorid='$authorid'"
			));

		if(!isset($loadData[0]['authorid']))
		{
			Redirect::to('404page');
		}

		$leftData=$loadData[0];

		$leftData['listManga']=listManga($friendly_url);

		$leftData['listPage']=Misc::genPage('author/'.$friendly_url.'-'.$authorid,$curPage);

		$rightData['hotManga']=hotManga();

		// print_r($leftData['listManga']);die();

		System::setTitle(ucfirst($loadData[0]['title']).' - '.System::getTitle());

		$themePath=System::getThemePath().'view/';

		View::makeWithPath('head',array(),$themePath);

		View::makeWithPath('authorView',$leftData,$themePath);

		View::makeWithPath('right_home',$rightData,$themePath);

		View::makeWithPath('footer',array(),$themePath);


		Cache::savePage();		
	}



}

?>