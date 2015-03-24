<?php

class controlVouchers
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
		Model::load('admincp/vouchers');

		if(Request::has('btnAdd'))
		{

			$post['alert']='<div class="alert alert-success">Add new voucher success.</div>';

			$data=Request::get('send');

			if(!$id=Vouchers::insert($data))
			{
				$post['alert']='<div class="alert alert-warning">Add new voucher error.</div>';
			}

		}

		if(Request::has('btnSave'))
		{
				$post['alert']='<div class="alert alert-success">Edit voucher success.</div>';

				// editCategory(array('id'=>Request::get('send.id'),'title'=>Request::get('send.title'),'order'=>Request::get('send.sort_order','0'),'oldimage'=>Request::get('send.oldimage')));

				$id=Uri::getNext('edit');

				$data=array();

				$inputData=array();

				$data=Request::get('send');

				// print_r($data);die();

				Vouchers::update($id,$data);

		}

		$post['showEdit']='no';
		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				if(Request::has('id'))
				Vouchers::remove(Request::get('id'));	
				
			}
			if(Request::get('action')=='publish')
			{
				publish(Request::get('id'));	
				
			}
			if(Request::get('action')=='notpublish')
			{
				unpublish(Request::get('id'));	

			}
				

		}

		if(Uri::has('edit'))
		{
				$post['showEdit']='yes';

				$id=Uri::getNext('edit');

				$post['id']=$id;

				$data=Vouchers::get(array(
					'where'=>"where nodeid='$id'"
					));
				$post['edit']=$data[0];




		}


		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['pages']=genPage('giftvouchers',$curPage);


		if(!Request::has('btnSearch'))
		{
			$post['vouchers']=Vouchers::get(array(
				'limitShow'=>30,
				'limitPage'=>$curPage,
				'orderby'=>'order by date_added desc'
				));		
		}
		else
		{
			$searchData=searchProcess(Request::get('txtKeywords'));

			$post['vouchers']=$searchData['vouchers'];

			$post['pages']=$searchData['pages'];

		}
		// print_r($post);die();

		// $post['allcategories']=allCategories();


		View::make('admincp/head',array('title'=>ADMINCP_TITLE));

        $this->makeContents('vouchersList',$post);

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