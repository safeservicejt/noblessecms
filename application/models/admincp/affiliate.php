<?php

function listAffiliate($curPage)
{
    $loadData=Users::get(array(
            'limitShow'=>20,
            'limitPage'=>$curPage,
            'orderby'=>"order by date_added desc"
            ));

    $total=count($loadData);

    $listID='';

    for($i=0;$i<$total;$i++)
    {
        $listID.="'".$loadData[$i]['nodeid']."', ";
    }

    $listID=substr($listID, 0,strlen($listID)-2);

    $loadAff=Affiliate::get(array(
        'where'=>"where userid IN ($listID)"
        ));

    $totalAff=count($loadAff);

    for($i=0;$i<$total;$i++)
    {
        for($j=0;$j<$totalAff;$j++)
        {
            if($loadData[$i]['userid']==$loadAff[$j]['userid'])
            {
                $loadData[$i]['earned']=$loadAff[$j]['earned'];
                $loadData[$i]['earnedFormat']=$loadAff[$j]['earnedFormat'];

                $loadData[$i]['commission']=$loadAff[$j]['commission'];

                continue;
            }
        }
    }

    return $loadData;
}

function lastCommision($limitShow=10)
{
    if($loadData=Cache::loadKey('statslastCommision',300))
    {
        return $loadData;
    }

    $li='';



    $loadData=Affiliate::get(array(
        'limitShow'=>$limitShow,
        'orderby'=>'order by commission desc'
        ));

    $total=count($loadData);

    if(!isset($loadData[0]['userNodeid']))
    {
        return '';
    }

    $listID='';

    for($i=0;$i<$total;$i++)
    {
        $listID.="'".$loadData[$i]['userid']."', ";
    }

    $listID=substr($listID, 0,strlen($listID)-2);

    $loadUser=Users::get(array(
        'where'=>"where userid IN ($listID)"
        ));

    for($i=0;$i<$total;$i++)
    {
        for($j=0;$j<$total;$j++)
        {
            if($loadUser[$i]['userid']==$loadData[$j]['userid'])
            {
                $loadUser[$i]['earned']=$loadData[$j]['earned'];

                $loadUser[$i]['earnedFormat']=$loadData[$j]['earnedFormat'];

                $loadUser[$i]['commission']=$loadData[$j]['commission'];
            }
        }
    }

    // $totalUser=count();


    // $loadData=Affiliate::get(array(
    //     'limitShow'=>$limitShow,
    //     'query'=>"select a.userid,u.firstname,u.lastname,a.earned,a.commission from affiliate a, users u where a.userid=u.userid order by a.commission desc"
    //     ));

    // $total=count($loadUser);

    if(isset($loadUser[0]['userid']))
    {
        for($i=0;$i<$total;$i++)
        {

            $li.='
                    <!-- tr -->
                    <tr>
                    <td>'.ucfirst($loadUser[$i]['firstname']).' '.ucfirst($loadUser[$i]['lastname']).'</td>
                    <td class="text-right">'.$loadUser[$i]['commission'].' %</td>
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
                    <td colspan="2">There are not have any affiliate.</td>
                    </tr>
                    <!-- tr -->

        ';
    }

    Cache::saveKey('statslastCommision',$li);    

    return $li;
}
function lastEarned($limitShow=10)
{
    if($loadData=Cache::loadKey('lastEarned',300))
    {
        return $loadData;
    }

    $li='';

    $loadData=Affiliate::get(array(
        'limitShow'=>$limitShow,
        'orderby'=>'order by earned desc'
        ));

    // print_r($loadData);die();

    $total=count($loadData);

    if(!isset($loadData[0]['userNodeid']))
    {
        return '';
    }

    $listID='';

    for($i=0;$i<$total;$i++)
    {
        $listID.="'".$loadData[$i]['userid']."', ";
    }

    $listID=substr($listID, 0,strlen($listID)-2);

    $loadUser=Users::get(array(
        'where'=>"where userid IN ($listID)"
        ));

    // print_r($loadUser);die();

    for($i=0;$i<$total;$i++)
    {
        for($j=0;$j<$total;$j++)
        {
            if($loadUser[$i]['userid']==$loadData[$j]['userid'])
            {
                $loadUser[$i]['earned']=$loadData[$j]['earned'];

                $loadUser[$i]['earnedFormat']=$loadData[$j]['earnedFormat'];

                $loadUser[$i]['commission']=$loadData[$j]['commission'];
            }
        }
    }

     // print_r($loadUser);die();   
    // $loadData=Affiliate::get(array(
    //     'limitShow'=>$limitShow,
    //     'query'=>"select a.userid,u.firstname,u.lastname,a.earned,a.commission from affiliate a, users u where a.userid=u.userid order by a.earned desc"
    //     ));

    // $total=count($loadData);

    if(isset($loadUser[0]['firstname']))
    {
        for($i=0;$i<$total;$i++)
        {

            $li.='
                    <!-- tr -->
                    <tr>
                    <td>'.ucfirst($loadUser[$i]['firstname']).' '.ucfirst($loadUser[$i]['lastname']).'</td>
                    <td class="text-right">'.$loadUser[$i]['earnedFormat'].'</td>
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
                    <td colspan="2">There are not have any earned.</td>
                    </tr>
                    <!-- tr -->

        ';
    }

    Cache::saveKey('lastEarned',$li);
    
    return $li;
}

?>