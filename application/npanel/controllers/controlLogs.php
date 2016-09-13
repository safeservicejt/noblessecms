<?php

class controlLogs
{
	public static function index()
	{

		$pageData=array('alert'=>'');
		
		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		if(Request::has('btnAction'))
		{	
			actionProcess();
		}

		$pageData['theList']=Logs::get(array(
			'limitShow'=>30,
			'limitPage'=>$curPage,
			'cacheTime'=>1
			));

		$countPost=Logs::get(array(
			'selectFields'=>'count(id)as totalRow',
			'cache'=>'no'
			));

		$pageData['pages']=Misc::genSmallPage(array(
			'url'=>'npanel/logs/',
			'curPage'=>$curPage,
			'limitShow'=>20,
			'limitPage'=>15,
			'showItem'=>count($pageData['theList']),
			'totalItem'=>$countPost[0]['totalRow'],
			));

		$pageData['totalPost']=$countPost[0]['totalRow'];

		$pageData['totalPage']=intval((int)$countPost[0]['totalRow']/20);

		System::setTitle('Logs - nPanel');

		Views::make('head');

		Views::make('left');

		Views::make('logsList',$pageData);

		Views::make('footer');		
	}	

	public static function edit()
	{
		self::index();
	}


}