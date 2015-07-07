<?php

class themeTag
{
	public function index()
	{
		// Cache::loadPage(30);
		
		$leftData=array();
		$rightData=array();

		$postid=0;

		$curPage=0;

		Model::loadWithPath('tag',System::getThemePath().'model/');


		if(!$match=Uri::match('tag\/(.*?)\/page\/'))
		{
			if(!$match=Uri::match('tag\/(.*?)$'))
			{
				Redirect::to('404page');
			}			
		}

		$friendly_url=addslashes($match[1]);

		if($match=Uri::match('page\/(\d+)'))
		{
			$curPage=(int)$match[1];
		}

		$loadData=MangaTags::get(array(
			'where'=>"where title='$friendly_url'"
			));

		if(!isset($loadData[0]['title']))
		{
			Redirect::to('404page');
		}

		$leftData=$loadData[0];

		$leftData['listManga']=listManga($friendly_url);

		$leftData['listPage']=Misc::genPage('tag/'.$friendly_url,$curPage);

		$rightData['hotManga']=hotManga();

		// print_r($leftData['listManga']);die();

		System::setTitle(ucfirst($loadData[0]['title']).' - '.System::getTitle());

		$themePath=System::getThemePath().'view/';

		View::makeWithPath('head',array(),$themePath);

		View::makeWithPath('tag',$leftData,$themePath);

		View::makeWithPath('right_home',$rightData,$themePath);

		View::makeWithPath('footer',array(),$themePath);


		Cache::savePage();		
	}



}

?>