<?php

class controlAffiliates
{
	function __construct()
	{
		if(GlobalCMS::ecommerce()==false){
			Alert::make('Page not found');
		}
	}
	public function index()
	{
		if(Uri::has('addnew'))
		{
			$this->addnew();
			die();
		}
		if(Uri::has('edit'))
		{
			$this->edit();
			die();
		}


		$post=array('alert'=>'');

		Model::load('misc');
		// Model::load('admincp/users');
		Model::load('admincp/affiliate');
	

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['pages']=genPage('affiliates',$curPage);


		// $post['usergroups']=Usergroups::get();


		
		// $post['users']=Affiliate::get(array(
		// 	'limitShow'=>20,
		// 	'limitPage'=>$curPage,
		// 	'query'=>"select a.earned,a.commission,a.userNodeid,u.firstname,u.lastname from affiliate a,users u where a.userNodeid=u.nodeid order by a.userNodeid desc"
		// 	));

		$post['users']=listAffiliate($curPage);

		View::make('admincp/head',array('title'=>'List affiliate - '.ADMINCP_TITLE));

        $this->makeContents('affiliatesList',$post);
        
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