<?php

class controlPost
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
			'query'=>"select p.*,c.title as cattitle,c.friendly_url as cat_friendly_url from post p left join categories c on p.catid=c.id where p.friendly_url='$friendly_url' AND p.status='publish'"
			));

		if(!isset($loadData[0]['id']))
		{
			Redirect::to('404page');
		}

		if(isset($loadData[0]['imageUrl']))
		{
			System::defineVar('postImage',$loadData[0]['imageUrl'],'head');
		}

		$postid=$loadData[0]['id'];

		$listTag='';

		$pageData=$loadData[0];

		if(isset($loadData[0]['tag_data']) && is_array($loadData[0]['tag_data']))
		{
			$listTag='';

			$total=count($loadData[0]['tag_data']);

			for ($i=0; $i < $total; $i++) { 
				$listTag.="'".$loadData[0]['tag_data'][$i]['title']."',";
			}

			$listTag=substr($listTag, 0,strlen($listTag)-1);
		}

		$pageData['relatePost']=array();

		if(isset($listTag[1]))
		{
			$pageData['relatePost']=Post::get(array(
				'cache'=>'yes',
				'cacheTime'=>530,
				'limitShow'=>12,			
				'isHook'=>'no',
				'query'=>"select p.* from post p left join post_tags pt ON p.postid=pt.postid WHERE pt.title IN ($listTag) AND p.postid<>'$postid' group by p.postid order by p.postid desc"
				));			
		}

		Post::up('views',1," id='$postid'");

		System::setTitle($loadData[0]['page_title']);

		System::setDescriptions($loadData[0]['descriptions']);

		$keywords=isset($loadData[0]['keywords'][4])?$loadData[0]['keywords']:System::getKeywords();

		System::setKeywords($keywords);

		Views::make('head');
		
		Views::make('post',$pageData);
		
		Views::make('right');
		
		Views::make('footer');

	}
}