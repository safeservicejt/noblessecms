<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo $username;?> - Email: <span class="text-info"><?php echo $email;?></span></h3>
  </div>
  <div class="panel-body">
    <div class="row">
        <div class="col-lg-12">
        <?php echo $alert;?>
        <form action="" method="post" enctype="multipart/form-data">
            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                      <p>
                            <strong>Affiliate Ranks:</strong>
                          <select class="form-control" name="send[affiliaterankid]">

                              <?php 
                              $total=count($ranksList);

                              $li='';

                              if(isset($ranksList[0]['id']))
                                for ($i=0; $i < $total; $i++) { 
                                    
                                    if((int)$affiliaterankid==(int)$ranksList[$i]['id'])
                                    {
                                      $li.='<option value="'.$ranksList[$i]['id'].'" selected>'.$ranksList[$i]['title'].' ('.$ranksList[$i]['commission'].'%)</option>';
                                    }
                                    else
                                    {
                                      $li.='<option value="'.$ranksList[$i]['id'].'">'.$ranksList[$i]['title'].' ('.$ranksList[$i]['commission'].'%)</option>';
                                    }
                                    
                                }

                                echo $li;
                              ?>
                          </select>
                      </p>  

                      <p>
                            <strong>Points:</strong>
                          <input type="text" class="form-control" name="send[points]"  value="<?php echo $points;?>" />
                      </p>

                      <p>
                            <strong>Reviews:</strong>
                          <input type="text" class="form-control" name="send[reviews]"  value="<?php echo $reviews;?>" />
                      </p>

                      <p>
                            <strong>Balance:</strong>
                          <input type="text" class="form-control" name="send[balance]"  value="<?php echo $balance;?>" />
                      </p>

                      <p>
                            <strong>Affiliate Orders:</strong>
                          <input type="text" class="form-control" name="send[affiliate_orders]"  value="<?php echo $affiliate_orders;?>" />
                      </p>
                      <p>
                            <strong>Payment Summary:</strong>
                          <textarea class="form-control" name="send[withdraw_summary]" rows="10"><?php echo $withdraw_summary;?></textarea>
                      </p>

                </div>

            </div>
            <!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" name="btnSave" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
        </div>
        
    </div>
  </div>
</div>

<script>

$(document).ready(function(){


});
</script>