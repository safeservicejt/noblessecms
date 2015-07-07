                <!-- row -->
                <div class="row">
                    <!--Left-->
                    <div class="col-md-8">

                        <!--Truyen hot-->
                        <div class="row">
                            <div class="head_title">

                                <h4><?php echo $title;?></h4>
                            </div>

                            <div class="col-md-12 list_manga"  style="margin-top:5px;">
                            <?php
                            if(isset($listManga[0]['mangaid']))
                            {
                                $total=count($listManga);

                                $li='';

                                for ($i=0; $i < $total; $i++) { 
                                    $li.='
                                    <div class="cat_manga col-md-6">
                                        <div class="cat_thumbnail">
                                            <a href="'.$listManga[$i]['url'].'" title="'.$listManga[$i]['title'].'"><img src="'.$listManga[$i]['imageUrl'].'" class="img-responsive" /></a>
                                        </div>
                                        <div class="cat_details">
                                            <p><a href="'.$listManga[$i]['url'].'" class="cat_manga_title">'.$listManga[$i]['title'].'</a></p>
                                            <p>
                                                Thể loại: '.$listManga[$i]['categories'].'

                                            </p>
                                            <p>
                                                Last chapter: <a href="'.$listManga[$i]['chapter_url'].'"><span class="label label-primary">'.$listManga[$i]['chapter_number'].'</span></a>
                                            </p>

                                        </div>

                                    </div>
                                    ';
                                }

                                echo $li;
                            }

                            ?>

                            </div>

                        </div>
                        <!-- page -->
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <?php echo $listPage;?>
                            </div>
                        </div>
                    </div>

