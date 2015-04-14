
                        <!-- Checkout -->
                        <div class="row rowCheckout">
                          <div class="col-lg-12">
                          <?php echo $alert;?>

                     
                              <!-- Step 1 -->
                              <div id="stepOne" style="<?php echo $step1_status;?>">
                              <!-- Panel -->
                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo Lang::get('frontend/checkout.step1@title');?></h3>
                                  </div>

                                  <!-- Panel -->
                                  <div class="panel-body colPanelBody">
                                    
                                    <div class="row">
                                    <!-- left -->
                                      <div class="col-lg-6">
                                      <form id="formToRegister" action="" method="post" enctype="multipart/form-data">
                                      <h4><?php echo Lang::get('frontend/checkout.step1@newCustomers');?></h4>
                                      <p>
                                      <strong><?php echo Lang::get('frontend/checkout.step1@options');?></strong>
                                      </p>

                                      <p>
                                        <input type="radio" name="checkoutOptions" id="register" value="register" /> <label class="thePointer" for="register"> <?php echo Lang::get('frontend/checkout.step1@opRegister');?></label>
                                      </p>
                                       <p>
                                        <input type="radio" name="checkoutOptions" id="guest" value="guest" /> <label class="thePointer" for="guest"> <?php echo Lang::get('frontend/checkout.step1@opGuest');?></label>
                                      </p>

                                      <p>
                                      <?php echo Lang::get('frontend/checkout.step1@optionsNotify');?>

                                      </p>

                                      <button type="button" id="checkoutStep1" class="btn btn-default"><?php echo Lang::get('frontend/checkout.step1@btnContinue');?></button>
                                      </form>
                                      </div>
                                      <!-- left -->
                                    <!-- right -->
                                      <div class="col-lg-6">

                                      <form action="" method="post" enctype="multipart/form-data">
                                        <h4><?php echo Lang::get('frontend/checkout.step1@loginTitle');?></h4>
                                      <p>
                                      <strong><?php echo Lang::get('frontend/checkout.step1@loginsubTitle');?></strong>
                                      </p>

                                      <?php echo $alertLogin;?>

                                      <p>
                                      <input type="email" class="form-control" placeholder="Email..." name="email" required />
                                      </p>
                                      <p>
                                      <input type="password" class="form-control" placeholder="Password..." name="password" required />
                                      </p>

                                      <p><a href="dfd"><?php echo Lang::get('frontend/checkout.step1@forgotPassword');?></a></p>
                                      <button type="submit" id="btnLogin" name="btnLogin" class="btn btn-default"><?php echo Lang::get('frontend/checkout.step1@btnLogin');?></button>

                                      </form>

                                      </div>
                                      <!-- right -->
                                    </div>
                                  </div>
                                  <!-- Panel -->

                                </div>
                              <!-- Panel -->
                              </div>

                              <!-- Step 1 -->
                 

                              <!-- Step All -->
                              <div id="stepAll" style="<?php echo $step2_status;?>"> 

                               <form action="" method="post" enctype="multipart/form-data">



                              <!-- Step 2 -->
                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo Lang::get('frontend/checkout.step2@title');?></h3>
                                  </div>

                                  <!-- Panel -->
                                  <div class="panel-body colPanelBody" >
                                  <h4><?php echo Lang::get('frontend/checkout.step2@subTitle');?></h4>
                                  <!-- row -->
                                    <div class="row">

                                      <div class="col-lg-6">

                                      <p><strong><?php echo Lang::get('frontend/checkout.step2@firstname');?>:</strong>
                                      <input type="text" class="form-control" name="billing[firstname]" value="<?php echo Request::get('billing.firstname','');?>" placeholder="<?php echo Lang::get('frontend/checkout.step2@firstname');?>" required />
                                      </p>
                                      <p><strong><?php echo Lang::get('frontend/checkout.step2@lastname');?>:</strong>
                                      <input type="text" class="form-control" name="billing[lastname]" value="<?php echo Request::get('billing.lastname','');?>" placeholder="<?php echo Lang::get('frontend/checkout.step2@lastname');?>" required />
                                      </p>
                                      <p><strong><?php echo Lang::get('frontend/checkout.step2@email');?>:</strong>
                                      <input type="email" class="form-control" name="billing[email]" value="<?php echo Request::get('billing.email','');?>" placeholder="<?php echo Lang::get('frontend/checkout.step2@email');?>" required />
                                      </p>
                                      <p><strong><?php echo Lang::get('frontend/checkout.step2@phone');?>:</strong>
                                      <input type="text" class="form-control" name="billing[phone]" value="<?php echo Request::get('billing.phone','');?>" placeholder="<?php echo Lang::get('frontend/checkout.step2@phone');?>" required />
                                      </p>
                                      <p><strong><?php echo Lang::get('frontend/checkout.step2@fax');?>:</strong>
                                      <input type="text" class="form-control" name="billing[fax]" value="<?php echo Request::get('billing.fax','');?>" placeholder="<?php echo Lang::get('frontend/checkout.step2@fax');?>" />
                                      </p>
                                      </div>

                                      <div class="col-lg-6">
                                        <p><strong><?php echo Lang::get('frontend/checkout.step2@company');?>:</strong>
                                        <input type="text" class="form-control" name="billing[company]" value="<?php echo Request::get('billing.company','');?>" placeholder="<?php echo Lang::get('frontend/checkout.step2@company');?>" />
                                        </p>
                                         <p><strong><?php echo Lang::get('frontend/checkout.step2@address1');?>:</strong>
                                        <input type="text" class="form-control" name="billing[address_1]" value="<?php echo Request::get('billing.address_1','');?>" placeholder="<?php echo Lang::get('frontend/checkout.step2@address1');?>" required />
                                        </p>

                                         <p><strong><?php echo Lang::get('frontend/checkout.step2@address2');?>:</strong>
                                        <input type="text" class="form-control" name="billing[address_2]" value="<?php echo Request::get('billing.address_2','');?>" placeholder="<?php echo Lang::get('frontend/checkout.step2@address2');?>" />
                                        </p>

                                        <p><strong><?php echo Lang::get('frontend/checkout.step2@city');?>:</strong>
                                        <input type="text" class="form-control" name="billing[city]" value="<?php echo Request::get('billing.city','');?>" placeholder="<?php echo Lang::get('frontend/checkout.step2@city');?>" required />
                                        </p>
                                        <p><strong><?php echo Lang::get('frontend/checkout.step2@postcode');?>:</strong>
                                        <input type="text" class="form-control" name="billing[postcode]" value="<?php echo Request::get('billing.postcode','');?>" placeholder="<?php echo Lang::get('frontend/checkout.step2@postcode');?>" required />
                                        </p>
                                        <p><strong><?php echo Lang::get('frontend/checkout.step2@country');?>:</strong>
                                        <select name="billing[country]" class="form-control">

                                        <?php echo $listCountries; ?>

                                        </select>
                                        </p>


                                      </div>

                                    </div>
                                    <!-- row -->

                                    <!-- row -->
                                    <div class="row">
                                      <div class="col-lg-12">
                                      <p>
                                        <input type="checkbox" name="billSameasShipping" class="thePointer" id="billSameasShipping" value="1" /> <label class="thePointer" for="billSameasShipping"> <?php echo Lang::get('frontend/checkout.step2@billisship');?></label>
                                      </p>  
                                      </div>

                                    </div>
                                    <!-- row -->

                                  </div>
                                  <!-- Panel -->

                                </div>
                              <!-- Step 2 -->

                              <!-- Step 3 -->
                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo Lang::get('frontend/checkout.step3@title');?></h3>
                                  </div>

                                  <!-- Panel -->
                                  <div class="panel-body colPanelBody Deliveryinfo">
                                 <h4><?php echo Lang::get('frontend/checkout.step3@subTitle');?></h4>
                                  <!-- row -->
                                    <div class="row">

                                      <div class="col-lg-6">

                                      <p><strong><?php echo Lang::get('frontend/checkout.step3@firstname');?>:</strong>
                                      <input type="text" class="form-control" name="shipping[firstname]" placeholder="<?php echo Lang::get('frontend/checkout.step3@firstname');?>" />
                                      </p>
                                      <p><strong><?php echo Lang::get('frontend/checkout.step3@lastname');?>:</strong>
                                      <input type="text" class="form-control" name="shipping[lastname]" placeholder="<?php echo Lang::get('frontend/checkout.step3@lastname');?>" />
                                      </p>
                                      <p><strong><?php echo Lang::get('frontend/checkout.step3@phone');?>:</strong>
                                      <input type="text" class="form-control" name="shipping[phone]" placeholder="<?php echo Lang::get('frontend/checkout.step3@phone');?>" />
                                      </p>
                                      <p><strong><?php echo Lang::get('frontend/checkout.step3@fax');?>:</strong>
                                      <input type="text" class="form-control" name="shipping[fax]" placeholder="<?php echo Lang::get('frontend/checkout.step3@fax');?>" />
                                      </p>
                                      </div>

                                      <div class="col-lg-6">
                                        <p><strong><?php echo Lang::get('frontend/checkout.step3@company');?>:</strong>
                                        <input type="text" class="form-control" name="shipping[company]" placeholder="<?php echo Lang::get('frontend/checkout.step3@company');?>" />
                                        </p>
                                         <p><strong><?php echo Lang::get('frontend/checkout.step3@address1');?>:</strong>
                                        <input type="text" class="form-control" name="shipping[address_1]" placeholder="<?php echo Lang::get('frontend/checkout.step3@address1');?>" />
                                        </p>

                                         <p><strong><?php echo Lang::get('frontend/checkout.step3@address2');?>:</strong>
                                        <input type="text" class="form-control" name="shipping[address_2]" placeholder="<?php echo Lang::get('frontend/checkout.step3@address2');?>" />
                                        </p>

                                        <p><strong><?php echo Lang::get('frontend/checkout.step3@city');?>:</strong>
                                        <input type="text" class="form-control" name="shipping[city]" placeholder="<?php echo Lang::get('frontend/checkout.step3@city');?>" />
                                        </p>
                                        <p><strong><?php echo Lang::get('frontend/checkout.step3@postcode');?>:</strong>
                                        <input type="text" class="form-control" name="shipping[postcode]" placeholder="<?php echo Lang::get('frontend/checkout.step3@postcode');?>" />
                                        </p>
                                        <p><strong><?php echo Lang::get('frontend/checkout.step3@country');?>:</strong>
                                        <select name="shipping[country]" class="form-control">
                                          <?php echo $listCountries; ?>
                                        </select>
                                        </p>


                                      </div>

                                    </div>
                                    <!-- row -->
                                    
                                  </div>
                                  <!-- Panel -->

                                </div>
                              <!-- Step 3 -->


                              <!-- Step 4 -->
                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo Lang::get('frontend/checkout.step4@title');?></h3>
                                  </div>

                                  <!-- Panel -->
                                  <div class="panel-body colPanelBody">
                                   <!-- <p>Please select the preferred shipping method to use on this order.</p>  -->

                                   <?php echo $theTax;?>

                                  </div>
                                  <!-- Panel -->

                                </div>
                              <!-- Step 4 -->

                              <!-- Step 5 -->
                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo Lang::get('frontend/checkout.step5@title');?></h3>
                                  </div>

                                  <!-- Panel -->
                                  <div class="panel-body colPanelBody">
                                    <p><?php echo Lang::get('frontend/checkout.step5@subtitle');?></p>

                                    <?php echo $paymentMethods;?>

                                  </div>
                                  <!-- Panel -->

                                </div>

                                     <?php echo $paymentMethodsForm;?>                               
                              <!-- Step 5 -->


                              <!-- Step6 -->
                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo Lang::get('frontend/checkout.step6@title');?></h3>
                                  </div>

                                  <!-- Panel -->
                                  <div class="panel-body colPanelBody">

                                  <!-- Row -->
                                    <div class="row">
                                      <div class="col-lg-10 text-right"><strong><?php echo Lang::get('frontend/checkout.step6@subtotal');?>:</strong></div>
                                      <div class="col-lg-2 text-right"><strong><?php echo $theCart['subtotalFormat'];?></strong></div>
                                    </div>
                                    <!-- Row -->
                                  <!-- Row -->
                                    <div class="row">
                                      <div class="col-lg-10 text-right"><strong><?php echo Lang::get('frontend/checkout.step6@shippingrate');?>:</strong></div>
                                      <div class="col-lg-2 text-right"><strong><?php echo $theCart['total_taxFormat'];?></strong></div>
                                    </div>
                                    <!-- Row -->
                                  <!-- Row -->
                                    <div class="row">
                                      <div class="col-lg-10 text-right"><strong><?php echo Lang::get('frontend/checkout.step6@total');?>:</strong></div>
                                      <div class="col-lg-2 text-right"><strong><?php echo $theCart['totalFormat'];?></strong></div>
                                    </div>
                                    <!-- Row -->

                                  </div>
                                  <!-- Panel -->

                                </div>
                              <!-- Step6 -->


                              <!-- Comments -->
                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo Lang::get('frontend/checkout.comments');?></h3>
                                  </div>

                                  <!-- Panel -->
                                  <div class="panel-body colPanelBody rowComment">

                                  <!-- Row -->
                                    <div class="row">
                                      <div class="col-lg-12">
                                      <textarea class="form-control" rows="8" name="commentsOrder" placeholder="<?php echo Lang::get('frontend/checkout.comments');?>"></textarea>
                                      </div>
                                    </div>
                                    <!-- Row -->

                                  </div>
                                  <!-- Panel -->

                                </div>
                              <!-- Comments -->

                              <!-- Button -->
                                  <div class="row rowContinueButton">
                                     <div class="col-lg-6 text-left">
                                      <p>
                                        <input type="checkbox" name="agreeTerms" id="agreeTerms" value="agree" checked /><label for="agreeTerms"> <?php echo Lang::get('frontend/checkout.agree');?></label>
                                      </p>                                       
                                     </div>
                                       <div class="col-lg-6 text-right">
                                       <input type="hidden" id="thePaymentTitle" name="thePaymentTitle" value="" />
                                        <button type="submit" name="btnConfirm" class="btn btn-primary"><?php echo Lang::get('frontend/checkout.btnConfirm');?></button>
                                     </div>

                                  </div>
                              <!-- Button -->

                              </form>
                              </div>

                              <!-- Step all -->
                      

                          </div>
                        </div>
                        <!-- Checkout -->