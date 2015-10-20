<?php

class themePost
{
	public function index()
	{
		Cache::loadPage('',30);

		$inputData=array();

		$postid=0;

		Model::loadWithPath('post',System::getThemePath().'model/');

		if(!$match=Uri::match('post\/(.*?)\.html$'))
		{
			Redirect::to('404page');
		}

		$friendly_url=addslashes($match[1]);


		$loadData=Post::get(array(
			'cacheTime'=>1,
			'where'=>"where friendly_url='$friendly_url'"
			));

		if(!isset($loadData[0]['postid']))
		{
			Redirect::to('404page');
		}

		$inputData=$loadData[0];

		$postid=$inputData['postid'];

		if(Request::has('btnComment'))
		{
			if(Captcha::verify())
			{
				try {
					sendComment($postid);
					$inputData['commentAlert']='<div class="alert alert-success">Send comment success.</div>';
				} catch (Exception $e) {
					$inputData['commentAlert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
				}				
			}
			else
			{
				$inputData['commentAlert']='<div class="alert alert-warning">Wrong captcha characters. Try again!</div>';
			}
		}

		$listTag=PostTags::renderToLink($postid);

		$inputData['captchaHTML']=Captcha::makeForm();

		$inputData['listTag']=$listTag;

		$inputData['listComments']=Comments::get(array(
			'where'=>"where postid='$postid' AND status='1'",
			'orderby'=>"order by postid desc"
			));

		Post::upView($postid);

		System::setTitle(ucfirst($loadData[0]['title']));

		$keywords=isset($loadData[0]['keywords'][4])?$loadData[0]['keywords']:System::getKeywords();

		System::setKeywords($keywords);

		self::makeContent('post',$inputData);

		Cache::savePage();		
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