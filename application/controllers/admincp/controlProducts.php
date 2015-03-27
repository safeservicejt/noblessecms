<?php

class controlProducts
{
	function __construct()
	{
		if(GlobalCMS::ecommerce()==false){
			Alert::make('Page not found');
		}
	}
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
        if($match=Uri::match('\/jsonManufacturer'))
        {
            $keyword=String::encode(Request::get('keyword',''));

            $loadData=Manufacturers::get(array(
            	'where'=>"where manufacturer_title LIKE '%$keyword%'",
                'orderby'=>'order by manufacturer_title asc'
                ));

            $total=count($loadData);

            $li='';

            for($i=0;$i<$total;$i++)
            {
                $li.='<li><span data-method="manufacturer" data-id="'.$loadData[$i]['manufacturerid'].'" >'.$loadData[$i]['manufacturer_title'].'</span></li>';
            }

            echo $li;
            die();
        }

        if($match=Uri::match('\/jsonDownload'))
        {
            $keyword=String::encode(Request::get('keyword',''));

            $loadData=Downloads::get(array(
            	'where'=>"where title LIKE '%$keyword%'",
                'orderby'=>'order by title asc'
                ));

            $total=count($loadData);

            $li='';

            for($i=0;$i<$total;$i++)
            {
                $li.='<li><span data-method="download" data-id="'.$loadData[$i]['downloadid'].'" >'.$loadData[$i]['title'].'</span></li>';
            }

            echo $li;
            die();
        }

		$post=array('alert'=>'');

		Model::load('admincp/products');
		// Model::load('admincp/categories');


		if(Uri::has('refreshImages'))
		{
			$prodid=Request::get('send_prodid');

			$result=genProdImages($prodid);

			echo $result;

			die();
		}

		if(Uri::has('removeImage'))
		{
			$prodid=Request::get('send_prodid');

			$image=Request::get('send_image');

			// Database::query("delete from products_images where productNodeid='$prodid' AND image='$image'");

			prodImages::remove(array($prodid),"AND images='$image'");

			// unlink(ROOT_PATH.$image);

			echo 'OK';

			die();
		}
		if(Uri::has('setSortOrder'))
		{
			$prodid=Request::get('send_prodid');

			$order=Request::get('send_order');

			$image=Request::get('send_image');

			// $dbName=Multidb::renderDb('products_images');

			// Database::query("update $dbName set sort_order='$order' where productNodeid='$prodid' AND image='$image'");

			prodImages::update($prodid,array(
				'sort_order'=>$order
				),"AND image='$image'");

			echo 'OK';

			die();
		}






		if(Request::has('btnAction'))
		{
			actionProcess();
		}		

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['pages']=Misc::genPage('admincp/products',$curPage);

		if(!Request::has('btnSearch'))
		{
			$post['products']=Products::get(array(
				'limitShow'=>30,
				'limitPage'=>$curPage,
				'orderby'=>'order by date_added desc'
				));		
		}
		else
		{
			$searchData=searchProcess(Request::get('txtKeywords'));

			$post['products']=$searchData['products'];

			$post['pages']=$searchData['pages'];

		}		

		$post['categories']=Categories::get(array(
			'orderby'=>'order by date_added desc'
			));


		View::make('admincp/head',array('title'=>'List product - '.ADMINCP_TITLE));
        
        $this->makeContents('prodList',$post);        

        View::make('admincp/footer'); 		
	}


	public function addnew()
	{

		$post=array('alert'=>'');

		Model::load('admincp/products');

		if(Request::has('btnAdd'))
		{
			try {

				insertProcess();

				$post['alert']='<div class="alert alert-success">Add new product success.</div>';

			} catch (Exception $e) {

				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';

			}				
		}



		View::make('admincp/head',array('title'=>'Add new product - '.ADMINCP_TITLE));

        $this->makeContents('prodAdd',$post);        

        View::make('admincp/footer'); 			
	}	

	public function edit()
	{
		$post=array('alert'=>'');

		Model::load('admincp/products');

		$id=Uri::getNext('edit');
		$post['id']=$id;

		if(Request::has('btnSave'))
		{
			try {

				updateProcess($id);

				$post['alert']='<div class="alert alert-success">Save changes success.</div>';

			} catch (Exception $e) {

				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';

			}					
		}

		
		$loadData=editInfo($id);

		$post['edit']=$loadData['data'];

		$post['selectCategories']=$loadData['categories'];

		$post['selectPages']=$loadData['pages'];

		$post['selectImages']=$loadData['images'];

		$post['selectDownloads']=$loadData['downloads'];

		$post['tags']=$loadData['tags'];

		// print_r($post['edit']);die();

		// $post['selectTags']=implode(',',$tags);

		View::make('admincp/head',array('title'=>'Edit product - '.ADMINCP_TITLE));

        $this->makeContents('prodEdit',$post);        

        View::make('admincp/footer'); 			
	}
    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/nav');
                
        View::make('admincp/left');  
              
        View::make('admincp/startContent');

        View::make('admincp/'.$viewPath,$inputData);

        View::make('admincp/endContent');
    }

}

?>