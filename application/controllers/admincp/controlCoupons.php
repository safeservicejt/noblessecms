<?php

class controlCoupons
{
	function __construct()
	{
		if(GlobalCMS::ecommerce()==false){
			Alert::make('Page not found');
		}
	}
	public function index()
	{


		$post=array('alert'=>'');

		Model::load('misc');
		Model::load('admincp/coupons');

		if(Request::has('btnAdd'))
		{

			$post['alert']='<div class="alert alert-success">Add new coupon success.</div>';

			$data=Request::get('send');

			if(!$id=Coupons::insert($data))
			{
				$post['alert']='<div class="alert alert-warning">Add new coupon error.</div>';
			}

		}

		if(Request::has('btnSave'))
		{
				$post['alert']='<div class="alert alert-success">Edit coupon success.</div>';

				// editCategory(array('id'=>Request::get('send.id'),'title'=>Request::get('send.title'),'order'=>Request::get('send.sort_order','0'),'oldimage'=>Request::get('send.oldimage')));

				$id=Uri::getNext('edit');

				$data=array();

				$inputData=array();

				$data=Request::get('send');

				Coupons::update($id,$data);

		}

		$post['showEdit']='no';
		if(Request::has('btnAction'))
		{
			actionProcess();
		}

		if(Uri::has('edit'))
		{
				$post['showEdit']='yes';

				$id=Uri::getNext('edit');

				$post['id']=$id;

				$data=Coupons::get(array(
					'where'=>"where nodeid='$id'"
					));
				$post['edit']=$data[0];


		}


		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['pages']=genPage('coupons',$curPage);


		if(!Request::has('btnSearch'))
		{
			$post['coupons']=Coupons::get(array(
				'limitShow'=>30,
				'limitPage'=>$curPage,
				'orderby'=>'order by date_added desc'
				));	
		}
		else
		{
			$searchData=searchProcess(Request::get('txtKeywords'));

			$post['coupons']=$searchData['coupons'];

			$post['pages']=$searchData['pages'];

		}
		// print_r($post);die();

		// $post['allcategories']=allCategories();


		View::make('admincp/head',array('title'=>ADMINCP_TITLE));

        $this->makeContents('couponsList',$post);

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