<?php

function searchProcess($txtKeyword)
{

	$curPage=Uri::getNext('news');

	if($curPage=='page')
	{
		$curPage=Uri::getNext('page');
	}
	else
	{
		$curPage=0;
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
		$resultData['listData']='';

		$resultData['pages']='';

		return $resultData;
	}

	if(preg_match('/^(\w+)\:(.*?)$/i', $txtKeyword,$matches))
	{
		$method=strtolower($matches[1]);

		$keyword=strtolower(trim($matches[2]));

		$method=($method=='contactid')?'id':$method;

		switch ($method) {
			case 'id':
			$resultData['listData']=Contactus::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where contactid='$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'name':
			$resultData['listData']=Contactus::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where fullname LIKE '%$keyword%'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'before':
			$resultData['listData']=Contactus::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_added < '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'after':
			$resultData['listData']=Contactus::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_added > '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'on':
			$resultData['listData']=Contactus::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where date_added = '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'email':
			$resultData['listData']=Contactus::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where email LIKE '%$keyword%'",
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
		
		$resultData['listData']=Contactus::get(array(
			'limitShow'=>20,			
			'limitPage'=>$curPage,
			'where'=>"where content LIKE '%$txtKeyword%'",
			'orderby'=>'order by date_added desc',
			'isHook'=>'no'
			));	
	}

	// print_r($txtKeyword);die();

	return $resultData;
}



function lastContactus($limitShow=10)
{
    if($loadData=Cache::loadKey('lastContactus',300))
    {
        return $loadData;
    }

    $li='';

    $loadData=Contactus::get(array(
        'limitShow'=>$limitShow
         ));

    $total=count($loadData);

    if($total > 0)
    {
        for($i=0;$i<$total;$i++)
        {

            $li.='
                    <!-- tr -->
                    <tr>
                    <td>'.ucfirst($loadData[$i]['date_added']).'</td>
                     <td>'.ucfirst($loadData[$i]['fullname']).'</td>

                    <td class="text-right">'.$loadData[$i]['email'].'</td>
                    </tr>
                    <!-- tr -->

            ';
        }       
    }
    else
    {
        $li='
                    <!-- tr -->
                    <tr>
                    <td colspan="2">There are not have any contact.</td>
                    </tr>
                    <!-- tr -->

        ';
    }

    Cache::saveKey('lastContactus',$li);
    
	return $li;
}
?>