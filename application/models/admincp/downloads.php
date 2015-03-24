<?php
function searchProcess($txtKeyword)
{

	$curPage=0;

	if($match=Uri::match('\/page\/(\d+)'))
	{
		$curPage=$match[1];
	}

	$resultData=array();

	$resultData['pages']=genPage('news',$curPage);	

	$txtKeyword=trim($txtKeyword);

	Request::make('txtKeyword',$txtKeyword);

	$valid=Validator::make(array(
		'txtKeyword'=>'min:1|slashes'
		));

	if(!$valid)
	{
		$resultData['downloads']='';

		$resultData['pages']='';

		return $resultData;
	}

	if(preg_match('/^(\w+)\:(.*?)$/i', $txtKeyword,$matches))
	{
		$method=strtolower($matches[1]);

		$keyword=strtolower(trim($matches[2]));

		$method=($method=='downloadid')?'id':$method;

		switch ($method) {
			case 'id':
			$resultData['downloads']=Downloads::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where downloadid='$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
		}
		// print_r($matches);die();
	}
	else
	{
		$txtKeyword=String::encode($txtKeyword);

		preg_match('/"(.*?)"/i', $txtKeyword,$matches);

		$txtKeyword=$matches[1];
		
		$resultData['downloads']=Downloads::get(array(
			'limitShow'=>20,			
			'limitPage'=>$curPage,
			'where'=>"where title LIKE '%$txtKeyword%'",
			'orderby'=>'order by date_added desc',
			'isHook'=>'no'
			));	
	}

	// print_r($txtKeyword);die();

	return $resultData;
}


function insertProcess()
{
	$valid=Validator::make(array(
		'send.title'=>'min:2|slashes',
		'send.remaining'=>'slashes'
		));

	if(!$valid)
	{
		return false;
	}

	if(!$shortPath=File::upload('theFile'))
	{
		return false;
	}

	$post=array(
		'title'=>Request::get('send.title'),
		'remaining'=>Request::get('send.remaining',9999),
		'filename'=>$shortPath
		);

	if(!$downloadid=Downloads::insert($post))
	{
		return false;
	}	

	return true;
}
?>