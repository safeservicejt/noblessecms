<?php

class controlComments
{
	public function index()
	{
       
		$post=array('alert'=>'');

		Model::load('admincp/comments');

		if($match=Uri::match('\/comments\/(\w+)'))
		{
			if(method_exists("controlComments", $match[1]))
			{	
				$method=$match[1];

				$this->$method();

				die();
			}
			
		}

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		if(Request::has('btnAction'))
		{
			actionProcess();
		}
		
		$post['theList']=Comments::get(array(
			'limitShow'=>20,
			'limitPage'=>$curPage,
			'query'=>"select c.*,p.title from ".Database::getPrefix()."post p,".Database::getPrefix()."comments c where c.postid=p.postid order by c.commentid desc",
			'cacheTime'=>1
			));

		$countPost=Comments::get(array(
			'query'=>"select count(c.commentid)as totalRow from ".Database::getPrefix()."post p,".Database::getPrefix()."comments c where c.postid=p.postid order by c.commentid desc",
			'cache'=>'no'
			));

		$post['pages']=Misc::genSmallPage(array(
			'url'=>'admincp/comments',
			'curPage'=>$curPage,
			'limitShow'=>20,
			'limitPage'=>5,
			'showItem'=>count($post['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$post['totalPost']=$countPost[0]['totalRow'];

		$post['totalPage']=intval((int)$countPost[0]['totalRow']/20);

		System::setTitle('Comments list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('commentsList',$post);

		View::make('admincp/footer');

	}

	public function view()
	{
		if(!$match=Uri::match('\/view\/(\d+)'))
		{
			Redirect::to(System::getAdminUrl().'comments/');
		}


		$commentid=$match[1];

		$loadData=Comments::get(array(
			'query'=>"select p.title,c.* from ".Database::getPrefix()."post p,".Database::getPrefix()."comments c where p.postid=c.postid AND c.commentid='$commentid'"
			));

		$post['edit']=$loadData[0];

		System::setTitle('View comment - '.ADMINCP_TITLE);


		View::make('admincp/head');

		self::makeContents('commentView',$post);

		View::make('admincp/footer');		
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>