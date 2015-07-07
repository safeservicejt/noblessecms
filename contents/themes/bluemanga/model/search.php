<?php
function hotManga()
{
  $loadData=Manga::get(array(
    'limitShow'=>5,
    'query'=>"select m.*,table2.title as cattitle,table2.friendly_url as cat_friendly_url from manga_list m left join (select c.*,mc.mangaid from categories c, manga_categories mc where mc.catid=c.catid group by mc.mangaid) as table2 ON m.mangaid=table2.mangaid order by m.mangaid desc"
    ));   

  if(isset($loadData[0]['mangaid']))
  {
    $total=count($loadData);
    for ($i=0; $i < $total; $i++) { 
      $loadData[$i]['cat_url']=Categories::url(array('friendly_url'=>$loadData[$i]['cat_friendly_url']));
    }
  }

  return $loadData;
}

function listManga($keyword)
{
  $curPage=0;

  if($match=Uri::match('page\/(\d+)'))
  {
    $curPage=(int)$match[1];
  }  

  $resultData=array();

  $summaryQuery="select m.*,mc.number from manga_list m, chapter_list mc where (m.title LIKE '%$keyword%' OR m.summary LIKE '%$keyword%') AND m.mangaid=mc.mangaid group by m.mangaid order by mc.number desc";


  $summaryQueryHash=md5($summaryQuery);

  if(!$loadCache=Cache::loadKey($summaryQueryHash,1))
  {

      $loadData=Manga::get(array(
      	'limitShow'=>40,
      	'limitPage'=>$curPage,
        'query'=>$summaryQuery
        ));

      if(isset($loadData[0]['mangaid']))
      {
      	$total=count($loadData);

        $j=0;


      	for ($i=0; $i < $total; $i++) { 

      		$mangaid=$loadData[$i]['mangaid'];

	        $loadChapter=MangaChapters::get(array(
	          'selectFields'=>'chapterid,number',
	          'limitShow'=>1,
	          'where'=>"where mangaid='$mangaid'",
	          'orderby'=>'order by chapterid desc'
	          ));

	        $loadData[$i]['chapter_url']='';

	        if(isset($loadChapter[0]['chapterid']))
	        {
	          $loadData[$i]['chapterid']=$loadChapter[0]['chapterid'];
	          $loadData[$i]['chapter_number']=$loadChapter[0]['number'];

	          $loadData[$i]['chapter_url']=MangaChapters::url(array('friendly_url'=>$loadData[$i]['friendly_url'],'number'=>$loadData[$i]['chapter_number']));
	        }
	        else
	        {
	          $loadData[$i]['chapterid']=0;
	          $loadData[$i]['chapter_number']=0;
	        }

	        $loadData[$i]['categories']=MangaCategories::getLinkByMangaId($loadData[$i]['mangaid']);

	        $resultData[$j]=$loadData[0];

          $j++;
      	}


      }


    Cache::saveKey($summaryQueryHash,serialize($resultData));

  }
  else
  {
    $resultData=unserialize($loadCache);
  }

  return $resultData;
}

function listPage()
{
  $curPage=0;

  $id=0;

  $friendly_url='';

  if($matches=Uri::match('category-(\d+)-([a-zA-Z0-9_-]+)-page-(\d+)'))
  {
    $curPage=$matches[3];

    $id=$matches[1];

    $friendly_url=$matches[2];

  }elseif($matches=Uri::match('category-(\d+)-([a-zA-Z0-9_-]+)'))
  {
    $id=$matches[1];

    $friendly_url=$matches[2];
  }

  $listPage=Misc::genPage('category-'.$id.'-'.$friendly_url,$curPage,5,'-'); 

  return $listPage;

}


?>