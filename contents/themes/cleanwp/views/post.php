        <!-- left -->
        <div class="col-lg-8 col-md-8 col-sm-8 ">
          <!-- row -->
          <div class="row item">
            <div class="col-lg-12 col-item-details">
              <div class="head-title"><a href="#"><h1><?php echo $postData['title'];?></h1></a></div>
              <div class="details">
              <span class="sub"><span class="glyphicon glyphicon-calendar"></span> <?php echo date('d M, Y',strtotime($postData['date_added']));?></span>
              <span class="sub"><span class="glyphicon glyphicon-thumbs-up"></span> <?php echo number_format($postData['views']);?></span>
              </div>
              <div class="content">
              <?php echo $postData['content'];?> 
              </div>
            </div>
          </div>
          <!-- row -->
        </div>
        <!-- left -->