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

?>