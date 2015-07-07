                    <!--Right-->
                    <div class="col-md-4">

                        <!--Truyen xem nhieu-->
                        <div class="row">

                            <div class="col-md-12">
                                <h4>Most popular</h4>
                            </div>
                            <div class="col-md-12">
                                <ul class="right_list">

                                    <?php
                                    if(isset($hotManga[0]['mangaid']))
                                    {
                                        $total=count($hotManga);

                                        $li='';

                                        for ($i=0; $i < $total; $i++) { 

                                            $mangaid=$hotManga[$i]['mangaid'];

                                            $loadCat=MangaCategories::get(array(
                                                'query'=>"select c.title  where mangaid='$mangaid'"
                                                ));



                                            $li.='
                                            <li>
                                                <div class="col-md-5">
                                                    <a href="'.Manga::url($hotManga[$i]).'"><img src="'.System::getUrl().$hotManga[$i]['image'].'" class="img-responsive" /></a>

                                                </div>
                                                <div class="col-md-7">
                                                    <a href="'.Manga::url($hotManga[$i]).'">'.$hotManga[$i]['title'].'</a>
                                                    <br>
                                                    Thể loại: <a href="'.$hotManga[$i]['cat_url'].'"><span class="label label-primary">'.$hotManga[$i]['cattitle'].'</span></a>

                                                </div>

                                            </li>                                            
                                            ';
                                        }

                                        echo $li;
                                    }
                                    ?>                                
                                    


                                </ul>

                            </div>


                        </div>


                    </div>
                    <!-- Right -->

                </div>
                <!-- row -->