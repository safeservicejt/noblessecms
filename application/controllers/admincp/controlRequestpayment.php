<?php

class controlRequestpayment
{

	public function index()
	{
		if(Uri::has('view'))
		{
			$this->view();
			die();
		}
		if(Uri::has('completed'))
		{
			$this->completed();
			die();
		}


		$post=array('alert'=>'');

		Model::load('misc');
		Model::load('admincp/requestpayment');

		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				Requestpayment::remove(Request::get('id'));	
			}
			if(Request::get('action')=='completed')
			{
				Requestpayment::completed(Request::get('id'));	
			}
		}		

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['pages']=genPage('requestpayment',$curPage);

		$post['theList']=Requestpayment::get(array(
			'limitPage'=>$curPage,
			'limitShow'=>20		
			));


		View::make('admincp/head',array('title'=>'List request payment - '.ADMINCP_TITLE));

        $this->makeContents('rqpaymentList',$post);        

        View::make('admincp/footer'); 		
	}


	public function remove()
	{
		$id=Uri::getNext('remove');

		Requestpayment::remove(array($id));		

		Redirect::to('admincp/requestpayment');
	}
	public function approved()
	{

		$id=Uri::getNext('approved');

		Requestpayment::update($id,array('status'=>'1'));		

		Redirect::to('admincp/requestpayment');
	}

	public function view()
	{

		$post=array('alert'=>'');

		Model::load('misc');
		// Model::load('admincp/pages');

		$id=Uri::getNext('view');
		$post['id']=$id;

		$loadData=Requestpayment::get(array('where'=>"where nodeid='$id'"));
		$post['edit']=$loadData[0];	

		$postid=$loadData[0]['postid'];

		// print_r($loadData);die();

		$thePost=Post::get(array(
			'where'=>"where postid='$postid'",
			'selectFields'=>'postid,title'
			));

		$post['thePost']=$thePost[0];


		View::make('admincp/head',array('title'=>'View request payment #'.$id.' - '.ADMINCP_TITLE));

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