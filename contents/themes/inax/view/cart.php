
						<?php echo $content_top;?>
                        <!-- Shopping cart -->
                        <div class="row rowCart">
                        <h4><?php echo Lang::get('frontend/cart.title');?></h4>

                          <div class="col-lg-12 table-responsive">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                <td class="col-lg-2"><?php echo Lang::get('frontend/cart.tdimage');?></td>
                                 <td class="col-lg-4"><?php echo Lang::get('frontend/cart.tdproduct');?></td>
                                 <td class="col-lg-2"><?php echo Lang::get('frontend/cart.tdquantity');?></td>
                                 <td class="col-lg-2 text-right"><?php echo Lang::get('frontend/cart.tdunit');?></td>
                                 <td class="col-lg-2 text-right"><?php echo Lang::get('frontend/cart.tdtotal');?></td>
                                </tr>
                              </thead>

                              <tbody>


                              <?php echo $content['listProd'];?>



                              </tbody>
                            </table>
                          </div>

                          <!-- Coupon & Gift Cart -->
                          <div class="col-lg-12">
                          <p><h4><?php echo Lang::get('frontend/cart.options@title');?></h4></p>
                          <p>
                          <span><?php echo Lang::get('frontend/cart.options@notify');?></span>
                          </p>

                          <p>
                          <input type="radio" name="discount_method" id="coupon" value="coupon" /> <label for="coupon"><?php echo Lang::get('frontend/cart.options@useCoupon');?></label>
                          </p>

                            <p>
                            <input type="radio" name="discount_method" id="voucher"  value="voucher" /> <label for="voucher"><?php echo Lang::get('frontend/cart.options@useVoucher');?></label>
                          </p>

                          </div>

                          <div class="col-lg-6 divCoupon">
                                  <div class="input-group">
                                    <input type="text" name="discountCode" id="discountCode" placeholder="<?php echo Lang::get('frontend/cart.options@couponHolder');?>" class="form-control">
                                    <span class="input-group-btn">
                                      <button class="btn btn-danger" id="btnAddCoupon" type="button"><?php echo Lang::get('frontend/cart.options@btnApply');?></button>
                                    </span>
                                  </div><!-- /input-group -->                           
                          </div>

                          <div class="col-lg-6 divVoucher">
                                  <div class="input-group">
                                    <input type="text" name="disvoucherCode" id="disvoucherCode" placeholder="<?php echo Lang::get('frontend/cart.options@voucherHolder');?>" class="form-control">
                                    <span class="input-group-btn">
                                      <button class="btn btn-danger" id="btnAddVoucher" type="button"><?php echo Lang::get('frontend/cart.options@btnApply');?></button>
                                    </span>
                                  </div><!-- /input-group -->                           
                          </div>

                          <!-- Total -->
                          <div class="col-lg-12 rowTotal">
                          
                            <?php if(isset($content['discount'])) { ?>

                            <div class="row">
                              <div class="col-lg-10 text-right"><strong><?php echo Lang::get('frontend/cart.options@notifyDiscount');?>:</strong></div>
                               <div class="col-lg-2 text-right">- <?php echo $content['discountFormat'];?></div>
                            </div>

                            <?php } ?>


                            <div class="row">
                              <div class="col-lg-10 text-right"><strong><?php echo Lang::get('frontend/cart.options@notifySubTotal');?>:</strong></div>
                               <div class="col-lg-2 text-right"><?php echo $content['subtotalFormat'];?></div>
                            </div>



                            <div class="row">
                              <div class="col-lg-10 text-right"><strong>VAT (<?php echo $content['vat'];?>%):</strong></div>
                               <div class="col-lg-2 text-right"><?php echo $content['totalvatFormat'];?></div>
                            </div>


                            <div class="row">
                              <div class="col-lg-10 text-right"><strong><?php echo Lang::get('frontend/cart.options@notifyTotal');?>:</strong></div>
                               <div class="col-lg-2 text-right"><?php echo $content['totalFormat'];?></div>
                            </div>
                            <div class="row rowContinueButton">
                              <div class="col-lg-7 text-right">
                                <a href="<?php echo ROOT_URL;?>" class="btn btn-primary"><?php echo Lang::get('frontend/cart.options@btnContinue');?></a>
                              </div>
                               <div class="col-lg-5 text-right">
                                  <a href="<?php echo Url::checkout();?>" class="btn btn-primary"><?php echo Lang::get('frontend/cart.options@btnCheckout');?></a>
                               </div>
                            </div>


                          </div>
                          <!-- Total -->

                           <!-- Coupon & Gift Cart -->

                        </div>
                        <!-- Shopping cart -->
						<?php echo $content_bottom;?>