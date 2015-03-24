<?php

class controlCategories
{

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

		Model::load('admincp/categories');

		if(Request::has('btnAdd'))
		{
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
				if(Request::has('id'))
				Categories::remove(Request::get('id'));	
			}
				

		}

		if(Uri::has('edit'))
		{
				$post['showEdit']='yes';

				$id=Uri::getNext('edit');

				$post['catid']=$id;

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

		$post['pages']=Misc::genPage('admincp/categories',$curPage);

		// DBCache::enable();

		if(!Request::has('btnSearch'))
		{
			$post['categories']=Categories::get(array(
				'limitShow'=>30,
				'limitPage'=>$curPage,
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));		
		}
		else
		{
			$searchData=searchProcess(Request::get('txtKeywords'));

			$post['categories']=$searchData['categories'];

			$post['pages']=$searchData['pages'];

		}


		View::make('admincp/head',array('title'=>'Categories manage - '.ADMINCP_TITLE));

        $this->makeContents('categories',$post);

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