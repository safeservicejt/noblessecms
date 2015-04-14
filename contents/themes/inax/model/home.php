<?php


function listfeatured()
{
  $loadData=Products::get(array(
    'limitShow'=>8,
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
                                                <a href="fgfg" class="text-prod"><h4>'.$loadData[$i]['title'].'</h4></a>
                                  
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

                        <!-- Prod -->
                        <div class="row rowProducts ">
                            <div class="col-lg-12 colTitle">
                              <h4>Nổi bật</h4>
                            </div>
                            <div class="col-lg-12 colListProd">
                              <div class="row">

                              '.$li.'

                              </div>
                            </div>

                        </div>
  ';
  return $theList;  
}


?>