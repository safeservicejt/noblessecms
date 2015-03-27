<?php

class controlNews
{

	public function index()
	{
		if(Uri::has('edit'))
		{
			$this->edit();
			die();
		}

		if(Uri::has('addnew'))
		{
			$this->addnew();
			die();
		}

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
        if($match=Uri::match('\/jsonPage'))
        {
            $keyword=String::encode(Request::get('keyword',''));

            $loadData=Pages::get(array(
            	'where'=>"where title LIKE '%$keyword%'",
                'orderby'=>'order by title asc'
                ));

            $total=count($loadData);

            $li='';

            for($i=0;$i<$total;$i++)
            {
                $li.='<li><span data-method="page" data-id="'.$loadData[$i]['pageid'].'" >'.$loadData[$i]['title'].'</span></li>';
            }

            echo $li;
            die();
        }

		$post=array('alert'=>'');

		Model::load('admincp/news');

		if(Request::has('btnAction'))
		{
			actionProcess();
		}


		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}


		$post['pages']=Misc::genPage('admincp/news',$curPage);

		if(!Request::has('btnSearch'))
		{
			$post['posts']=listPostProcess($curPage);
		}
		else
		{
			$searchData=searchProcess(Request::get('txtKeywords'));

			$post['posts']=$searchData['posts'];

			$post['pages']=$searchData['pages'];

		}

		View::make('admincp/head',array('title'=>'List post - '.ADMINCP_TITLE));


        $this->makeContents('newsList',$post);        

        View::make('admincp/footer'); 		
	}


	public function addnew()
	{

		$post=array('alert'=>'');

		Model::load('admincp/news');

		$post['id']=Uri::getNext('edit');

		if(Request::has('btnAdd'))
		{
			try {

				insertProcess();

				$post['alert']='<div class="alert alert-success">Success. Add new post complete!</div>';

			} catch (Exception $e) {

				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';

			}
		}

		View::make('admincp/head',array('title'=>'Add new post - '.ADMINCP_TITLE));


        $this->makeContents('newsAdd',$post);        

        View::make('admincp/footer'); 			
	}	

	public function edit()
	{

		$post=array('alert'=>'');

		Model::load('admincp/news');

		$id=Uri::getNext('edit');
		$post['id']=$id;

		if(Request::has('btnSave'))
		{
			try {

				updateProcess($id);

				$post['alert']='<div class="alert alert-success">Save changes successful!</div>';
				
			} catch (Exception $e) {

				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';

			}							
		}

		$loadData=editInfo($id);

		$post['edit']=$loadData['data'];

		$post['tags']=$loadData['tags'];

		View::make('admincp/head',array('title'=>'Edit post '.ADMINCP_TITLE));


        $this->makeContents('newsEdit',$post);       

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