<?php

class controlReviews
{
	function __construct()
	{
		if(GlobalCMS::ecommerce()==false){
			Alert::make('Page not found');
		}
	}
	public function index()
	{
		if(Uri::match('\/view'))
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

		Model::load('misc');
		Model::load('admincp/reviews');

		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				Reviews::remove(Request::get('id'));	
			}
			if(Request::get('action')=='publish')
			{
				publishReviews(Request::get('id'));		
			}
			if(Request::get('action')=='unpublish')
			{
				unpublishReviews(Request::get('id'));		
			}
		}		

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['pages']=genPage('reviews',$curPage);


		if(!Request::has('btnSearch'))
		{
			// $post['listData']=Reviews::get(array(
			// 	'query'=>"select r.reviewid,r.userid,u.firstname,u.lastname,u.email,r.date_added,r.status,p.title,p.productid from reviews r,users u,products p where u.userid=r.userid AND r.productid=p.productid order by r.reviewid",
			// 	'limitPage'=>$curPage,
			// 	'limitShow'=>20,
			// 	'isHook'=>'no'			
			// 	));	
			$post['listData']=listReviews($curPage);
					
		}
		else
		{
			$searchData=searchProcess(Request::get('txtKeywords'));

			$post['listData']=$searchData['listData'];

			$post['pages']=$searchData['pages'];

		}

		View::make('admincp/head',array('title'=>'List reviews - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/pagesList',$post);

        $this->makeContents('reviewList',$post);        

        View::make('admincp/footer'); 		
	}


	public function remove()
	{
		$id=Uri::getNext('remove');

		Reviews::remove(array($id));		

		Redirect::to('admincp/reviews');
	}
	public function approved()
	{

		$id=Uri::getNext('approved');

		Reviews::update($id,array('status'=>'1'));		

		Redirect::to('admincp/reviews');
	}

	public function view()
	{

		$post=array('alert'=>'');

		Model::load('misc');
		// Model::load('admincp/pages');

		$id=Uri::getNext('view');
		$post['id']=$id;

		$loadData=Reviews::get(array('where'=>"where reviewid='$id'"));
		$post['edit']=$loadData[0];	

		$postid=$loadData[0]['productid'];

		// print_r($loadData);die();

		$thePost=Products::get(array(
			'where'=>"where productid='$postid'",
			'selectFields'=>'productid,title'
			));

		$post['thePost']=$thePost[0];


		View::make('admincp/head',array('title'=>'View review #'.$id.' - '.ADMINCP_TITLE));

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