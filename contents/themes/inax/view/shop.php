<?php echo $content_top;?>

                        <!-- Slide -->
                        <div class="row rowSlide">
                            <div class="col-lg-12 colSlide">
                              <!-- <ul class="ulSlide">
                              <li><img src="images/s3.jpg" class="img-responsive" /></li>
                              </ul> -->

                             <ul class="bxslider">
                            <li><img src="<?php echo THEME_URL;?>images/s1.jpg" /></li>
                               <li><img src="<?php echo THEME_URL;?>images/s2.jpg" /></li>

                          </ul>                           
                            </div>

                            <script>
                            $(document).ready(function(){
                               $('.bxslider').bxSlider({
                                auto: true
                                  });

                            });
                            </script>

                        </div>

                        
                          <!-- Left Right -->
                        <div class="row rowCenter">

                            <!-- Left -->
                            <div class="col-lg-3 divLeft">
                            <?php echo $content_left;?>

                            <!-- List categories -->
                              <div class="row rowLeft">
                              <!-- Title -->
                                <div class="col-lg-12 colTitle">
                                <h4>Danh mục</h4>
                                </div>
                              <!-- Menu -->
                                <div class="col-lg-12 colCategories">
                                    <ul class="leftCategories">
                                    <?php
                                    $total=count($categories);

                                    $li='';


                                    for($i=0;$i<$total;$i++)
                                    {
                                      $li.='<li><a href="'.$categories[$i]['url'].'">'.$categories[$i]['cattitle'].'</a></li>';
                                    }

                                    echo $li;

                                    ?>
                                    </ul>
                                </div>

                              </div>

                              <?php echo $listFeatured;?>



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

                            <?php echo $lastest;?>

                            <!-- page -->
                            <div class="row">
                              <div class="col-lg-12 text-right">
                               <?php echo $listPage;?>                               
                              </div>
                            </div>
                            <!-- page -->


                                
                                             
                            </div>


                        </div>

                        <!-- End Left Right -->


                        

                        <?php echo $content_bottom;?>

