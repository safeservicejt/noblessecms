<?php

class controlTemplatestore
{
	function __construct()
	{
		// if(GlobalCMS::ecommerce()==false){
		// 	Alert::make('Page not found');
		// }
	}
	public function index()
	{
		$post=array();

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['pages']=Misc::genPage('admincp/templatestore',$curPage);		

		$post['theList']=TemplateStore::get(array(
			'limitPage'=>$curPage,
			'orderBy'=>'date_added',
			'sortBy'=>'desc'
			));

		View::make('admincp/head',array('title'=>'Templates Store - '.ADMINCP_TITLE));

        $this->makeContents('templateStore',$post);        

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