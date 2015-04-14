<?php

function listPage()
{
	$curPage=0;

	if($matches=Uri::match('news\/page\/(\d+)'))
	{
		$curPage=$matches[1];
	}

	$listPage=Misc::genPage('news',$curPage);	

	return $listPage;

}

function lastest()
{
	$curPage=0;

	if($matches=Uri::match('news\/page\/(\d+)'))
	{
		$curPage=$matches[1];
	}

	$loadData=Post::get(array(
		'limitShow'=>15,
		'limitPage'=>$curPage,
		'orderby'=>'order by postid desc'

		));

	if(!isset($loadData[0]['postid']))
	{
		return '';
	}

	$total=count($loadData);

	$li='';

	for($i=0;$i<$total;$i++)
	{
		$li.='
                            <!-- list -->
                              <div class="row theNews">
                                  <!-- col -->
                                    <div class="col-lg-12 colTitle">
                                    <h4>'.$loadData[$i]['title'].'</h4>
                                    </div>
                                  <!-- col -->
                                   <!-- col -->
                                    <div class="col-lg-12 colContent">
                                    '.Render::rawContent($loadData[$i]['content'],0,500).'... <a href="'.$loadData[$i]['url'].'">[Xem tiếp]</a>
                                    </div>
                                  <!-- col -->

                              </div>
                            <!-- list -->

		';
	}



	return $li;
}

function featured()
{
	$loadData=Post::get(array(
		'limitShow'=>4,
		'where'=>"where is_featured='1'",
		'orderby'=>'order by postid desc'

		));

	if(!isset($loadData[1]['postid']))
	{
		return '';
	}

	$total=count($loadData);

	$li='';

	for($i=1;$i<$total;$i++)
	{
		$li.='

              <!-- post -->
              <div class="row">
                <div class="col-lg-12"><a href="'.$loadData[$i]['url'].'">'.$loadData[$i]['title'].'</a></div>
                 <div class="col-lg-12">'.substr(strip_tags($loadData[0]['content']), 0,100).'...</div>

              </div>
              <!-- post -->
		';
	}



	return '
                            <!-- featured -->
                            <div class="row rowNewsFeatured">
                              <div class="col-lg-12 colTitle">
                                  <h4>Tin nổi bật</h4>
                              </div>

                              <!-- content -->
                               <div class="col-lg-12 colContent">
                                  <!-- row -->
                                  <div class="row">

                                    <!-- left -->
                                    <div class="col-lg-7">
                                      <h5><a href="'.$loadData[0]['url'].'">'.$loadData[0]['title'].'</a></h5>
                                      <p>
                                      '.substr(strip_tags($loadData[0]['content']), 0,500).'
                                      </p>
                                    </div>
                                    <!-- left -->
                                    <!-- right -->
                                    <div class="col-lg-5 listNews">


                                      '.$li.'

                                    </div>
                                    <!-- right -->

                                  </div>
                              </div>
                              <!-- content -->

                            </div>
                            <!-- featured -->

	';
}

function categories()
{

	  $loadData=Categories::get(array(
	    'orderby'=>'order by cattitle asc'
	    ));  	

  // print_r($loadData);die();

  $total=count($loadData);

  $li='';

  if(isset($loadData[0]['catid']))
  	for($i=0;$i<$total;$i++)
  	{
  		$li.='<li><a href="'.$loadData[$i]['url'].'">'.$loadData[$i]['cattitle'].'</a></li>';
  	}
  	else
  	{
  		$li='';
  	}



  return '

                            <!-- List categories -->
                              <div class="row rowLeft">
                              <!-- Title -->
                                <div class="col-lg-12 colTitle">
                                <h4>Danh mục</h4>
                                </div>
                              <!-- Menu -->
                                <div class="col-lg-12 colCategories">
                                    <ul class="leftCategories">
                                    '.$li.'
                                    </ul>
                                </div>

                              </div>


  ';
}


?>