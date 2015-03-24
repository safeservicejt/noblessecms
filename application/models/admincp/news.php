<?php

function editInfo($id)
{
	$resultData=array();

	$postData=Post::get(array(
		'where'=>"where postid='$id' AND post_type='normal'",
		'isHook'=>'no'
		));	

	$loadCat=Categories::get(array(
		'where'=>"where catid='".$postData[0]['catid']."'"
		));

	$loadPage=Pages::get(array(
		'where'=>"where pageid='".$postData[0]['pageid']."'"
		));


	if(isset($loadCat[0]['cattitle']))
	$postData[0]['cattitle']=$loadCat[0]['cattitle'];

	if(isset($loadPage[0]['title']))
	$postData[0]['pagetitle']=$loadPage[0]['title'];

	$resultData['data']=$postData[0];

	$listTags=PostTags::render(array(
		'where'=>"where postid='$id'"
		));	

	$resultData['tags']=$listTags;



	return $resultData;
}

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
		
			if(UserGroups::enable('can_delete_post')==false){
				Alert::make('Page not found');
			}



			Post::remove($id);
			break;

		case 'publish':
			Post::update($listID,array(
				'status'=>1
				),"postid IN ($listID)");
			break;
		case 'unpublish':
			Post::update($listID,array(
				'status'=>0
				),"postid IN ($listID)");
			break;
		case 'setFeatured':
			Post::update($listID,array(
				'is_featured'=>1,
				'date_featured'=>date('Y-m-d h:i:s')
				),"postid IN ($listID)");
			break;
		case 'unsetFeatured':
			Post::update($listID,array(
				'is_featured'=>0
				),"postid IN ($listID)");
			break;
		
	}
}

function updateProcess($id)
{
	$alert='<div class="alert alert-warning">Error. Edit post error!</div>';

	$valid=Validator::make(array(
		'send.title'=>'min:3|slashes',
		'send.keywords'=>'slashes',
		'tags'=>'slashes',
		'catid'=>'slashes',
		'pageid'=>'slashes',
		'send.preview_url'=>'slashes',
		'uploadIMGMethod'=>'slashes',
		'urlThumbnail'=>'slashes'
		));

	if(!$valid)
	{
		return $alert;
	}

	// print_r(Request::get('tags'));die();

	$uploadIMGMethod=Request::get('uploadIMGMethod');

	$uploadFileMethod=Request::get('uploadFileMethod');

	$data=Request::get('send');

	$data['catid']=Request::get('catid','0');
	
	$data['pageid']=Request::get('pageid','0');

	$data['status']=1;

	$data['friendly_url']=Url::makeFriendly($data['title']);

	if(!Post::update($id,$data))
	{
		return $alert;
		
	}

	$alert='<div class="alert alert-warning">Error. Edit post error!</div>';

	$previewImg='';

	$loadData=Post::get(array(
		'where'=>"where postid='$id'"
		));

	switch ($uploadIMGMethod) {
		case 'frompc':

			if(preg_match('/.*?\.\w+/i', $_FILES['pcThumbnail']['name']))
			{
				if(!$previewImg=File::upload('pcThumbnail','uploads/images/'))
				{
					$alert='<div class="alert alert-warning">Error. Upload image error!</div>';

					return $alert;
				}
			}

			break;

		case 'fromurl':

			$imgUrl=Request::get('urlThumbnail','');

			if(isset($imgUrl[4]))
			{
				if(!$previewImg=File::uploadFromUrl($imgUrl,'uploads/images/'))
				{
					$alert='<div class="alert alert-warning">Error. Upload image error!</div>';

					return $alert;
				}				
			}

			break;
	}

	$updateData=array();

	if(isset($previewImg[4]))
	{
		$filePath=ROOT_PATH.$loadData[0]['image'];

		if(file_exists($filePath))
		{
			unlink($filePath);

			$filePath=dirname($filePath);

			rmdir($filePath);
		}

		$updateData['image']=$previewImg;	
		
		Post::update($id,$updateData);			
	}



	PostTags::remove(array($id));

	Post::insertTags($id,Request::get('tags'));	

	$alert='<div class="alert alert-success">Success. Update changes complete!</div>';

	return $alert;
}

function insertProcess()
{
	$alert='<div class="alert alert-warning">Error. Add new post error!</div>';

	$valid=Validator::make(array(
		'send.title'=>'min:3|slashes',
		'send.keywords'=>'slashes',
		'tags'=>'slashes',
		'catid'=>'slashes',
		'send.preview_url'=>'slashes',
		'uploadIMGMethod'=>'slashes',
		'urlThumbnail'=>'slashes'
		));

	if(!$valid)
	{
		return $alert;
	}

	// print_r(Request::get('tags'));die();

	$uploadIMGMethod=Request::get('uploadIMGMethod');

	$uploadFileMethod=Request::get('uploadFileMethod');

	$data=Request::get('send');

	$data['catid']=Request::get('catid','0');

	$data['pageid']=Request::get('pageid','0');

	$data['post_type']='normal';

	$data['status']=1;

	if(Uri::has('usercp\/news'))
	{
		$data['status']=0;		
	}

	if(!$id=Post::insert($data))
	{
		return $alert;
		
	}

	$alert='<div class="alert alert-warning">Error. Add new post error!</div>';

	$previewImg='';

	switch ($uploadIMGMethod) {
		case 'frompc':

			if(preg_match('/.*?\.\w+/i', $_FILES['pcThumbnail']['name']))
			{
				if(!$previewImg=File::upload('pcThumbnail','uploads/images/'))
				{
					$alert='<div class="alert alert-warning">Error. Upload image error!</div>';

					return $alert;
				}				
			}

			break;

		case 'fromurl':

			$imgUrl=Request::get('urlThumbnail','');

			if(isset($imgUrl[4]))
			{
				if(!$previewImg=File::uploadFromUrl($imgUrl,'uploads/images/'))
				{
					$alert='<div class="alert alert-warning">Error. Upload image error!</div>';

					return $alert;
				}				
			}

			break;
	}

	if(isset($previewImg[3]))
	{
		$updateData=array();

		$updateData['image']=$previewImg;

		Post::update($id,$updateData);		
	}


	Post::insertTags($id,Request::get('tags'));	

	$alert='<div class="alert alert-success">Success. Add new post complete!</div>';

	return $alert;
}


function listPostProcess($curPage)
{
	$queryData=array(
			'limitShow'=>20,			
			'limitPage'=>$curPage,
			'isHook'=>'no',
			'where'=>"where post_type='normal'"
			);

	if(Uri::has('usercp\/news'))
	{
		$queryData['where']="where post_type='normal' AND userid='".Session::get('userid')."'";
	}

	$loadPost=Post::get($queryData);	

	$total=count($loadPost);

	$liCat='';

	$liUser='';

	for($i=0;$i<$total;$i++)
	{
		$liCat.="'".$loadPost[$i]['catid']."', ";

		$liUser.="'".$loadPost[$i]['userid']."', ";
	}

	$liCat=substr($liCat, 0,strlen($liCat)-2);

	$liUser=substr($liUser, 0,strlen($liUser)-2);

	$loadCat=Categories::get(array(
		'where'=>"where catid IN ($liCat)"
		));
	
	$totalCat=count($loadCat);

	for($i=0;$i<$totalCat;$i++)
	{
		for($j=0;$j<$total;$j++)
		{
			if($loadCat[$i]['catid']==$loadPost[$j]['catid'])
			{
				$loadPost[$j]['cattitle']=$loadCat[$i]['cattitle'];
				// $loadPost[$j]['catid']=$loadCat[$i]['catid'];

			}
		}
	}


	$loadUser=Users::get(array(
		'where'=>"where userid IN ($liUser)"
		));

	$totalUser=count($loadUser);

	for($i=0;$i<$totalUser;$i++)
	{
		for($j=0;$j<$total;$j++)
		{
			if(isset($loadPost[$j]['userid']) && $loadUser[$i]['userid']==$loadPost[$j]['userid'])
			{
				$loadPost[$j]['firstname']=$loadUser[$i]['firstname'];

				$loadPost[$j]['lastname']=$loadUser[$i]['lastname'];

				// $loadPost[$j]['catid']=$loadCat[$i]['catid'];

			}
		}
	}	



	return $loadPost;
}


function searchProcess($txtKeyword,$fromPage=-1)
{

	$curPage=($fromPage >= 0)?$fromPage:Uri::getNext('news');

	if($curPage=='page' || $fromPage >= 0)
	{
		$curPage=($fromPage >= 0)?$fromPage:Uri::getNext('page');
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
		$resultData['posts']='';

		$resultData['pages']='';

		return $resultData;
	}

	if(preg_match('/^(\w+)\:(.*?)$/i', $txtKeyword,$matches))
	{
		$method=strtolower($matches[1]);

		$keyword=strtolower(trim($matches[2]));

		$method=($method=='postid')?'id':$method;
		$method=($method=='cat')?'category':$method;

		switch ($method) {
			case 'id':
			$resultData['posts']=Post::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where post_type='normal' AND postid='$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'category':
			$resultData['posts']=Post::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where post_type='normal' AND catid='$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'before':
			$resultData['posts']=Post::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where post_type='normal' AND date_added < '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'after':
			$resultData['posts']=Post::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where post_type='normal' AND date_added > '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'on':
			$resultData['posts']=Post::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where post_type='normal' AND date_added = '$keyword'",
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
		$resultData['posts']=Post::get(array(
			'limitShow'=>20,			
			'limitPage'=>$curPage,
			'where'=>"where post_type='normal' AND title LIKE '%$txtKeyword%'",
			'orderby'=>'order by date_added desc',
			'isHook'=>'no'
			));	
	}

	return $resultData;
}

function getApi()
{
	$loadMethod=Uri::getNext('statsPost');

	if($loadMethod == 'statsPost')
	{
		echo '';

		die();
	}


	$loadData='';

	switch ($loadMethod) {
		case 'week':
			$loadData=statsWeek();
			break;
		case 'month':
			$loadData=statsMonth();
			break;
		

	}

	echo $loadData;die();	
}

function statsWeek()
{

	$dateDB=array();

	$listDay='';

	$listValue='';


	$loadUser=Post::get(array(
		'limitShow'=>7,
		'orderby'=>"group by date_added order by date_added asc",
		'selectFields'=>"count(postid) as numid,date_added",
		'where'=>" where post_type='normal'"
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
		'selectFields'=>"count(postid) as numid,date_added",
		'where'=>" where post_type='normal'"
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



?>