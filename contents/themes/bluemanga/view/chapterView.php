                <div class="row">

                    <div class="col-md-10 col-md-offset-1 text-center">
                        <h4> <a href="đf"><?php echo $manga_title;?></a> / <?php echo $number;?></h4>
                    </div>
                    <div class="col-md-10 col-md-offset-1 text-center" style="margin-top:10px;margin-bottom:10px;">
                       <select class="form-control" id="selectChapter">
                           <?php
                           $total=count($listChapters);

                           $li='';

                           for ($i=0; $i < $total; $i++) { 

                                $theUrl=MangaChapters::url(array('friendly_url'=>$listChapters['manga_friendly_url'],'number'=>$listChapters[$i]['number']));

                               $li.='
                               <option value="'.$theUrl.'">'.$listChapters[$i]['manga_title'].' - Chapter '.$listChapters[$i]['number'].'</option>
                               ';
                           }

                           echo $li;
                           ?>
                       </select>

                    </div>

    

                    <div class="col-md-10 col-md-offset-1 text-center">
                        <?php echo $contentFormat;?>
                    </div>


                    <div class="col-md-10 col-md-offset-1 text-center">
                        <h4> <a href="đf"><?php echo $manga_title;?></a> / <?php echo $number;?></h4>
                    </div>
                    <div class="col-md-10 col-md-offset-1 text-center" style="margin-top:10px;margin-bottom:10px;">
                       <select class="form-control" id="selectChapter">
                           <?php
                           $total=count($listChapters);

                           $li='';

                           for ($i=0; $i < $total; $i++) { 

                                $theUrl=MangaChapters::url(array('friendly_url'=>$listChapters['manga_friendly_url'],'number'=>$listChapters[$i]['number']));

                               $li.='
                               <option value="'.$theUrl.'">'.$listChapters[$i]['manga_title'].' - Chapter '.$listChapters[$i]['number'].'</option>
                               ';
                           }

                           echo $li;
                           ?>
                       </select>
                    </div>


                    <!--Comment -->
                    <div class="col-md-10 col-md-offset-1">
                        <h4> Comment </h4>
                    </div>

                </div>

                <script type="text/javascript">

                $(document).ready(function(){

                    $('select#selectChapter').change(function(){
                        var url=$(this).val();

                        location.href=url;

                    });

                });
                </script>
