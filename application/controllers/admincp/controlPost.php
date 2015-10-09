<?php

class controlPost
{
	public function index()
	{
        if($match=Uri::match('\/jsonCategory'))
        {
            $keyword=String::encode(Request::get('keyword',''));

            $loadData=Categories::get(array(
            	'where'=>"where title LIKE '%$keyword%'",
                'orderby'=>'order by title asc'
                ));

            $total=count($loadData);

            $li='';

            for($i=0;$i<$total;$i++)
            {
                $li.='<li><span data-method="category" data-id="'.$loadData[$i]['catid'].'" >'.$loadData[$i]['title'].'</span></li>';
            }

            echo $li;
            die();
        }

		$post=array('alert'=>'');

		Model::load('admincp/post');

		if($match=Uri::match('\/post\/(\w+)'))
		{
			if(method_exists("controlPost", $match[1]))
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

		if(Request::has('btnSearch'))
		{
			filterProcess();
		}
		else
		{
			$post['pages']=Misc::genSmallPage('admincp/post',$curPage);

			$filterPending='';

			if(Uri::has('\/status\/pending'))
			{
				$filterPending=" WHERE p.status='0' ";
			}

			$post['theList']=Post::get(array(
				'limitShow'=>20,
				'limitPage'=>$curPage,
				'query'=>"select p.*,u.username,c.title as cattitle from ".Database::getPrefix()."post p left join users u on p.userid=u.userid join ".Database::getPrefix()."categories c on p.catid=c.catid $filterPending order by p.postid desc",
				'cache'=>'no'
				));

		}


		System::setTitle('Post list - '.ADMINCP_TITLE);


		View::make('admincp/head');

		self::makeContents('postList',$post);

		View::make('admincp/footer');

	}

	public function edit()
	{
		$username=$_COOKIE['username'].'/post';

		System::makeFileManagePath($username);

		if(!$match=Uri::match('\/edit\/(\d+)'))
		{
			Redirect::to(System::getAdminUrl().'post/');
		}


		$postid=$match[1];

		$post=array('alert'=>'');

		if(Request::has('btnSave'))
		{
			try {
				
				updateProcess($postid);

				$post['alert']='<div class="alert alert-success">Save changes success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}

		$loadData=Post::get(array(
			'cache'=>'no',
			'isHook'=>'no',
			'query'=>"select p.*,c.title as cattitle from ".Database::getPrefix()."post p,".Database::getPrefix()."categories c where p.catid=c.catid AND p.postid='$postid'"
			));

		$post['edit']=$loadData[0];

		$post['tags']=PostTags::renderToText($postid);

		System::setTitle('Edit post - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('postEdit',$post);

		View::make('admincp/footer');		
	}
	public function addnew()
	{

		$username=$_COOKIE['username'].'/post';

		System::makeFileManagePath($username);

		$post=array('alert'=>'');

		if(Request::has('btnAdd'))
		{
			try {
				
				insertProcess();

				$post['alert']='<div class="alert alert-success">Add new post success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}
		
		System::setTitle('Add new post - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('postAdd',$post);

		View::make('admincp/footer');		
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>