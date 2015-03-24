<?php

class controlContactus
{

	public function index()
	{
		if(Uri::has('view'))
		{
			$this->view();
			die();
		}
		if(Uri::has('remove'))
		{
			$this->remove();
			die();
		}


		$post=array('alert'=>'');

		Model::load('admincp/contactus');

		if(Request::has('btnAction'))
		{
			if(Request::has('id'))
			if(Request::get('action')=='delete')
			{
				Contactus::remove(Request::get('id'));	
			}
		}		

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['pages']=Misc::genPage('admincp/contactus',$curPage);


		if(!Request::has('btnSearch'))
		{
			$post['listData']=Contactus::get(array(
				'limitPage'=>$curPage,
				'limitShow'=>20,
				'isHook'=>'no'				
				));		
		}
		else
		{
			$searchData=searchProcess(Request::get('txtKeywords'));

			$post['listData']=$searchData['listData'];

			$post['pages']=$searchData['pages'];

		}

		View::make('admincp/head',array('title'=>'List contact us - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/pagesList',$post);

        $this->makeContents('contactList',$post);        

        View::make('admincp/footer'); 		
	}


	public function remove()
	{

		$id=Uri::getNext('remove');

		Contactus::remove(array($id));		

		Redirect::to('admincp/contactus');
	}
	public function view()
	{

		$post=array('alert'=>'');

		Model::load('misc');
		// Model::load('admincp/pages');

		$id=Uri::getNext('view');
		$post['id']=$id;

		if(Request::has('btnSave'))
		{
				$post['alert']='<div class="alert alert-success">Save changes success.</div>';

				Pages::update($id,Request::get('send'));
		}

		$loadData=Contactus::get(array('where'=>"where contactid='$id'"));
		$post['edit']=$loadData[0];	


		View::make('admincp/head',array('title'=>'View contact #'.$id.' - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/pagesEdit',$post);

        $this->makeContents('contactView',$post);       

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