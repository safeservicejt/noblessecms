<?php

class controlManufacturers
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
		// Model::load('admincp/manufacturers');

		if(Request::has('btnAdd'))
		{

			$post['alert']='<div class="alert alert-success">Add new manufacturer success.</div>';

			$insertData=Request::get('send');

			if(!$id=Manufacturers::insert($insertData))
			{
				$post['alert']='<div class="alert alert-danger">Add new manufacturer error.</div>';
			}
			else
			{
				Manufacturers::insertThumbnail($id,array('urlThumbnail'=>''));				
			}

		}

		if(Request::has('btnSave'))
		{
				$post['alert']='<div class="alert alert-success">Edit manufacturer success.</div>';


				$id=Uri::getNext('edit');			

				$updateData=Request::get('send');

				$updateData['nodeid']=$id;

				Manufacturers::update($id,$updateData);

				Manufacturers::insertThumbnail($id,array('urlThumbnail'=>''));

		}

		$post['showEdit']='no';
		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				Manufacturers::remove(Request::get('id'));		
			}
				
		}

		if(Uri::has('edit'))
		{
				$post['showEdit']='yes';

				$id=Uri::getNext('edit');

				$post['id']=$id;

				$manu=Manufacturers::get(array(
				'where'=>"where nodeid='$id'",
				'isHook'=>'no'			
					));	

				$post['edit']=$manu[0];					
		}


		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['pages']=genPage('manufacturers',$curPage);

		$post['manu']=Manufacturers::get(array(
		'limitShow'=>20,			
		'limitPage'=>$curPage,
		'orderby'=>'order by date_added desc',
		'isHook'=>'no'			
			));

		// $post['allmanu']=allManu();

		// print_r($post);die();


		View::make('admincp/head',array('title'=>'List manufacturers'.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/manufacturers',$post);
        
        $this->makeContents('manufacturers',$post);

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