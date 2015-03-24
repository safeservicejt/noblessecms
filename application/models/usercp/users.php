<?php

function requestPaymentProcess($userid)
{
	$valid=Validator::make(array(
		'send.comments'=>'min:10|slashes'
		));

	if(!$valid)
	{
		return false;
	}

	$loadData=Affiliate::get(array(
		'where'=>"where userid='$userid'"
		));

	if(!isset($loadData[0]['userid']) || (double)$loadData[0]['earned']==0)
	{
		return false;
	}

	$earned=Currency::insertPrice($loadData[0]['earned']);

	$comments=Request::get('send.comments');

	$post=array(
		'userid'=>$userid,
		'total_request'=>$earned,
		'comments'=>$comments
		);

	if(!$id=Requestpayment::insert($post))
	{
		return false;
	}

	Affiliate::update($userid,array(
		'earned'=>'0'
		));

	return true;
}

function user_statsWeek()
{

	$dateDB=array();

	$listDay='';

	$listValue='';


	$loadUser=Users::get(array(
		'limitShow'=>7,
		'orderby'=>"group by date_added order by date_added asc",
		'selectFields'=>"count(userid) as numid,date_added"
		));

	if(!isset($loadUser[0]['numid']))
	{
		return '';
	}

	$totalUser=count($loadUser);

	for($i=0;$i<$totalUser;$i++)
	{
		$formatDate=date("M d",strtotime($loadUser[$i]['date_added']));

		$dateDB[$formatDate]=$loadUser[$i]['numid'];		
	}


	$keyNames=array_keys($dateDB);

	$listDay='"'.implode('","', $keyNames).'"';

	$keyValues=array_values($dateDB);

	$listValue=implode(',', $keyValues);


	$result='

                        <div>
                            <canvas id="user_canvas" ></canvas>
                        </div>
                         <script>
                            var lineChartData = {
                                labels : ['.$listDay.'],
                                datasets : [
                                    {
                                        label: "Stats",
                                        fillColor : "rgba(151,187,205,0.2)",
                                        strokeColor : "rgba(151,187,205,1)",
                                        pointColor : "rgba(151,187,205,1)",
                                        pointStrokeColor : "#fff",
                                        pointHighlightFill : "#fff",
                                        pointHighlightStroke : "rgba(151,187,205,1)",
                                        data : ['.$listValue.']
                                    }
                                ]

                            }


                        $(document).ready(function(){

                             var ctx = document.getElementById("user_canvas").getContext("2d");
                            window.myLine = new Chart(ctx).Line(lineChartData, {
                                responsive: true
                            });                       	
                        });


                        </script>  

	';


	return $result;
}

function user_statsMonth()
{

	$dateDB=array();

	$listDay='';

	$listValue='';


	$loadUser=Users::get(array(
		'limitShow'=>30,
		'orderby'=>"group by date_added order by date_added asc",
		'selectFields'=>"count(userid) as numid,date_added"
		));

	if(!isset($loadUser[0]['numid']))
	{
		return '';
	}

	$totalUser=count($loadUser);

	for($i=0;$i<$totalUser;$i++)
	{
		$formatDate=date("M d",strtotime($loadUser[$i]['date_added']));

		$dateDB[$formatDate]=$loadUser[$i]['numid'];		
	}


	$keyNames=array_keys($dateDB);

	$listDay='"'.implode('","', $keyNames).'"';

	$keyValues=array_values($dateDB);

	$listValue=implode(',', $keyValues);


	$result='

                        <div>
                            <canvas id="user_canvas" ></canvas>
                        </div>
                         <script>
                            var lineChartData = {
                                labels : ['.$listDay.'],
                                datasets : [
                                    {
                                        label: "Stats",
                                        fillColor : "rgba(151,187,205,0.2)",
                                        strokeColor : "rgba(151,187,205,1)",
                                        pointColor : "rgba(151,187,205,1)",
                                        pointStrokeColor : "#fff",
                                        pointHighlightFill : "#fff",
                                        pointHighlightStroke : "rgba(151,187,205,1)",
                                        data : ['.$listValue.']
                                    }
                                ]

                            }

                        $(document).ready(function(){

                             var ctx = document.getElementById("user_canvas").getContext("2d");
                            window.myLine = new Chart(ctx).Line(lineChartData, {
                                responsive: true
                            });                       	
                        });



                        </script>  

	';


	return $result;
}


?>