                <!-- row -->
                <div class="row">
                    <!--Left-->
                    <div class="col-md-8">

                        <!--Truyen hot-->
                        <div class="row">
                            <div class="head_title">

                                <h4>HOT MANGA</h4>
                            </div>

                            <div class="col-md-12 list_manga"  style="margin-top:5px;">
                            <?php
                            if(isset($hotManga[0]['mangaid']))
                            {
                                $total=count($hotManga);

                                $li='';

                                for ($i=0; $i < $total; $i++) { 
                                    $li.='
                                    <div class="home_thumnail">
                                        <a href="'.Manga::url($hotManga[$i]).'"><img src="'.System::getUrl().$hotManga[$i]['image'].'" /></a>
                                        <br/>
                                        <a href="'.Manga::url($hotManga[$i]).'"><small>'.$hotManga[$i]['title'].' </small> </a><br/>
                                    </div>
                                    ';
                                }

                                echo $li;
                            }
                            ?>


                            </div>

                        </div>

                        <!--Last updates-->
                        <div class="row">
                            <div class="head_title">

                                <h4>LASTEST UPDATES</h4>
                            </div>

                            <div class="col-md-12 list_manga"  style="margin-top:5px;">
                            <?php
                            if(isset($lastUpdate[0]['mangaid']))
                            {
                                $total=count($lastUpdate);

                                $li='';

                                for ($i=0; $i < $total; $i++) { 
                                    $li.='
                                    <div class="home_thumnail">
                                        <a href="'.Manga::url($lastUpdate[$i]).'"><img src="'.System::getUrl().$lastUpdate[$i]['image'].'" /></a>
                                        <br/>
                                        <a href="'.Manga::url($lastUpdate[$i]).'"><small>'.$lastUpdate[$i]['title'].' '.$lastUpdate[$i]['number'].' </small> </a><br/>
                                    </div>
                                    ';
                                }

                                echo $li;
                            }
                            ?>


                            </div>

                        </div>

                    </div>