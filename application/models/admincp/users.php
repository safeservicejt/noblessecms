<?php



function actionProcess()
{
	$action=Request::get('action');

	$id=Request::get('id');

	if((int)$id <= 0)
	{
		return false;
	}

	$listID="'".implode("','",$id)."'";

	switch ($action) {
		case 'delete':
			Users::update($id,array(
				'status'=>0
				),"userid IN ($listID)");
			break;
		case 'approved':
			Users::update($id,array(
				'status'=>1
				),"userid IN ($listID)");
			break;
		case 'unapproved':
			Users::update($id,array(
				'status'=>0
				),"userid IN ($listID)");
			break;
		case 'isadmin':
			Users::update($id,array(
				'is_admin'=>1,
				),"userid IN ($listID)");
			break;
		case 'notadmin':
			Users::update($id,array(
				'is_admin'=>0
				),"userid IN ($listID)");
			break;
		
	}
}

function getApi()
{
	$loadMethod=Uri::getNext('statsUser');

	if($loadMethod == 'statsUser')
	{
		echo '';

		die();
	}


	$loadData='';

	switch ($loadMethod) {
		case 'week':
			$loadData=user_statsWeek();
			break;
		case 'month':
			$loadData=user_statsMonth();
			break;
		

	}

	echo $loadData;die();	
}
function user_statsWeek()
{

	$dateDB=array();

	$listDay='';

	$listValue='';


	$loadUser=Users::get(array(
		'limitShow'=>7,
		'orderby'=>"group by date_added order by date_added asc",
		'selectFields'=>"count(nodeid) as numid,date_added"
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
		'selectFields'=>"count(nodeid) as numid,date_added"
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