<?php

class controlComments
{

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
		if(Uri::has('remove'))
		{
			$this->remove();
			die();
		}


		$post=array('alert'=>'');

		Model::load('admincp/comments');

		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				if(Request::has('id'))				
				Comments::remove(Request::get('id'));	
			}
			if(Request::get('action')=='publish')
			{
				if(Request::has('id'))	
				Comments::update(Request::get('id'),array('status'=>1));	
			}
			if(Request::get('action')=='unpublish')
			{
				if(Request::has('id'))	
				Comments::update(Request::get('id'),array('status'=>0));			
			}
		}		

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['pages']=Misc::genPage('admincp/comments',$curPage);



		if(!Request::has('btnSearch'))
		{
			$post['listData']=Comments::get(array(
				'limitPage'=>$curPage,
				'limitShow'=>20,
				'isHook'=>'no'			
				));			
		}
		else
		{
			$searchData=searchProcess(Request::get('txtKeywords'));

			$post['listData']=$searchData['listData'];

			$post['pages']=$searchData['pages'];

		}
		View::make('admincp/head',array('title'=>'List comments - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/pagesList',$post);

        $this->makeContents('commentsList',$post);        

        View::make('admincp/footer'); 		
	}


	public function remove()
	{

		if(!$match=Uri::match('\/remove\/(\d+)'))
		{
			Redirect::to(ADMINCP_URL);
		}

		Comments::remove(array($match[1]));		

		Redirect::to('admincp/comments');
	}
	public function approved()
	{
		if(!$match=Uri::match('\/approved\/(\d+)'))
		{
			Redirect::to(ADMINCP_URL);
		}

		Comments::update($match[1],array('status'=>'1'));		

		Redirect::to('admincp/comments');
	}

	public function view()
	{

		$post=array('alert'=>'');

		Model::load('misc');
		// Model::load('admincp/pages');

		$id=Uri::getNext('view');
		$post['id']=$id;

		$loadData=Comments::get(array('where'=>"where commentid='$id'"));
		$post['edit']=$loadData[0];	

		$postid=$loadData[0]['postid'];

		// print_r($loadData);die();

		$thePost=Post::get(array(
			'where'=>"where postid='$postid'",
			'selectFields'=>'postid,title'
			));

		$post['thePost']=$thePost[0];


		View::make('admincp/head',array('title'=>'View comment #'.$id.' - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/pagesEdit',$post);

        $this->makeContents('commentView',$post);       

        View::make('admincp/footer'); 			
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/nav');
                
        View::make('admincp/left');  
              
        View::make('admincp/startContent');

        View::make('admincp/'.$viewPath,$inputData);

        View::make('admincp/endContent');
         // View::make('admincp/right');

    }

}

?>