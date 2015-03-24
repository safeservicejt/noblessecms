<?php

class controlComments
{
	public function __construct()
	{
		if(UserGroups::enable('can_manage_comment')==false){
			
			header("Location: ".USERCP_URL);

		}
	}

	public function index()
	{
		if(Uri::has('view'))
		{
			$this->view();
			die();
		}
		if(Uri::has('approved'))
		{
			$this->approved();
			die();
		}


		$post=array('alert'=>'');

		Model::load('usercp/misc');
		Model::load('usercp/comments');

		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				Comments::remove(Request::get('id'));	
			}
			if(Request::get('action')=='publish')
			{
				publishComment(Request::get('id'));		
			}
			if(Request::get('action')=='unpublish')
			{
				unpublishComment(Request::get('id'));		
			}
		}		

		$curPage=Uri::getNext('comments');

		if($curPage=='page')
		{
			$curPage=Uri::getNext('page');
		}
		else
		{
			$curPage=0;
		}

		$post['pages']=genPage('comments',$curPage);

		$post['listData']=Comments::get(array(
			'limitPage'=>$curPage,
			'limitShow'=>20,
			'isHook'=>'no'			
			));


		View::make('usercp/head',array('title'=>'List comments - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/pagesList',$post);

        $this->makeContents('commentsList',$post);        

        View::make('usercp/footer'); 		
	}


	public function remove()
	{

		$id=Uri::getNext('remove');

		Comments::remove(array($id));		

		Redirect::to('usercp/comments');
	}
	public function approved()
	{

		$id=Uri::getNext('approved');

		Comments::update($id,array('status'=>'1'));		

		Redirect::to('usercp/comments');
	}

	public function view()
	{

		$post=array('alert'=>'');

		// Model::load('misc');
		// Model::load('admincp/pages');

		$id=Uri::getNext('view');
		$post['id']=$id;

		$loadData=Comments::get(array('where'=>"where commentid='$id'"));
		$post['edit']=$loadData[0];	

		$postid=$loadData[0]['postid'];

		// print_r($loadData);die();

		$thePost=Post::get(array(
			'where'=>"where postid='$postid'"
			));

		$post['thePost']=$thePost[0];


		View::make('usercp/head',array('title'=>'View comment #'.$id.' - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/pagesEdit',$post);

        $this->makeContents('commentView',$post);       

        View::make('usercp/footer'); 			
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('usercp/nav');
                
        View::make('usercp/left');  
              
        View::make('usercp/startContent');

        View::make('usercp/'.$viewPath,$inputData);

        View::make('usercp/endContent');
         // View::make('admincp/right');

    }

}

?>