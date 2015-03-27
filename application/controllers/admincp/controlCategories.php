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
			try {

				insertProcess();

				$post['alert']='<div class="alert alert-success">Add new categories success.</div>';

			} catch (Exception $e) {

				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';

			}

		}

		if(Request::has('btnSave'))
		{
			try {

				updateProcess();

				$post['alert']='<div class="alert alert-success">Update changes success.</div>';

			} catch (Exception $e) {

				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';

			}


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