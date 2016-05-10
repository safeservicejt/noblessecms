        <!-- left -->
        <div class="col-lg-8 col-md-8 col-sm-8 ">
          <h1>Result of keywords: '<?php echo $keywords;?>'</h1>
          <hr>
          <?php

          if(isset($listPost[0]['postid']))
          {
            $total=count($listPost);

            $li='';

            for ($i=0; $i < $total; $i++) { 

              if(!isset($listPost[$i]['imageUrl']))
              {
                continue;
              }

              $li.='
             
              <!-- row -->
              <div class="row item">
                <div class="col-lg-12 col-item-details">
                  <div class="head-title"><a href="'.$listPost[$i]['url'].'" title="'.$listPost[$i]['title'].'"><h2>'.$listPost[$i]['title'].'</h2></a></div>
                  <div class="details">
                  <span class="sub"><span class="glyphicon glyphicon-calendar"></span> '.date('d M, Y',strtotime($listPost[$i]['date_added'])).'</span>
                  <span class="sub"><span class="glyphicon glyphicon-thumbs-up"></span> '.number_format($listPost[$i]['views']).'</span>
                  </div>
                  <div class="content">
                   '.$listPost[$i]['content'].'
                  </div>
                </div>
              </div>
              <!-- row -->
              ';
            }

            echo $li;
          }

          ?>        

          <!-- page -->
          <div class="row">
            <div class="col-lg-12 text-right">
             <?php echo $listPage;?>                               
            </div>
          </div>
          <!-- page -->            
        </div>
        <!-- left -->