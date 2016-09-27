<?php

class controlPage
{
	public function index()
	{
		// Cache::loadPage('',30);

		$pageData=array();

		$postid=0;

		if(!$match=Uri::match('page\/([a-zA-Z0-9_\-]+)\.html$'))
		{
			Redirect::to('404page');
		}

		$friendly_url=$match[1];

		$loadData=Pages::get(array(
			'cache'=>'no',
			'cacheTime'=>30,
			'isHook'=>'yes',
			'where'=>"where friendly_url='$friendly_url'"
			));


		$pageData=$loadData[0];

		$postid=$loadData[0]['pageid'];

		$descriptions=isset($loadData[0]['descriptions'][4])?$loadData[0]['descriptions']:System::getDescriptions();

		System::setDescriptions($descriptions);

		$keywords=isset($loadData[0]['keywords'][4])?$loadData[0]['keywords']:System::getKeywords();

		System::setKeywords($keywords);

		System::setTitle(ucfirst($loadData[0]['title']));

		Views::make('head');

		if($loadData[0]['page_type']=='fullwidth')
		{
			Views::make('pageFull',$pageData);
		}
		else
		{
			Views::make('page',$pageData);
			
			Views::make('right');			
		}
		
		Views::make('footer');
	}




}

?>