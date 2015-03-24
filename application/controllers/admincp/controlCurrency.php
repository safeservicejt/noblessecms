<?php

class controlCurrency
{

	public function index()
	{


		$post=array('alert'=>'');

		Model::load('misc');
		Model::load('admincp/currency');

		if(Request::has('btnAdd'))
		{

			$post['alert']='<div class="alert alert-success">Add new currency success.</div>';

			$data=Request::get('send');

			if(!$id=Currency::insert($data))
			{	
				$post['alert']='<div class="alert alert-warning">Add new currency error.</div>';
			}

		}

		if(Request::has('btnSave'))
		{
			$post['alert']='<div class="alert alert-success">Edit currency success.</div>';

			// editCategory(array('id'=>Request::get('send.id'),'title'=>Request::get('send.title'),'order'=>Request::get('send.sort_order','0'),'oldimage'=>Request::get('send.oldimage')));

			$id=Uri::getNext('edit');

			$data=array();

			$data=Request::get('send');

			Currency::update($id,$data);
		}

		$post['showEdit']='no';
		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				Currency::remove(Request::get('id'));	
			}
		}

		if(Uri::has('edit'))
		{
				$post['showEdit']='yes';

				$id=Uri::getNext('edit');

				$post['id']=$id;

				$data=Currency::get(array(
					'where'=>"where currencyid='$id'"
					));
				
				$post['edit']=$data[0];
		}


		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['pages']=genPage('currency',$curPage);

		$post['theList']=Currency::get(array(
			'limitShow'=>30,
			'limitPage'=>$curPage,
			'orderby'=>'order by currencyid desc'
			));


		View::make('admincp/head',array('title'=>'Currency manage - '.ADMINCP_TITLE));

        $this->makeContents('currency',$post);

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