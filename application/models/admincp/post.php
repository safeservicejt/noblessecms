<?php


function lastComments($limitShow=10)
{
    if($loadData=Cache::loadKey('lastComments',300))
    {
        return $loadData;
    }

    $li='';

    $loadData=Post::get(array(
        'query'=>"select p.*,c.* from post p, comments c where p.post_type='normal' AND p.status='1' AND p.postid=c.postid order by c.date_added desc limit 0,$limitShow"
        ));   

    $total=count($loadData);

    if($total > 0)
    {
        for($i=0;$i<$total;$i++)
        {

            $li.='
                    <!-- tr -->
                    <tr>
                    <td class="col-lg-3">'.$loadData[$i]['date_added'].'</td>
                    <td class="col-lg-3">'.$loadData[$i]['fullname'].'</td>
                    <td class="col-lg-6">'.$loadData[$i]['title'].'</td>
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
    
    $loadData=Post::get(array(
        'query'=>"select p.title,count(c.postid)as totalID from post p,comments c where p.status='1' AND p.post_type='normal' AND p.postid=c.postid group by c.postid order by count(c.postid) desc limit 0,$limitShow"
        ));   

    $total=count($loadData);
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
        'where'=>"where  post_type='normal' AND status='1'"
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