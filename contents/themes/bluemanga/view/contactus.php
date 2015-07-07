                <!-- row -->
                <div class="row">
                    <!--Left-->
                    <div class="col-md-12">

                        <!--Truyen hot-->
                        <div class="row">
                            <div class="head_title">

                                <h4>Contact us</h4>
                            </div>

                            <div class="col-md-12 list_manga"  style="margin-top:5px;">
                                <form action="" method="post" enctype="multipart/form-data">
								<?php echo $alert;?>
								<p>
								<label><strong>Fullname</h3>
								</strong></label>
								<input type="text" class="form-control" placeholder="Fullname" name="send[fullname]" required />
								</p>
								<p>
								<label><strong>Email</h3>
								</strong></label>
								<input type="email" class="form-control" placeholder="Email" name="send[email]" required />
								</p>
								<p>
								<label><strong>Content</h3>
								</strong></label>
								<textarea rows="10" class="form-control" placeholder="Content" name="send[content]"></textarea>
								</p>

								<button type="submit" class="btn btn-primary" name="btnSend">Send</button>

								<a href="<?php echo ROOT_URL;?>" class="btn btn-default pull-right">Back</a>                                	

                                </form>


                            </div>

                        </div>

                    </div>
                      </div>
                    