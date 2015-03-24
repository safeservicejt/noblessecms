<?php

function orderDetails($order)
{
	$downloadList=array();

	$orderid=$order['orders']['orderid'];

	$totalProd=count($order['products']);

		// print_r(count($order));die();

	if($totalProd > 0)
	{
		$listProdID='';

		for($i=0;$i<$totalProd;$i++)
		{
			$listProdID.="'".$order['products'][$i]['productid']."',";
		}

		$listProdID=substr($listProdID, 0, strlen($listProdID)-1);

		// print_r($listProdID);die();

		$query=Database::query("select d.title,d.remaining,d.filename,d.downloadid,op.downloads from products_downloads pd, downloads d,orders_products op where d.downloadid=pd.downloadid AND pd.productid IN ($listProdID) AND pd.productid=op.productid");

		$loadData=array();

		while($row=Database::fetch_assoc($query))
		{
			$row['downloads']=json_decode($row['downloads'],true);

			$row['orderid']=$orderid;

			sort($row['downloads']);

			if((int)$row['downloads'][0]['remaining']==0 && (int)$row['downloads'][0]['downloaded']==0)
			{
				$row['downloads'][0]['remaining']=$row['remaining'];
			}

			$row['url']=Url::download($row);

			$loadData[]=$row;
		}



		$order['downloads']=$loadData;		
	}

	// print_r($loadData);die();


	return $order;
}

?>