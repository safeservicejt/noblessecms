<?php

class themeSearch
{
	public function index()
	{
		// Cache::loadPage(30);
		
		$leftData=array();
		$rightData=array();

		$postid=0;

		$curPage=0;

		Model::loadWithPath('search',System::getThemePath().'model/');

		$keyword=addslashes(Request::get('keyword',''));

		if($match=Uri::match('search\/(.*?)\/page\/'))
		{
			$keyword=base64_decode($match[1]);
		}

		if(!isset($keyword[0]))
		{
			Redirect::to('404page');
		}


		if($match=Uri::match('page\/(\d+)'))
		{
			$curPage=(int)$match[1];
		}

		$leftData['keyword']=$keyword;

		$leftData['listManga']=listManga($keyword);

		$leftData['listPage']=Misc::genPage('search/'.base64_encode($keyword),$curPage);

		$rightData['hotManga']=hotManga();

		// print_r($leftData['listManga']);die();

		System::setTitle('Search result by keyword:  - '.System::getTitle());

		$themePath=System::getThemePath().'view/';

		View::makeWithPath('head',array(),$themePath);

		View::makeWithPath('search',$leftData,$themePath);

		View::makeWithPath('right_home',$rightData,$themePath);

		View::makeWithPath('footer',array(),$themePath);


		Cache::savePage();		
	}



}

?>