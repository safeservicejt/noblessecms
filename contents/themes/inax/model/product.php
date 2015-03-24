<?php

function listReviews()
{
    $resultData='';

    $matches=Uri::match('^product\/(\d+)\/');

    $id=$matches[1];    

    $loadData=Reviews::get(array(
      'limitShow'=>100,
      'query'=>"select u.firstname,u.lastname,r.date_added,r.reviewid,r.review_content from users u, reviews r where u.userid=r.userid AND r.productid='$id' AND r.status='approved' order by r.reviewid desc"
      ));

    if(!isset($loadData[0]['reviewid']))
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
                  <strong class="reviewFullName">'.ucfirst($loadData[$i]['firstname']).' '.ucfirst($loadData[$i]['lastname']).' ('.Render::dateFormat($loadData[$i]['date_added']).'): </strong>
                  <span>'.$loadData[$i]['review_content'].'</span>
                  </div>
              </div>
            <!-- review -->
      ';
    }

    $resultData='

                <!-- list reviews -->
                <div class="row rowListReview">
                  <div class="col-lg-12 colTitle">
                  <h4>Nhận xét</h4>
                  </div>
                 <div class="col-lg-12 colContent">
                 '.$li.'
                  </div>

                </div>

               <!-- list reviews -->

    ';

    return $resultData;
}
function sendReview()
{
  $alert='';
  if(Request::has('btnReview'))
  {
      $valid=Validator::make(array(
        'review.content'=>'min:10|slashes'
        ));

      if($valid)
      {
          $send=Request::get('review');

          $send['review_content']=$send['content'];

          unset($send['content']);

          $send['userid']=Session::get('userid');

          $matches=Uri::match('^product\/(\d+)\/');

          $send['productid']=$matches[1];

          if(!$id=Reviews::insert($send))
          {
            $alert='<div class="alert alert-warning">Có lỗi xảy ra. Vui lòng kiểm tra lại thông tin</div>';
          }
          else
          {
            
            $alert='<div class="alert alert-success">Gửi nhận xét thành công, chúng tôi sẽ kiểm duyệt sớm nhất có thể !</div>';
          }
      }
      else
      {
        $alert='<div class="alert alert-warning">Có lỗi xảy ra. Vui lòng kiểm tra lại thông tin</div>';
      }

      return $alert;
  }
}

function prodProcess()
{
  $matches=Uri::match('^product\/(\d+)\/(.*?)\.html');

  $id=$matches[1];

  $friendly_url=$matches[2];

  $loadData=Products::get(array(
    'where'=>"where productid='$id' AND friendly_url='$friendly_url' AND status='1'"
    ));

  if(!isset($loadData[0]['productid']))
  {
    return '';
  }

  return $loadData[0];
}


function categories()
{
  $matches=Uri::match('category\/(\d+)\/?');

  $id=$matches[1];

  $loadData=Categories::get(array(
    'where'=>"where parentid='$id'",
    'orderby'=>'order by cattitle asc'
    ));

  if(!isset($loadData[0]['catid']))
  {
    $loadData=Categories::get(array(
      'orderby'=>'order by cattitle asc'
      ));   
  }

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



function lastest()
{
  $loadData=Products::get(array(
    'limitShow'=>4,
    'limitPage'=>0
    ));
  $li='';

  $total=count($loadData);

  // print_r($loadData);die();

  // Alert::make($total);

  if(isset($loadData[0]['productid']))
  for($i=0;$i<$total;$i++)
  {

    $li.='

                                    <!-- Prod -->
                                  <div class="row">
                                      <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6 divProdThumbnail">
                                        <a href="'.$loadData[$i]['url'].'"><img src="'.$loadData[$i]['image'].'" class="img-responsive" /></a>

                   
                                      </div>
                                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 text-right">
                                        <a href="'.$loadData[$i]['url'].'" class="text-prod">'.$loadData[$i]['title'].'</a>
                                        <br>
                                        <img src="'.THEME_URL.'images/stars-4.png" />
                                        <br>
                                      <span class="prodPrice"><small>'.$loadData[$i]['priceFormat'].'</small></span>
                                        <br>
                                        <button type="button" id="addToCart" data-productid="'.$loadData[$i]['productid'].'"  class="btn btn-primary">'.Lang::get('frontend/cart.btnAddtoCart').'</button>

                                      </div>

                                  </div>
                                  <!-- End Prod -->


    ';
  }
  else
  {
    return '';
  }



  $theList='

                            <!-- List Specials -->
                              <div class="row rowLeft">
                              <!-- Title -->
                                <div class="col-lg-12 colTitle bg-brown">
                                <h4>Nổi bật</h4>
                                </div>
                              <!-- Menu -->
                                <div class="col-lg-12 colSpecials">
                                '.$li.'
                                    
                                </div>

                              </div>
  ';
  return $theList;  
}
?>