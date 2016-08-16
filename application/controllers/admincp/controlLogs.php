<?php

class controlLogs
{
	public function index()
	{

		$post=array('alert'=>'');

		Model::load('admincp/logs');

		if($match=Uri::match('\/logs\/(\w+)'))
		{
			if(method_exists("controlLogs", $match[1]))
			{	
				$method=$match[1];

				$this->$method();

				die();
			}
			
		}

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		if(Request::has('btnAction'))
		{	
			actionProcess();
		}

		$post['theList']=Logs::get(array(
			'limitShow'=>30,
			'limitPage'=>$curPage,
			'cacheTime'=>1
			));

		$countPost=Logs::get(array(
			'selectFields'=>'count(id)as totalRow',
			'cache'=>'no'
			));

		$post['pages']=Misc::genSmallPage(array(
			'url'=>'admincp/logs/',
			'curPage'=>$curPage,
			'limitShow'=>20,
			'limitPage'=>15,
			'showItem'=>count($post['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$post['totalPost']=$countPost[0]['totalRow'];

		$post['totalPage']=intval((int)$countPost[0]['totalRow']/20);

		System::setTitle('Logs - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('logsList',$post);

		View::make('admincp/footer');

	}


    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}