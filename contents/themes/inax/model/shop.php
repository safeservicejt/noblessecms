<?php

function listPage()
{
  $curPage=0;

  if($matches=Uri::match('shop\/page\/(\d+)'))
  {
    $curPage=$matches[1];
  }

  $listPage=Misc::genPage('shop',$curPage); 

  return $listPage;

}

function categories()
{
  $loadData=Categories::get(array(
    'orderby'=>'order by cattitle asc'
    ));

  return $loadData;
}


function listfeatured()
{
  $loadData=Products::get(array(
    'limitShow'=>4,
    'limitPage'=>0,
    'where'=>"where is_featured='1'"
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

function lastest()
{
  $curPage=0;

  if($matches=Uri::match('shop\/page\/(\d+)'))
  {
    $curPage=$matches[1];
  }


	$loadData=Products::get(array(
		'limitShow'=>24,
		'limitPage'=>$curPage
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