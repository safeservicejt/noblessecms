<?php


function lastComments($limitShow=10)
{
    if($loadData=Cache::loadKey('lastComments',300))
    {
        return $loadData;
    }

    $li='';

    $loadData=Comments::get(array(
        'limitShow'=>$limitShow,
        'orderby'=>'order by date_added desc'
        ));

    $total=count($loadData);

    if(!isset($loadData[0]['postid']))
    {
        return '';
    }

    $listID='';

    for($i=0;$i<$total;$i++)
    {
        $listID.="'".$loadData[$i]['postid']."', ";
    }

    $listID=substr($listID, 0,strlen($listID)-2);

    $loadPost=Post::get(array(
        'where'=>"where post_type='normal' AND postid IN ($listID)"
        ));   

    for($i=0;$i<$total;$i++)
    {
        for($j=0;$j<$total;$j++)
        {
            if($loadPost[$i]['postid']==$loadData[$j]['postid'])
            {
                $loadPost[$i]['date_added']=$loadData[$j]['date_added'];
                $loadPost[$i]['fullname']=$loadData[$j]['fullname'];
            }
        }
    }

    if($total > 0)
    {
        for($i=0;$i<$total;$i++)
        {

            $li.='
                    <!-- tr -->
                    <tr>
                    <td class="col-lg-3">'.$loadPost[$i]['date_added'].'</td>
                    <td class="col-lg-3">'.$loadPost[$i]['fullname'].'</td>
                    <td class="col-lg-6">'.$loadPost[$i]['title'].'</td>
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
                    <td colspan="2">There are not have any comment.</td>
                    </tr>
                    <!-- tr -->

        ';
    }

    Cache::saveKey('lastComments',$li);
    
    return $li;
}

function topComments($limitShow=10)
{
    if($loadData=Cache::loadKey('topComments',300))
    {
        return $loadData;
    }

    $li='';
    

    $loadData=Comments::get(array(
        'limitShow'=>$limitShow,
        'query'=>'select count(commentid)as totalID from  comments group by postid order by count(commentid) desc'
        ));

    $total=count($loadData);

    if(!isset($loadData[0]['postid']))
    {
        return '';
    }

    $listID='';

    for($i=0;$i<$total;$i++)
    {
        $listID.="'".$loadData[$i]['postid']."', ";
    }

    $listID=substr($listID, 0,strlen($listID)-2);

    $loadPost=Post::get(array(
        'where'=>"where post_type='normal' AND postid IN ($listID)"
        ));   

    for($i=0;$i<$total;$i++)
    {
        for($j=0;$j<$total;$j++)
        {
            if($loadPost[$i]['postid']==$loadData[$j]['postid'])
            {
                $loadPost[$i]['totalID']=$loadData[$j]['totalID'];
            }
        }
    }

    if($total > 0)
    {
        for($i=0;$i<$total;$i++)
        {

            $li.='
                    <!-- tr -->
                    <tr>
                    <td class="col-lg-9">'.$loadData[$i]['title'].'</td>
                    <td class="col-lg-3 text-right">'.$loadData[$i]['totalID'].'</td>
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
                    <td colspan="2">There are not have any comment.</td>
                    </tr>
                    <!-- tr -->

        ';
    }

    Cache::saveKey('topComments',$li);
    
    return $li;
}

function topViews($limitShow=10)
{
    if($loadData=Cache::loadKey('topViews',300))
    {
        return $loadData;
    }

    $li='';

    $loadData=Post::get(array(
        'limitShow'=>$limitShow,
        'orderby'=>'order by views desc',
        'where'=>"where  post_type='normal'"
        ));

    // echo Database::$error;

    $total=count($loadData);

    if($total > 0)
    {
        for($i=0;$i<$total;$i++)
        {

            $li.='
                    <!-- tr -->
                    <tr>
                    <td class="col-lg-9">'.$loadData[$i]['title'].'</td>
                    <td class="col-lg-3 text-right">'.$loadData[$i]['views'].'</td>
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
                    <td colspan="2">There are not have any post.</td>
                    </tr>
                    <!-- tr -->

        ';
    }

    Cache::saveKey('topViews',$li);
    
    return $li;
}


?>