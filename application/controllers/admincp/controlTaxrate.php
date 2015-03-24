<?php

class controlTaxrate
{

	public function index()
	{


		$post=array('alert'=>'');

		Model::load('misc');
		Model::load('admincp/taxrate');

		if(Request::has('btnAdd'))
		{
			$post['alert']='<div class="alert alert-success">Add new tax rate success.</div>';

			$data=Request::get('send');

			$countries=renderInsert(Request::get('countries'));

			$data['country_short']=$countries;

			if(!$id=Taxrate::insert($data))
			{
				$post['alert']='<div class="alert alert-warning">Add new tax rate error.</div>';
			}

		}

		if(Request::has('btnSave'))
		{
				$post['alert']='<div class="alert alert-success">Edit tax rate success.</div>';

				$id=Uri::getNext('edit');

				$data=array();

				$inputData=array();

				$data=Request::get('send');

				$countries=renderInsert(Request::get('countries'));

				// print_r($countries);die();

				$data['country_short']=$countries;				

				Taxrate::update($id,$data);

		}

		$post['showEdit']='no';
		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				Taxrate::remove(Request::get('id'));	
			}
				

		}

		if(Uri::has('edit'))
		{
				$post['showEdit']='yes';

				$id=Uri::getNext('edit');

				$post['id']=$id;

				$data=Taxrate::get(array(
					'where'=>"where taxid='$id'"
					));

				$post['edit']=$data[0];

				$post['edit']['countries']=renderEdit($post['edit']['country_short']);

				// print_r($post['edit']['country_short']);die();
		}


		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['pages']=genPage('taxrate',$curPage);

		$post['taxrate']=Taxrate::get(array(
			'limitShow'=>30,
			'limitPage'=>$curPage
			));

		$post['countries']=Country::get();

		// print_r($post['countries']);die();


		View::make('admincp/head',array('title'=>ADMINCP_TITLE));

        $this->makeContents('taxrate',$post);

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