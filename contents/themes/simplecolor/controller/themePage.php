<?php

class themePage
{
	public function index()
	{
		$inputData=array();

		$postid=0;

		Model::loadWithPath('page',System::getThemePath().'model/');

		if(!$match=Uri::match('page\/(.*?)\.html$'))
		{
			Redirect::to('404page');
		}

		$friendly_url=addslashes($match[1]);

		$loadData=Pages::get(array(
			'where'=>"where friendly_url='$friendly_url'"
			));

		if(!isset($loadData[0]['pageid']))
		{
			Redirect::to('404page');
		}

		$inputData=$loadData[0];


		$postid=$loadData[0]['pageid'];

		System::setTitle(ucfirst($loadData[0]['title']));

		$keywords=isset($loadData[0]['keywords'][4])?$loadData[0]['keywords']:System::getKeywords();

		System::setKeywords($keywords);

		if($loadData[0]['page_type']=='fullwidth')
		{
			self::makeContent('pageFullWidth',$inputData);		
		}
		else
		{
			self::makeContent('page',$inputData);			
		}


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