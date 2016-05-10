<?php

/*

    Add custom bbcode

    Render::addBBCode(array(
        'textHtml'=>'[Youtube]',
        'id'=>'youtube_tool',
        'class'=>'youtube_tool',
        'jsFiles'=>array()
    ));
    
    <div class="custom_bbcode">
      <span class="the_bbcode"><i class="glyphicon glyphicon-cog"></i></span>
      <span class="the_bbcode">[Youtube]</span>
    </div>    
*/

class Render
{
    public static function addBBCode($inputData=array())
    {
        System::pushVar('admincp_custom_bbcode',$inputData);
    }

    public static function makeSiteMap($inputData=array(),$renew=0)
    {

        $result='';

        $li='';

        $totalInput=count($inputData);

        if($totalInput==0)
        {
            $loadPost=Post::get(array(
                'cache'=>'no',
                'limitShow'=>60,
                'where'=>"where status='1'",
                'isHook'=>'no'
                ));

            $loadCat=Categories::get(array(
                'cache'=>'no',
                'limitShow'=>20,
                'isHook'=>'no'
                ));

            $loadPage=Pages::get(array(
                'cache'=>'no',
                'limitShow'=>20,
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


        $li=String::trimLines($li);

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

        File::create(ROOT_PATH.'sitemap.xml',trim($result),'w');
    }

    public static function renderBBCodeHtml()
    {
        $result='';

        if(System::issetVar('admincp_custom_bbcode'))
        {
            $loadData=System::getVar('admincp_custom_bbcode');

            $total=count($loadData);

            $li='';

            $class='';

            $id='';

            for ($i=0; $i < $total; $i++) { 

                $class=isset($loadData[$i]['class'])?' class="'.$loadData[$i]['class'].'" ':'';

                $id=isset($loadData[$i]['id'])?' id="'.$loadData[$i]['id'].'" ':'';

                $li.='<span class="the_bbcode" >'.$loadData[$i]['textHtml'].'</span>';
            }

            $result='<div class="custom_bbcode" '.$class.$id.'>'.$li.'</div>';


        }

        return $result;
    }

    public static function renderBBCodeJs()
    {
        $result='';

        $li='';

        if(System::issetVar('admincp_custom_bbcode'))
        {
            $loadData=System::getVar('admincp_custom_bbcode');

            $total=count($loadData);

            $jsFiles='';

            for ($i=0; $i < $total; $i++) { 
                
                $jsFiles=isset($loadData[$i]['jsFiles'])?$loadData[$i]['jsFiles']:array();

                $totalFiles=count($jsFiles);

                for ($j=0; $j < $totalFiles; $j++) { 
                     $li.='<script src="'.$jsFiles[$j].'"></script>';
                }

            }

        }

        return $li;
    }

	public static function rawContent($inputData,$offset=-1,$to=0)
	{
		$replaces=array(
			 '~<script.*?>.*?<\/script>~s'=>'',
			 '~<script>.*?<\/script>~s'=>''
			);
		
		$inputData = preg_replace(array_keys($replaces), array_values($replaces), $inputData);

	 	$inputData=strip_tags($inputData);

	 	$inputData=($offset >= 0)?substr($inputData, 0,strlen($inputData)):$inputData;

	 	return $inputData;
	}

	public static function dateFormat($inputDate)
	{
		// $formatStr=GlobalCMS::$setting['default_dateformat'];
		$formatStr=System::getDateFormat();

		// echo $formatStr;die();

		$formatStr=date($formatStr,strtotime($inputDate));

		return $formatStr;
	}

	public static function cpanel_menu($zoneName)
	{
       $menu=Plugins::load($zoneName);


       $folderName=Plugins::$renderFolderName;

        $li='';

        if(isset($menu[0]['title']))
        {
            $total=count($menu);
            for ($i=0; $i < $total; $i++) { 
                
                if(!isset($menu[$i]['child']))
                {
                    if(isset($menu[$i]['func']))
                    {
                        $url=isset($menu[$i]['link'])?$menu[$i]['link']:ADMINCP_URL.'plugins/run/'.base64_encode($folderName.':'.$menu[$i]['func']);                     
                    }
                    else
                    {
                        $url=isset($menu[$i]['link'])?$menu[$i]['link']:ADMINCP_URL.'plugins/controller/'.$folderName.'/'.$menu[$i]['controller']; 
                    }


                    $li.='
                    <li>
                        <a href="'.$url.'"><span class="glyphicon glyphicon-list-alt"></span> '.$menu[$i]['title'].'</a>
                    </li>
                    ';
                }
                else
                {
                    $start='<li class="li-'.$folderName.'"><a href="javascript:;" data-toggle="collapse" data-target="#'.md5($menu[$i]['title'].$i).'"><span class="glyphicon glyphicon-list-alt"></span> '.$menu[$i]['title'].' <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="'.md5($menu[$i]['title'].$i).'" class="collapse">';

                    $end='</ul></li>';

                    $totalChild=count($menu[$i]['child']);

                    $liChild='';

                    for ($j=0; $j < $totalChild; $j++) { 

                 		

                        if(isset($menu[$i]['child'][$j]['func']))
                        {
                            
                            $url=isset($menu[$i]['child'][$j]['link'])?$menu[$i]['child'][$j]['link']:ADMINCP_URL.'plugins/run/'.base64_encode($folderName.':'.$menu[$i]['child'][$j]['func']);                     
                        }
                        else
                        {
                            $url=isset($menu[$i]['child'][$j]['link'])?$menu[$i]['child'][$j]['link']:ADMINCP_URL.'plugins/controller/'.$folderName.'/'.$menu[$i]['child'][$j]['controller']; 
                        }                        
                   	
                        $liChild.='
                        <li><a href="'.$url.'">'.$menu[$i]['child'][$j]['title'].'</a></li>
                        ';
                    }

                    $li.=$start.$liChild.$end;
                }
            }   
            
           	echo $li;                  
        }


	}

}