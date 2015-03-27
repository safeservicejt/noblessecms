<?php

function listReviews($curPage,$whereAddon='')
{

	$loadData=Reviews::get(array(
		'limitPage'=>$curPage,
		'limitShow'=>20,
		'isHook'=>'no',
		'where'=>$whereAddon			
		));		

	if(!isset($loadData[0]['reviewid']))
	{
		return array();
	}

	$total=count($loadData);

	$listID='';

	$listUserID='';

	for($i=0;$i<$total;$i++)
	{
		$listID.="'".$loadData[$i]['productid']."', ";

		$listUserID.="'".$loadData[$i]['userid']."', ";


	}

	$listID=substr($listID, 0,strlen($listID)-2);

	$listUserID=substr($listUserID, 0,strlen($listUserID)-2);

	$loadProd=Products::get(array(
		'where'=>"where productid IN ($listID)"
		));

	$totalProd=count($loadProd);



	for($i=0;$i<$total;$i++)
	{
		for($j=0;$j<$totalProd;$j++)
		{
			if($loadData[$i]['productNodeid']==$loadProd[$j]['nodeid'])
			{
				$loadData[$i]['title']=$loadProd[$j]['title'];

				$j=$totalProd;
			}
		}
	}

	$loadUser=Users::get(array(
		'where'=>"where userid IN ($listID)"
		));

	$totalProd=count($loadUser);



	for($i=0;$i<$total;$i++)
	{
		for($j=0;$j<$totalProd;$j++)
		{
			if($loadData[$i]['userid']==$loadUser[$j]['userid'])
			{
				$loadData[$i]['firstname']=$loadUser[$j]['firstname'];
				$loadData[$i]['lastname']=$loadUser[$j]['lastname'];
				$loadData[$i]['email']=$loadUser[$j]['email'];
				$j=$totalProd;
			}
		}
	}

	return $loadData;
}

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

		$method=($method=='reviewid')?'id':$method;
		$method=($method=='prodid')?'productid':$method;
		$method=($method=='productid')?'productid':$method;
		$method=($method=='userid')?'userid':$method;

		switch ($method) {
			case 'id':

			$resultData['listData']=listReviews($curPage,"where reviewid='$keyword'");

				break;
			case 'productid':

			$resultData['listData']=listReviews($curPage,"where productid='$keyword'");
				break;
			case 'before':

			$resultData['listData']=listReviews($curPage,"where date_added < '$keyword'");
				break;
			case 'after':

			$resultData['listData']=listReviews($curPage,"where date_added > '$keyword'");
				break;
			case 'on':

			$resultData['listData']=listReviews($curPage,"where date_added = '$keyword'");
				break;
			case 'userid':

			$resultData['listData']=listReviews($curPage,"where userNodeid = '$keyword'");
				break;

		}
		// print_r($matches);die();
	}
	else
	{
		$txtKeyword=String::encode($txtKeyword);

		preg_match('/"(.*?)"/i', $txtKeyword,$matches);

		$txtKeyword=$matches[1];

		$resultData['listData']=listReviews($curPage,"where review_content LIKE '%$txtKeyword%'");
	}

	// print_r($txtKeyword);die();

	return $resultData;
}

function lastReviews($limitShow=10)
{
    if($loadData=Cache::loadKey('statsLastReviews',300))
    {
        return $loadData;
    }

    $li='';

    $loadData=Reviews::get(array(
        'limitShow'=>$limitShow,
        'isHook'=>'no',
        'orderby'=>"order by date_added desc"
        ));

    if(!isset($loadData[0]['productid']))
    {
    	return '';
    }

    $total=count($loadData);

    $listID='';

    for($i=0;$i<$total;$i++)
    {
    	$listID.="'".$loadData[$i]['productid']."', ";
    }

    $loadProd=Products::get(array(
    	'where'=>"where productid IN ($listID)"
    	));


    $totalProd=count($loadProd);

    for($i=0;$i<$total;$i++)
    {
    	for($j=0;$j<$totalProd;$j++)
    	{
    		$loadData[$i]['title']=$loadProd[$j]['title'];
    	}
    }

    if(isset($loadData[0]['title']))
    {
        for($i=0;$i<$total;$i++)
        {
        	$loadData[$i]['title']=String::decode($loadData[$i]['title']);


            $li.='
                    <!-- tr -->
                    <tr>
                    <td>'.$loadData[$i]['date_added'].'</td>
                    <td>'.$loadData[$i]['title'].'</td>
                    <td>'.ucfirst($loadData[$i]['status']).'</td>
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
                    <td colspan="4">There are not have any review.</td>
                    </tr>
                    <!-- tr -->

        ';
    }

    Cache::saveKey('statsLastReviews',$li);


	return $li;
}




?>