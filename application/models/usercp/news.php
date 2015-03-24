<?php

function statsWeek()
{


	$dateDB=array();

	$listDay='';

	$listValue='';


	$loadUser=Post::get(array(
		'limitShow'=>7,
		'orderby'=>"group by date_added order by date_added asc",
		'selectFields'=>"count(postid) as numid,date_added"
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
                            <canvas id="post_canvas" ></canvas>
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

                            var ctx = document.getElementById("post_canvas").getContext("2d");
                            window.myLine = new Chart(ctx).Line(lineChartData, {
                                responsive: true
                            });                      	
                        });


                        </script>  

	';


	return $result;
}

function statsMonth()
{

	$dateDB=array();

	$listDay='';

	$listValue='';


	$loadUser=Post::get(array(
		'limitShow'=>30,
		'orderby'=>"group by date_added order by date_added asc",
		'selectFields'=>"count(postid) as numid,date_added"
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
                            <canvas id="post_canvas" ></canvas>
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

                            var ctx = document.getElementById("post_canvas").getContext("2d");
                            window.myLine = new Chart(ctx).Line(lineChartData, {
                                responsive: true
                            });                      	
                        });

                        </script>  

	';


	return $result;
}
function canEditPost()
{
	$id=Uri::getNext('edit');

	$userid=Session::get('userid');

	if(UserGroups::enable('can_editall_post')==false){

		$query=Database::query("select postid from post where postid='$id' AND userid='$userid'");

		$totalOut=Database::num_rows($query);

		$row=Database::fetch_assoc($query);

		if((int)$totalOut == 0 || (int)$row['postid'] != (int)$id)
		{
			return false;
		}

		return true;
		
	}	

	return true;
}
function removeNews($post=array())
{

	if(UserGroups::enable('can_delete_post')==false){
		$listID="'".implode("','",$post)."'";

		$totalIn=count($post);

		$userid=Session::get('userid');

		$query=Database::query("select postid from post where userid='$userid' AND postid in ($listID)");

		$totalOut=Database::num_rows($query);

		if((int)$totalOut != $totalIn)
		{
			Alert::make('Page not found');			
		}
	}

	Post::remove($post);
}


?>