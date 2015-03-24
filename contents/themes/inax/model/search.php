<?php

function listPage()
{
	$curPage=0;

	$keywords='';

	if($matches=Uri::match('search\/keyword\/(.*?)\/page\/(\d+)'))
	{
		$curPage=$matches[2];

		$keywords=$matches[1];
	}
	else
	{
		$keywords=base64_encode(Request::get('txtKeywords'));
	}

	$listPage=Misc::genPage('search/keyword/'.$keywords,$curPage);	

	return $listPage;

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

function searchResult()
{
  $curPage=0;

  $keywords='';

  if($matches=Uri::match('search\/keyword\/(.*?)\/page\/(\d+)'))
  {
    $curPage=$matches[2];

    $keywords=base64_decode($matches[1]);
  }
  else
  {
  	$keywords=Request::get('txtKeywords','');
  }


	$loadData=Products::get(array(
		'limitShow'=>24,
		'limitPage'=>$curPage,
		'where'=>"where title LIKE '%$keywords%'"
		));


	$li='';

	$total=count($loadData);

  // print_r($loadData);die();

	// Alert::make($total);
  if(isset($loadData[0]['productid']))
	for($i=0;$i<$total;$i++)
	{

		$li.='
                              <!-- Prod Info -->
                                  <div class="col-lg-3 col-md-3">
                                      <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-5 col-xs-6 divProdThumbnail">
                                        <a href="'.$loadData[$i]['url'].'"><img src="'.$loadData[$i]['image'].'" class="img-responsive" /></a>

                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-5 col-xs-6 visible-md visible-lg">
                                          <div class="row">
                                              <div class="col-lg-12">
                                                <a href="'.$loadData[$i]['url'].'" class="text-prod"><h4>'.$loadData[$i]['title'].'</h4></a>
                                  
                                                 <span class="prodPrice">'.$loadData[$i]['priceFormat'].'</span>
                                                
                                                 <p><img src="'.THEME_URL.'images/stars-4.png" /></p>

                                                      <button type="button" id="addToCart" data-productid="'.$loadData[$i]['productid'].'"  class="btn btn-primary">'.Lang::get('frontend/cart.btnAddtoCart').'</button>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-7 col-xs-6 text-right hidden-md hidden-lg">
                                          <div class="row">
                                              <div class="col-lg-12">
                                                <a href="'.$loadData[$i]['url'].'" class="text-prod"><h4>'.$loadData[$i]['title'].'</h4></a>
                                  
                                                 <span class="prodPrice">'.$loadData[$i]['priceFormat'].'</span>
                                                
                                                 <p><img src="'.THEME_URL.'images/stars-4.png" /></p>

                                                      <button type="button" id="addToCart" data-productid="'.$loadData[$i]['productid'].'"  class="btn btn-primary">'.Lang::get('frontend/cart.btnAddtoCart').'</button>
                                              </div>
                                          </div>
                                        </div>



                                      </div>

                                  </div>
                                  <!-- End -->

		';
	}
  else
  {
    return '';
  }

	$theList='

                            <!-- Lastest -->
                                <div class="row">

                                  <div class="col-lg-12 colTitle bg-brown">
                                  <h4>Hàng mới</h4>
                                  </div>

                                  <div class="col-lg-12 colListProd bg-white">

                                      '.$li.'

                                  </div>
                                </div>

                                <!-- End lastest -->
	';
	return $theList;
}
?>