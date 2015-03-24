<?php

class controlCategories
{
	function __construct()
	{
		if(UserGroups::enable('can_manage_category')==false){
			Alert::make('Page not found');
		}
	}

	public function index()
	{

        if($match=Uri::match('\/jsonCategory'))
        {
            $keyword=String::encode(Request::get('keyword',''));

            $loadData=Categories::get(array(
            	'where'=>"where cattitle LIKE '%$keyword%'",
                'orderby'=>'order by cattitle asc'
                ));

            $total=count($loadData);

            $li='';

            for($i=0;$i<$total;$i++)
            {
                $li.='<li><span data-method="category" data-id="'.$loadData[$i]['catid'].'" >'.$loadData[$i]['cattitle'].'</span></li>';
            }

            echo $li;
            die();
        }
		$post=array('alert'=>'');

		if(Request::has('btnAdd'))
		{
			if(UserGroups::enable('can_addnew_category')==false){
				Alert::make('Page not found');
			}


			$post['alert']='<div class="alert alert-success">Add new categories success.</div>';

			$data=Request::get('send');

			$data['parentid']=Request::get('send.parentid',0);


			if(!$id=Categories::insert($data))
			{

				$post['alert']='<div class="alert alert-warning">Add new categories error.</div>';
			}
			else
			{
				if(!$shortPath=File::upload('thumbnail','/uploads/images/'))
				{
					$post['alert']='<div class="alert alert-warning">Add new categories error.</div>';
				}
				else
				{
					$updateData=array(
						'image'=>$shortPath
						);					

					Categories::update($id,$updateData);
				}

			}

		}

		if(Request::has('btnSave'))
		{
				if(UserGroups::enable('can_edit_category')==false){
					Alert::make('Page not found');
				}			

				$post['alert']='<div class="alert alert-success">Edit categories success.</div>';

				// editCategory(array('id'=>Request::get('send.id'),'title'=>Request::get('send.title'),'order'=>Request::get('send.sort_order','0'),'oldimage'=>Request::get('send.oldimage')));

				$id=Uri::getNext('edit');

				$data=array();

				$data=Request::get('send');

				$data['parentid']=Request::get('send.parentid',0);

				if(!$shortPath=File::upload('thumbnail','/uploads/images/'))
				{
					
				}
				else
				{
					$data['image']=$shortPath;				
				}

				Categories::update($id,$data);

		}

		$post['showEdit']='no';
		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				if(UserGroups::enable('can_delete_category')==false){
					Alert::make('Page not found');
				}
								
				Categories::remove(Request::get('id'));	
			}
				

		}

		if(Uri::has('edit'))
		{
				$post['showEdit']='yes';

				$id=Uri::getNext('edit');

				$post['id']=$id;

				$data=Categories::get(array(
					'where'=>"where catid='$id'"
					));
				$post['edit']=$data[0];


		}


		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['pages']=Misc::genPage('usercp/categories',$curPage);

		$post['categories']=Categories::get(array(
			'limitShow'=>30,
			'limitPage'=>$curPage,
			'orderby'=>'order by date_added desc'
			));

		// print_r($post);die();

		// $post['allcategories']=allCategories();


		View::make('usercp/head',array('title'=>ADMINCP_TITLE));

        $this->makeContents('categories',$post);

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