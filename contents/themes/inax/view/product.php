<?php echo $content_top;?>

                          <!-- Left Right -->
                        <div class="row rowCenter">

                            <!-- Left -->
                            <div class="col-lg-3 divLeft">
                            <?php echo $content_left;?>

                            <?php echo $categories;?>

                              <?php echo $lastest;?>



                            <!-- Banner -->
                              <div class="row rowLeft bg-non">
                              <!-- Title -->
                                <div class="col-lg-12 padding-non">
                                <a href="fgfg"><img src="<?php echo THEME_URL;?>images/adsleft.jpg" class="img-responsive" /></a>
                                </div>

                              </div>

                            </div>
                            <!-- Right -->
                            <div class="col-lg-9 rowRight">
                            <?php echo $content_right;?>

                            <!-- product content -->
                            <div class="row prodInfo">
                              <div class="col-lg-12 colTitle"><h4>
                              <?php if(!isset($product['title']))echo 'Sản phẩm này không tồn tại'; else{echo $product['title'];}?></h4>
                              </div>

                              <?php if(isset($product['title'])){ ;?>

                              <!-- prod  -->
                              <div class="row rowContent">
                                <!-- left -->
                                <div class="col-lg-5">
                                  <div class="row">
                                    <div class="col-lg-12">
                                    <img src="<?php echo $product['image'];?>" class="img-responsive" />
                                    </div>
                                  </div>
                                </div>
                                <!-- left -->
                                <!-- right -->
                                <div class="col-lg-7">
                                  <h4><a href="<?php echo $product['url'];?>"><?php echo $product['title'];?></a></h4>

                                  <p><span>Model: <?php echo $product['model'];?></span></p>
                                  <p><span>Availability: In Stock</span></p>
                                  <p><span>Price: <span class="prodPrice"><?php echo $product['priceFormat'];?></span></span></p>
                                  <p>
                                  <button type="button" id="addToCart" data-productid="<?php echo $product['productid'];?>"  class="btn btn-primary btn-xs"><?php echo Lang::get('frontend/cart.btnAddtoCart') ;?></button>
                                  </p>

                                </div>
                                <!-- right -->


                              </div>

                              <!-- description -->
                              <div class="row rowDescription">
                                <div class="col-lg-12">
                                <p>
                                <?php echo $product['content'];?>
                                </p>
                                </div>  
                              </div>
                              <!-- description -->



                              <!-- prod -->



                              <?php } ?>

                            </div>
                            <!-- product content -->


                            <?php if(Session::has('userid')){ ;?>
                              <!-- review -->
                              <div class="row rowReview">
                                <div class="col-lg-12 colTitle"><h4>Viết nhận xét</h4></div>

                                <?php echo $reviewAlert;?>

                                 <div class="col-lg-12 colContent">
                                 <p>
                                   <form action="" method="post" enctype="multipart/form-data">
                                   <p>
                                   <label><strong>Nội dung nhận xét:</strong></label>
                                   <textarea rows="8" class="form-control" name="review[content]" placeholder="Nội dung nhận xét"></textarea>
                                   </p>

                                   <button type="submit" name="btnReview" class="btn btn-primary">Gửi</button>
                                   </form>
                                 </p>
                                 </div>

                              </div>

                              <!-- review -->
                              <?php } ?>

                              <?php echo $listReviews;?>

                                
                                             
                            </div>


                        </div>

                        <!-- End Left Right -->


                        

                        <?php echo $content_bottom;?>

