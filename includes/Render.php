<?php

class Render
{
	public static function dateFormat($inputData='')
	{
		$inputData=date('M d, Y H:i',strtotime($inputData));

		return $inputData;
	}


    public static function makeSiteMap($inputData=array(),$renew=0)
    {
        $filePath=ROOT_PATH.'sitemap.xml';

        if(!System::$setting['enable_sitemap'] || System::$setting['enable_sitemap']=='no')
        {
            if(file_exists($filePath))
            {
                unlink($filePath);
            }

            return false;
        }



        $result='';

        $li='';

        $totalInput=count($inputData);

        if($totalInput==0)
        {

            $limitPostUrl=!isset(System::$setting['show_post_url_in_sitemap'])?9:(int)System::$setting['show_post_url_in_sitemap'];

            $limitCategoryUrl=!isset(System::$setting['show_category_url_in_sitemap'])?9:(int)System::$setting['show_category_url_in_sitemap'];

            $limitLinkUrl=!isset(System::$setting['show_link_url_in_sitemap'])?9:(int)System::$setting['show_link_url_in_sitemap'];

            $limitPageUrl=!isset(System::$setting['show_page_url_in_sitemap'])?9:(int)System::$setting['show_page_url_in_sitemap'];


            if(isset(System::$setting['show_post_url_in_sitemap']) && System::$setting['show_post_url_in_sitemap']=='yes')
            {
                $loadPost=Post::get(array(
                    'cache'=>'no',
                    'limitShow'=>$limitPostUrl,
                    'where'=>"where status='publish'",
                    'isHook'=>'no'
                    ));

                if(isset($loadPost[0]['postid']))
                {
                    $total=count($loadPost);

                    for ($i=0; $i < $total; $i++) { 
                        $li.='
                        <url>
                          <loc>'.$loadPost[$i]['url'].'</loc>
                        </url>
                        ';
                    }
                }                
            }
            if(isset(System::$setting['show_category_url_in_sitemap']) && System::$setting['show_category_url_in_sitemap']=='yes')
            {
                $loadCat=Categories::get(array(
                    'cache'=>'no',
                    'limitShow'=>$limitCategoryUrl,
                    'isHook'=>'no'
                    ));

                if(isset($loadCat[0]['catid']))
                {
                    $total=count($loadCat);

                    for ($i=0; $i < $total; $i++) { 
                        $li.='
                        <url>
                          <loc>'.$loadCat[$i]['url'].'</loc>
                        </url>
                        ';
                    }
                }                
            }

            if(isset(System::$setting['show_page_url_in_sitemap']) && System::$setting['show_page_url_in_sitemap']=='yes')
            {
                $loadPage=Pages::get(array(
                    'cache'=>'no',
                    'limitShow'=>$limitPageUrl,
                    'isHook'=>'no'
                    ));

                if(isset($loadPage[0]['pageid']))
                {
                    $total=count($loadPage);

                    for ($i=0; $i < $total; $i++) { 
                        $li.='
                        <url>
                          <loc>'.$loadPage[$i]['url'].'</loc>
                        </url>
                        ';
                    }
                }                
            }

            if(isset(System::$setting['show_link_url_in_sitemap']) && System::$setting['show_link_url_in_sitemap']=='yes')
            {
                $loadPage=Links::get(array(
                    'cache'=>'no',
                    'limitShow'=>$limitLinkUrl,
                    'isHook'=>'no'
                    ));

                if(isset($loadPage[0]['id']))
                {
                    $total=count($loadPage);

                    for ($i=0; $i < $total; $i++) { 
                        $li.='
                        <url>
                          <loc>'.$loadPage[$i]['urlFormat'].'</loc>
                        </url>
                        ';
                    }
                }                
            }

        }
        else
        {
            $li=((int)$renew!=0)?'':$li;

            for ($i=0; $i < $totalInput; $i++) { 
                $li.='
                <url>
                  <loc>'.$inputData[$i]['url'].'</loc>
                </url>
                ';
            }            
        }


        $li=Strings::trimLines($li);

$result='
<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
  <loc>'.System::getUrl().'</loc>
</url>

'.$li.'

</urlset>

';

        File::create($filePath,trim($result),'w');
    }

}