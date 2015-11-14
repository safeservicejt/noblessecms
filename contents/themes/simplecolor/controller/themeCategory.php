<?php

class themeCategory
{
	public function index()
	{
		// Cache::loadPage(30);
		
		$inputData=array();

		$postid=0;

		$curPage=0;
		// Model::loadWithPath('home',System::getThemePath().'model/');

		if(!$match=Uri::match('category\/([a-zA-Z0-9_\-\=]+)$'))
		{
			Redirect::to('404page');
		}

		$friendly_url=addslashes($match[1]);

		if($match=Uri::match('page\/(\d+)'))
		{
			$curPage=(int)$match[1];
		}

		$loadData=Post::get(array(
			'limitShow'=>10,
			'limitPage'=>$curPage,
			'cache'=>'yes',
			'cacheTime'=>230,
			'query'=>"select p.*,c.title as cattitle from ".Database::getPrefix()."post p left join ".Database::getPrefix()."categories c ON c.friendly_url='$friendly_url' where p.catid=c.catid group by p.postid order by p.postid desc"
			));

		if(!isset($loadData[0]['postid']))
		{
			Redirect::to('404page');
		}


		$inputData['newPost']=$loadData;

		$inputData['listPage']=Misc::genPage('',$curPage);

		System::setTitle(ucfirst($loadData[0]['cattitle']));

		self::makeContent('category',$inputData);

		// Cache::savePage();		
	}

	public function makeContent($viewName,$inputData=array())
	{
		$themePath=System::getThemePath().'view/';

		$inputData['themePath']=$themePath;

		View::makeWithPath('head',array(),$themePath);

		View::makeWithPath($viewName,$inputData,$themePath);

		View::makeWithPath('footer',array(),$themePath);

	}


}

?>