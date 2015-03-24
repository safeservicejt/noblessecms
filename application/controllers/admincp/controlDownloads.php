<?php

class controlDownloads
{
	function __construct()
	{
		// if(GlobalCMS::ecommerce()==false){
		// 	Alert::make('Page not found');
		// }
	}
	public function index()
	{
		

		$post=array('alert'=>'');

		Model::load('misc');
		Model::load('admincp/downloads');

		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				if(Request::has('id'))
				Downloads::remove(Request::get('id'));	
			}
		}			

		if(Request::has('btnAdd'))
		{

			if(!insertProcess())
			{
				$post['alert']='<div class="alert alert-warning">Error. Have error while uploading your file!</div>';
			}
			else
			{
				$post['alert']='<div class="alert alert-success">Success. Add new download success!</div>';
				
			}
		}

		if(Request::has('btnSave'))
		{
			$valid=Validator::make(array(
				'send.title'=>'min:2|slashes',
				'send.remaining'=>'number|slashes'
				));

			if(!$valid)
			{
				$post['alert']='<div class="alert alert-warning">Error. Have error while update file information!</div>';
			}	
			else
			{
				Downloads::update(Request::get('send'));

				$post['alert']='<div class="alert alert-success">Success.Update download success!</div>';				
			}

		}

		$post['showEdit']='no';
		if(Request::has('btnAction'))
		{
			if(Request::get('action')=='delete')
			{
				if(Request::has('id'))
				Downloads::remove(Request::get('id'));	
			}
				

		}

		if(Uri::has('edit'))
		{
				$post['showEdit']='yes';

				$id=Uri::getNext('edit');

				$post['id']=$id;

				$data=Downloads::get(array(
					'where'=>"where nodeid='$id'"
					));
				$post['edit']=$data[0];
		}


		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['pages']=genPage('downloads',$curPage);
		
		if(!Request::has('btnSearch'))
		{
			$post['downloads']=Downloads::get(array(
				'limitPage'=>$curPage,
				'limitShow'=>20,
				'isHook'=>'no'				
				));		
		}
		else
		{
			$searchData=searchProcess(Request::get('txtKeywords'));

			$post['downloads']=$searchData['downloads'];

			$post['pages']=$searchData['pages'];

		}


		View::make('admincp/head',array('title'=>'List downloads - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/downloads',$post);
        $this->makeContents('downloads',$post);        

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