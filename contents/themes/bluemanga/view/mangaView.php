                <div class="row">
                    <!--Left-->
                    <div class="col-md-8">

                        <!--Truyen hot-->
                        <div class="row">
                           <div class="mangainfo_thumbnail">
                               <img src="<?php echo $imageUrl;?>" class="img-responsive" />
                           </div>
                            <div class="mangainfo_details">
                              <p> <strong style="font-size:24px;"><?php echo $title;?></strong></p>

                               <p> Author: <a href="<?php echo MangaAuthors::url(array('authorid'=>$authorid,'friendly_url'=>$author_friendly_url));?>"><span class="label label-primary"><?php echo $author_title;?></span></a></p>

                                <p>Status: <?php echo $completed;?></p>

                               <p> Genres: <?php echo $categories;?></p>

                               <div>
                                   Summary:<br>
                                    <span class="mangaSummary">
                                    <?php echo $summary;?>
                                    </span>
                               </div>
                            </div>

                        </div>

                        <!--Ads-->
                        <div class="row">
                            <div class="col-md-12" style="padding-left:0px;margin-top:10px;">
                           <p> Tags: <?php echo $tags;?></p>

                            </div>
                        </div>

                        <!--Last updates-->
                        <div class="row">
                            <div class="head_title">

                                <h4>Chapters list</h4>
                            </div>

                            <div class="col-md-12"  style="margin-top:5px;padding-left:0px;padding-right:0px;">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td class="col-md-6 td_list_chapter">Chapter</td>
                                        <td class="col-md-4 td_list_chapter text-right">Date Added</td>
                                        <td class="col-md-2 td_list_chapter text-right">Views</td>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(isset($chapters[0]['mangaid']))
                                    {
                                        $total=count($chapters);

                                        $li='';

                                        for ($i=0; $i < $total; $i++) { 

                                            $chapter_title=$chapters[$i]['number'];

                                            if(isset($chapters[$i]['title'][1]))
                                            {
                                                $chapter_title.=' - '.$chapters[$i]['title'];
                                            }

                                            $li.='
                                            <tr>
                                            <td><a href="'.MangaChapters::url(array('friendly_url'=>$friendly_url,'number'=>$chapters[$i]['number'])).'">Chapter '.$chapter_title.'</a></td>
                                                <td class=" text-right">'.$chapters[$i]['date_added'].'</td>
                                                <td class=" text-right">'.$chapters[$i]['views'].'</td>

                                            </tr>

                                            ';
                                        }

                                        echo $li;
                                    }

                                    ?>


                                    </tbody>

                                </table>


                            </div>

                        </div>

                        <!--Comment-->

                        <div class="row">
                            <div class="col-md-12">

                            </div>
                        </div>
                    </div>