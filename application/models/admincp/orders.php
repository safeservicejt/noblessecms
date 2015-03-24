<?php

function approveProcess($orderid)
{


    $loadData=Orders::get(array(
        'where'=>"where orderid='$orderid'"
        ));

    if(!isset($loadData[0]['orderid']))
    {
        return false;
    }

    if($loadData[0]['order_status']=='approved')
    {
        return false;
    }

    $affiliateID=$loadData[0]['affiliate_id'];

    $commission=$loadData[0]['commission'];

    if((int)$affiliateID==0 || (double)$commission==0)
    {
        return false;
    }

    $total=(double)$loadData[0]['total'];

    $atotal=(double)$total/(double)$commission;

    $updateData=array('order_status'=>'approved');

    Orders::update($orderid,$updateData);

    $aData=Affiliate::get(array(
        'where'=>"where userid='$affiliateID'"
        ));

    if(!isset($aData[0]['userid']))
    {
        return false;
    }

    $earned=$aData[0]['earned'];

    $earned=(double)$earned+(double)$atotal;

    Affiliate::update($affiliateID,array('earned'=>$earned));

}

function lastOrders($limitShow=10)
{
    if($loadData=Cache::loadKey('statsLastOrders',300))
    {
        return $loadData;
    }

    $li='';

    $loadData=Orders::get(array(
        'limitShow'=>$limitShow
        ));

    $total=count($loadData);

    if(isset($loadData[0]['total_products']))
    {
        for($i=0;$i<$total;$i++)
        {

            $li.='
                    <!-- tr -->
                    <tr>
                    <td>'.$loadData[$i]['date_added'].'</td>
                    <td>'.$loadData[$i]['total_products'].'</td>
                    <td>'.$loadData[$i]['totalFormat'].'</td>
                    <td>'.ucfirst($loadData[$i]['order_status']).'</td>
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
                    <td colspan="4">There are not have any order.</td>
                    </tr>
                    <!-- tr -->

        ';
    }

    Cache::saveKey('statsLastOrders',$li);


    return $li;
}

?>