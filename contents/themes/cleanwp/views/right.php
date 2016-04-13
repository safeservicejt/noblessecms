        <!-- right -->
        <div class="col-lg-4 col-md-4 col-sm-4 ">
          <!-- row -->
          <div class="row">
            <div class="col-lg-12">
            <form action="<?php echo System::getUrl();?>search" method="post" enctype="multipart/form-data" role="search">
              <div class="input-group">
                <input type="text" class="form-control" name="txtKeywords"  placeholder="Search for...">
                <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                </span>
              </div><!-- /input-group -->
            </form>           
            </div>
          </div>
          <!-- row -->
          <!-- row -->
          <div class="row widget margin-top-20">
            <div class="col-lg-12">
              <div class="head-title"><span>Recent Posts</span></div>  
              <ul>

                <?php if(isset($suggestPost[0]['postid'])){

                  $total=count($suggestPost);

                  $li='';

                  for ($i=0; $i < $total; $i++) { 

                    if(!isset($suggestPost[$i]['imageUrl']))
                    {
                      continue;
                    }

                    $li.='
                    <li><a href="'.$suggestPost[$i]['url'].'"><h4>'.$suggestPost[$i]['title'].'</h4></a></li>
                    ';
                  }

                  echo $li;
                ?>

                <?php } ?>                
              </ul>     
            </div>
          </div>
          <!-- row -->
          <!-- row -->
          <div class="row widget margin-top-20">
            <div class="col-lg-12">
              <a href="dsd"><img src="<?php echo System::getThemeUrl();?>images/5116536613169532039.jpg"></a>     
            </div>
          </div>
          <!-- row -->
        </div>
        <!-- right -->