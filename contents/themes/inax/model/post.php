<?php

function listComments()
{
    $resultData='';

    $matches=Uri::match('^post\/(\d+)\-');

    $id=$matches[1];    

    $loadData=Comments::get(array(
      'limitShow'=>100,
      'where'=>"where status='1'"
      ));

    if(!isset($loadData[0]['commentid']))
    {
      return '';
    }

    $total=count($loadData);
    $li='';

    for($i=0;$i<$total;$i++)
    {

      $li.='
            <!-- review -->
              <div class="row theReview">
                  <div class="col-lg-12">
                  <strong class="reviewFullName">'.ucfirst($loadData[$i]['fullname']).' ('.Render::dateFormat($loadData[$i]['date_added']).'): </strong>
                  <span>'.$loadData[$i]['content'].'</span>
                  </div>
              </div>
            <!-- review -->
      ';
    }

    $resultData='

                <!-- list reviews -->
                <div class="row rowListReview">
                  <div class="col-lg-12 colTitle">
                  <h4>Bình luận</h4>
                  </div>
                 <div class="col-lg-12 colContent">
                 '.$li.'
                  </div>

                </div>

               <!-- list reviews -->

    ';

    return $resultData;
}
function sendComment()
{
  $alert='';
  if(Request::has('btnComment'))
  {
      $valid=Validator::make(array(
        'comment.content'=>'min:10|slashes',
        'comment.fullname'=>'min:3|slashes',
        'comment.email'=>'min:10|email|slashes'
        ));

      if($valid)
      {
          $send=Request::get('comment');

          $matches=Uri::match('^post\/(\d+)\-');

          $send['postid']=$matches[1];

          if(!$id=Comments::insert($send))
          {
            $alert='<div class="alert alert-warning">Có lỗi xảy ra. Vui lòng kiểm tra lại thông tin</div>';
          }
          else
          {
            
            $alert='<div class="alert alert-success">Gửi bình luận thành công, chúng tôi sẽ kiểm duyệt sớm nhất có thể !</div>';
          }
      }
      else
      {
        $alert='<div class="alert alert-warning">Có lỗi xảy ra. Vui lòng kiểm tra lại thông tin</div>';
      }

      return $alert;
  }
}
function postProcess($inputData=array())
{
	$matches=Uri::match('^post\/(\d+)\-(.*?)\.html');

	$id=$matches[1];

	$friendly_url=$matches[2];

	$loadData=Post::get(array(
		'where'=>"where postid='$id' AND friendly_url='$friendly_url' AND status='1'"
		));

	if(!isset($loadData[0]['postid']))
	{
		Alert::make('Page not found');
	}

	$inputData['title']=$loadData[0]['title'];

	$inputData['content']=$loadData[0]['content'];

	$inputData['image']=$loadData[0]['image'];

	$inputData['views']=$loadData[0]['views'];

	$inputData['date_added']=Render::dateFormat($loadData[0]['date_added']);

	$inputData['keywords']=$loadData[0]['keywords'];
	
	$inputData['friendly_url']=$loadData[0]['friendly_url'];

	$inputData['is_featured']=$loadData[0]['is_featured'];


	return $inputData;
}


function categories()
{

	  $loadData=Categories::get(array(
	    'orderby'=>'order by cattitle asc'
	    ));  	

  // print_r($loadData);die();

  $total=count($loadData);

  $li='';

  if(isset($loadData[0]['catid']))
  	for($i=0;$i<$total;$i++)
  	{
  		$li.='<li><a href="'.$loadData[$i]['url'].'">'.$loadData[$i]['cattitle'].'</a></li>';
  	}
  	else
  	{
  		$li='';
  	}



  return '

                            <!-- List categories -->
                              <div class="row rowLeft">
                              <!-- Title -->
                                <div class="col-lg-12 colTitle">
                                <h4>Danh mục</h4>
                                </div>
                              <!-- Menu -->
                                <div class="col-lg-12 colCategories">
                                    <ul class="leftCategories">
                                    '.$li.'
                                    </ul>
                                </div>

                              </div>


  ';
}

?>