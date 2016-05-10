<?php

class themePost
{
	public function index()
	{
		$pageData=array();

		if(!$match=Uri::match('post\/([a-zA-Z0-9_\-]+)\.html$'))
		{
			Redirect::to('404page');
		}

		$friendly_url=$match[1];

		$loadData=Post::get(array(
			'isHook'=>'yes',
			'cache'=>'no',
			'cacheTime'=>250,
			'query'=>"select p.*,c.title as cattitle,c.friendly_url as cat_friendly_url from ".Database::getPrefix()."post p left join ".Database::getPrefix()."categories c on p.catid=c.catid where p.friendly_url='$friendly_url' AND p.status='1'"
			));

		if(!isset($loadData[0]['postid']))
		{
			Redirect::to('404page');
		}

		if(isset($loadData[0]['imageUrl']))
		{
			System::defineVar('postImage',$loadData[0]['imageUrl'],'head');
		}

		$postid=$loadData[0]['postid'];

		
		$listTag=PostTags::renderToLink($postid);

		$pageData['listTag']=$listTag;

		$addRelate='';


		if(isset($listTag[5]))
		{
			preg_match_all('/>([a-zA-Z0-9_\-\=\_\+]+)<\/a>/i', $listTag, $matches);
		}		

		$pageData['relatePost']=array();

		if(isset($matches[1]))
		{
			$tags="'".implode("','", $matches[1])."'";

			$pageData['relatePost']=Post::get(array(
				'cache'=>'yes',
				'cacheTime'=>530,
				'limitShow'=>12,			
				'isHook'=>'no',
				'query'=>"select p.* from ".Database::getPrefix()."post p left join ".Database::getPrefix()."post_tags pt ON p.postid=pt.postid WHERE pt.title IN ($tags) AND p.postid<>'$postid' group by p.postid order by p.postid desc"
				));			
		}

		$pageData['postData']=$loadData[0];

		Post::upView($postid);

		System::setTitle($loadData[0]['page_title']);

		System::setDescriptions($loadData[0]['descriptions']);

		$keywords=isset($loadData[0]['keywords'][4])?$loadData[0]['keywords']:System::getKeywords();

		System::setKeywords($keywords);

		Theme::view('head');
		
		Theme::view('post',$pageData);
		
		Theme::view('right');
		
		Theme::view('footer');

	}
}