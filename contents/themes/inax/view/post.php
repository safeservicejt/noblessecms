<?php echo $content_top;?>

                        
                          <!-- Left Right -->
                        <div class="row rowCenter">

                            <!-- Left -->
                            <div class="col-lg-3 divLeft">
                            <?php echo $content_left;?>

                            <?php echo $categories;?>


                            <!-- Banner -->
                              <div class="row rowLeft bg-non">
                              <!-- Title -->
                                <div class="col-lg-12 padding-non">
                                <a href=""><img src="<?php echo THEME_URL;?>images/adsleft.jpg" class="img-responsive" /></a>
                                </div>

                              </div>

                            </div>
                            <!-- Right -->
                            <div class="col-lg-9 rowRight">
                            <?php echo $content_right;?>


                             <!-- post content -->
                             <div class="row thePost">
                             	<div class="col-lg-12 colTitle"><h4><?php echo $title;?></h4></div>
                             	<div class="col-lg-12 colContent"><p><?php echo $content;?></p></div>

                             </div>
                             <!-- post content -->

                               <!-- comment -->
                              <div class="row rowReview">
                                <div class="col-lg-12 colTitle"><h4>Viết bình luận</h4></div>

                                <?php echo $commentAlert;?>

                                 <div class="col-lg-12 colContent">
                                 <p>
                                   <form action="" method="post" enctype="multipart/form-data">
                                   <p>
                                   <label><strong>Họ và tên:</strong></label>
                                   <input type="text" class="form-control input-sm" name="comment[fullname]" placeholder="Họ và tên" required />
                                   </p>
                                    <p>
                                   <label><strong>Email:</strong></label>
                                   <input type="email" class="form-control input-sm" name="comment[email]" placeholder="Email" required />
                                   </p>

                                   <p>
                                   <label><strong>Nội dung nhận xét:</strong></label>
                                   <textarea rows="8" class="form-control" name="comment[content]" placeholder="Nội dung nhận xét"></textarea>
                                   </p>

                                   <button type="submit" name="btnComment" class="btn btn-primary">Gửi</button>
                                   </form>
                                 </p>
                                 </div>

                              </div>

                              <!-- comment -->     

                           <?php echo $listComments;?>
                                
                                             
                            </div>


                        </div>

                        <!-- End Left Right -->


                        

                        <?php echo $content_bottom;?>

