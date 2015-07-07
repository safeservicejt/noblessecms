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

function searchResult($id)
{
  $curPage=0;

  $keywords='';

  if($matches=Uri::match('category-(\d+)-\w+-page-(\d+)'))
  {
    $curPage=$matches[2];

    $keywords=$matches[1];
  }
  else
  {
    $keywords=$id;
  }

  $loadData=Post::get(array(
    'limitShow'=>10,
    'limitPage'=>$curPage,
    'where'=>"where catid='$keywords'"
    ));

  if(!isset($loadData[0]['postid']))
  {
    Redirect::to('404page');
  }

  return $loadData;
}

function listManga($friendly_url)
{
  $curPage=0;

  if($match=Uri::match('page\/(\d+)'))
  {
    $curPage=(int)$match[1];
  }  
  $resultData=array();

  $summaryQuery="select m.*,a.title as author_title,a.friendly_url as author_friendly_url from manga_list m left join manga_authors a on a.friendly_url='$friendly_url' AND m.authorid=a.authorid order by mangaid desc";

  // die($summaryQuery);

  $summaryQueryHash=md5($summaryQuery);

  if(!$loadCache=Cache::loadKey($summaryQueryHash,1))
  {

    $loadData=Manga::get(array(
      'limitShow'=>40,
      'limitPage'=>$curPage,
      'query'=>$summaryQuery
      ));

    // print_r($loadData);die();

    if(isset($loadData[0]['mangaid']))
    {
        $total=count($loadData);

        $j=0;

        for ($i=0; $i < $total; $i++) { 

          $mangaid=$loadData[$i]['mangaid'];

          if(isset($loadData[0]['mangaid']))
          {
            $loadChapter=MangaChapters::get(array(
              'selectFields'=>'chapterid,number',
              'limitShow'=>1,
              'where'=>"where mangaid='$mangaid'",
              'orderby'=>'order by chapterid desc'
              ));

            $loadData[0]['chapter_url']='';

            if(isset($loadChapter[0]['chapterid']))
            {
              $loadData[0]['chapterid']=$loadChapter[0]['chapterid'];
              $loadData[0]['chapter_number']=$loadChapter[0]['number'];

              $loadData[0]['chapter_url']=MangaChapters::url(array('friendly_url'=>$loadData[0]['friendly_url'],'number'=>$loadData[0]['chapter_number']));
            }
            else
            {
              $loadData[0]['chapterid']=0;
              $loadData[0]['chapter_number']=0;
            }

            $loadData[0]['categories']=MangaCategories::getLinkByMangaId($loadData[0]['mangaid']);

            $resultData[$j]=$loadData[0];
          }

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


?>