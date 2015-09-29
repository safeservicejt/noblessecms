<?php

/*
[b]
[i]
[u]
[color=#4545][/color]
[size=23][/size]
[url=""][/url]

[img:auto][/img]
[img:auto-responsive][/img]
[label class=""][/label]
[alert class=""][/alert]

[panelbody][/panelbody]
[paneltitle][/paneltitle]
[panel][/panel]
[panel][/panel]

[taburl:active id=""][/taburl]
[taburl id=""][/taburl]
[navtabs][/navtabs]
[tabpanel:active id=""][/tabpanel]
[tabpanel id=""][/tabpanel]
[tabcontent][/tabcontent]
[tab][/tab]

[row][/row]

[col][/col]

[dropdown][/dropdown]
[drbutton class=][/drbutton]
[drmenu][/drmenu]
[drlink href=][/drlink]

[bxslider][/bxslider\]
[bximg src=]
[bximg class= src=]

[button class=""][/button]
[button id=""][/button]
[button class="" id=""][/button]
[button id="" class=""][/button]
[button ][/button]

[progress ][/progress]
[progress:success ][/progress]
[progress:primary ][/progress]
[progress:warning ][/progress]
[progress:danger ][/progress]

[badge][/badge]
[badge][/badge]

[icon:]

[root_url]
[site_url]

*/

class Shortcode
{

// Shortcode::add('youtube','make_youtube_video');

	public static function strip($text='')
	{
		$replaces=array(
			'/\[\w+.*?\].*?\[\/\w+\]/i'=>'',
			'/\[\w+.*?\/\]/i'=>'',
			'/\[\w+.*?\]/i'=>''
			);
		$text=preg_replace(array_keys($replaces), array_values($replaces), $text);		

		return $text;
	}
	
	public static function templateAdd($scName,$funcName)
	{
		if(!isset(Plugins::$listShortCodes['shortcode']))
		{
			Plugins::$listShortCodes['shortcode']=array();
		}		

		$data=debug_backtrace();	

		$pluginPath=dirname($data[0]['file']).'/';

		$folderName=basename($pluginPath);	

		$post=array();

		$post['name']=$scName;

		$post['func']=$funcName;

		$post['path']=THEMES_PATH.$folderName.'/';

		$post['foldername']=$folderName;

		$post['zonename']='shortcode';

		$post['status']=1;

		$post['istemplate']='yes';

		array_push(Plugins::$listShortCodes['shortcode'], $post);

		if(isset(Plugins::$listShortCodes['loaded']))
		{
			unset(Plugins::$listShortCodes['loaded']);
		}

		// print_r(Plugins::$listShortCodes);
		// die();
	}

	public static function add($scName,$funcName)
	{
		$data=debug_backtrace();	

		$path=dirname($data[0]['file']).'/';

		$post=array();

		$post['content']=$scName;

		$post['func']=$funcName;

		$pluginPath=$path;

		$folderName=basename($path);

		$post['foldername']=$folderName;

		$post['zonename']='shortcode';

		$post['type']='shortcode';

		// Plugins::add('shortcode',$post);
		
		if(!PluginsMeta::insert($post))
		{
			return false;			
		}

	
		PluginsZone::addPlugin($post['zonename'],$post);

	}


	public static function load($content)
	{

		// $content=self::parse($content);

		if(!isset(Plugins::$listCaches['shortcode']))
		{
			return $content;
		}

		$loadData=Plugins::$listCaches['shortcode'];

		// print_r($loadData);die();

		$total=count($loadData);

		$foldername='';

		$func='';

		$scName='';

		$pluginPath='';

		$parse='';

		$resultData='';

		$resultSC='';

		for($i=0;$i<$total;$i++)
		{
			$theShortcode=$loadData[$i];

			if((int)$theShortcode['status']==0)
			{
				continue;
			}

			$foldername=$theShortcode['foldername'];

			$func=$theShortcode['func'];

			$scName=isset($theShortcode['name'])?$theShortcode['name']:$theShortcode['content'];


			$pluginPath=PLUGINS_PATH.$foldername.'/index.php';

			if(isset($theShortcode['path']) && isset($theShortcode['istemplate']))
			{
				$pluginPath=$theShortcode['path'].'/shortcode.php';
			}


			$parse='';


			if(!function_exists($func) || isset($theShortcode['istemplate']))
			{
				if(file_exists($pluginPath))
				{
					if(!isset($theShortcode['istemplate']))
					include($pluginPath);
				}


				$resultSC=self::parseProcess($scName,$content);

				$totalResult=count($resultSC);
				
				$replaces=array();

				for($e=0;$e<$totalResult;$e++)
				{
					$resultData=$func($resultSC[$e]);

					$replaces[$resultSC[$e]['real']]=$resultData;
					
					$resultData='';
				}

				
				$content=str_replace(array_keys($replaces), array_values($replaces), $content);


			}

		}


		return $content;

	}

	public static function loadInSystem()
	{
		$filePath=ROOT_PATH.'includes/Shortcodedb.php';

		if(!file_exists('system_shortcode_list'))
		{
			include($filePath);
		}

		$listShortCodes=system_shortcode_list();

		$listNames=array_keys($listShortCodes);

		$total=count($listShortCodes);

		$addList=array();

		for ($i=0; $i < $total; $i++) { 

			$scName=$listNames[$i];

			$func=$listShortCodes[$scName];

			$addList[$i]['status']=1;

			$addList[$i]['istemplate']='yes';

			$addList[$i]['foldername']='includes';

			$addList[$i]['func']=$func;

			$addList[$i]['name']=$scName;

			// $addList[$i]['shortcode']=$scName;

			$addList[$i]['path']=ROOT_PATH.'includes/';

		}

		if(isset($addList[0]['status']))
		{
			Plugins::$listShortCodes['shortcode']=$addList;
			// if(!isset(Plugins::$listShortCodes['shortcode']))
			// {
			// 	Plugins::$listShortCodes['shortcode']=array();
			// }

			// if(!is_array(Plugins::$listShortCodes['shortcode']))
			// {
			// 	Plugins::$listShortCodes['shortcode']=$addList;
			// }
			// else
			// {
			// 	array_push(Plugins::$listShortCodes['shortcode'], $addList);
			// }

			
		}
		

	}

	public static function loadInTemplate($content)
	{
		// $content=self::parse($content);

		if(!isset(Plugins::$listShortCodes['shortcode']))
		{
			return $content;
		}

		$loadData=Plugins::$listShortCodes['shortcode'];


		$total=count($loadData);

		$foldername='';

		$func='';

		$scName='';

		$pluginPath='';

		$parse='';

		$resultData='';

		$resultSC='';

		for($i=0;$i<$total;$i++)
		{
			$theShortcode=$loadData[$i];
	

			if(!isset($theShortcode['status']) || (int)$theShortcode['status']==0)
			{
				continue;
			}

			$foldername=$theShortcode['foldername'];

			$func=$theShortcode['func'];

			$scName=$theShortcode['name'];

			$pluginPath=PLUGINS_PATH.$foldername.'/shortcode.php';


			if(isset($theShortcode['path']) && isset($theShortcode['istemplate']))
			{
				$pluginPath=$theShortcode['path'].'shortcode.php';
			}


			$parse='';


			if(!function_exists($func) || isset($theShortcode['istemplate']))
			{
				if(file_exists($pluginPath))
				{
					if(!isset($theShortcode['istemplate']))
					include($pluginPath);
				}

				$resultSC=self::parseProcess($scName,$content);

				$totalResult=count($resultSC);

				// for($e=0;$e<$totalResult;$e++)
				// {
				// 	$resultData=$func($resultSC[$e]);
					
				// // print_r($resultSC);die();

				// 	$content=str_replace($resultSC[$e]['real'], $resultData, $content);
					
				// 	$resultData='';
				// }

				$replaces=array();

				for($e=0;$e<$totalResult;$e++)
				{
					$resultData=$func($resultSC[$e]);

					$replaces[$resultSC[$e]['real']]=$resultData;
					
					$resultData='';
				}

				$content=str_replace(array_keys($replaces), array_values($replaces), $content);


			}

		}

		return $content;

	}

	public static function parseProcess($scName='',$inputData='')
	{
		$result=array();

		// Check if it is openclose
		if(!preg_match_all('/(\['.$scName.'(.*?)\](.*?)\[\/'.$scName.'\])/is', $inputData,$match))
		{
			// Alone parse process
			if(preg_match_all('/(\['.$scName.'(.*?)\])/i', $inputData,$match))
			{
				$listReal=$match[1];

				$listAttr=$match[2];	
				
				$total=count($listReal);

				for ($i=0; $i < $total; $i++) { 

					$result[$i]['real']=$listReal[$i];

					$result[$i]['attr']=array();

					$attr=$listAttr[$i];

					if(isset($attr[1]))
					{
						// die($attr);
						if(preg_match_all('/(\w+)\=(\'|\"|)([a-zA-Z0-9_\-\_\=\.\/\:\;\>\<\!\@\#\$\%\^\&\*\(\)\s]+)(\'|\"|)/i', $attr, $matchAttrs))
						{

							$totalAttr=count($matchAttrs[1]);

							for ($j=0; $j < $totalAttr; $j++) { 
								$theKey=$matchAttrs[1][$j];

								$result[$i]['attr'][$theKey]=$matchAttrs[3][$j];
							}
						}
					}

				}							
			}
		}	
		else
		{
			// Openclose parse process

			$listReal=$match[1];

			$listAttr=$match[2];

			$listVal=$match[3];

			$total=count($listReal);

			for ($i=0; $i < $total; $i++) { 

				$result[$i]['real']=$listReal[$i];

				$result[$i]['value']=trim($listVal[$i]);

				$result[$i]['attr']=array();

				$attr=$listAttr[$i];

				if(isset($attr[1]))
				{
					// die($attr);
					if(preg_match_all('/(\w+)\=(\'|\"|)([a-zA-Z0-9_\-\_\=\.\/\:\;\>\<\!\@\#\$\%\^\&\*\(\)\s]+)(\'|\"|)/i', $attr, $matchAttrs))
					{

						$totalAttr=count($matchAttrs[1]);

						for ($j=0; $j < $totalAttr; $j++) { 
							$theKey=$matchAttrs[1][$j];

							$result[$i]['attr'][$theKey]=$matchAttrs[3][$j];
						}
					}
				}

			}

		}

		// print_r($result);die();

		return $result;
	}


	public static function toHTML($str)
	{
		$hash=md5($str);

		$filePath=CACHES_PATH.'dbcache/system/bbcode/'.$hash.'.cache';

		if(file_exists($filePath))
		{
			$loadData=unserialize(file_get_contents($filePath));

			return $loadData;
		}

		$str=trim($str);

		$str=html_entity_decode($str);

		$str=String::clearSpace($str);

		$str=preg_replace('/[\s]+\]/i', ']', $str);

		$str=str_replace("\n", '<br/>', $str);

	// BBcode array
	    $find = array(

	        '~\[b\](.*?)\[/b\]~s'=>'<strong>$1</strong>',
	        '~\[i\](.*?)\[/i\]~s'=>'<i>$1</i>',
	        '~\[u\](.*?)\[/u\]~s'=>'<span style="text-decoration:underline;">$1</span>',
	        '~\[quote\](.*?)\[/quote\]~s'=>'<pre>$1</pre>',
	        '~\[size=(.*?)\](.*?)\[/size\]~s'=>'<span style="font-size:$1px;">$2</span>',
	        '~\[color=(.*?)\](.*?)\[/color\]~s'=>'<span style="color:$1;">$2</span>',

	        '~\[label class="(.*?)"\](.*?)\[\/label\]~s'=>'<span class="label label-default $1">$2</span>',
	        '~\[alert class="(.*?)"\](.*?)\[\/alert\]~s'=>'<div class="alert alert-default $1">$2</div>',

	        '~\[panelbody\](.*?)\[\/panelbody\]~s'=>'<div class="panel-body">$1</div>',
	        '~\[paneltitle\](.*?)\[\/paneltitle\]~s'=>'<div class="panel-heading">$1</div>',
	        '~\[panel\](.*?)\[\/panel\]~s'=>'<div class="panel panel-default">$1</div>',
	        '~\[panel (.*?)\](.*?)\[\/panel\]~s'=>'<div $1>$2</div>',

	        '~\[taburl:active id="(.*?)"\](.*?)\[\/taburl\]~s'=>'<li role="presentation" class="active"><a href="#$1" aria-controls="$1" role="tab" data-toggle="tab">$2</a></li>',
	        '~\[taburl id="(.*?)"\](.*?)\[\/taburl\]~s'=>'<li role="presentation"><a href="#$1" aria-controls="$1" role="tab" data-toggle="tab">$2</a></li>',
	        '~\[navtabs\](.*?)\[\/navtabs\]~s'=>'<ul class="nav nav-tabs" role="tablist">$1</ul>',
	        '~\[tabpanel:active id="(.*?)"\](.*?)\[\/tabpanel\]~s'=>'<div role="tabpanel" class="tab-pane active" id="$1">$2</div>',
	        '~\[tabpanel id="(.*?)"\](.*?)\[\/tabpanel\]~s'=>'<div role="tabpanel" class="tab-pane" id="$1">$2</div>',
	        '~\[tabcontent\](.*?)\[\/tabcontent\]~s'=>'<div class="tab-content">$1</div>',
	        '~\[tab\](.*?)\[\/tab\]~s'=>'<div role="tabpanel">$1</div>',

	        '~\[row\](.*?)\[\/row\]~s'=>'<div class="row">$1</div>',
	        '~\[row class="(.*?)"\](.*?)\[\/row\]~s'=>'<div class="row $1">$2</div>',
	        '~\[row id="(.*?)"\](.*?)\[\/row\]~s'=>'<div class="row" id="$1">$2</div>',
	        '~\[row class="(.*?)" id="(.*?)"\](.*?)\[\/row\]~s'=>'<div class="row $1" id="$2">$3</div>',
	        '~\[row id="(.*?)" class="(.*?)"\](.*?)\[\/row\]~s'=>'<div class="row $2" id="$1">$3</div>',

	        '~\[col\](.*?)\[\/col\]~s'=>'<div class="col-lg-12">$1</div>',
	        '~\[col class="(.*?)"\](.*?)\[\/col\]~s'=>'<div class="col-lg-12 $1">$2</div>',
	        '~\[col id="(.*?)"\](.*?)\[\/col\]~s'=>'<div class="col-lg-12" id="$1">$2</div>',
	        '~\[col class="(.*?)" id="(.*?)"\](.*?)\[\/col\]~s'=>'<div class="col-lg-12 $1" id="$2">$3</div>',
	        '~\[col id="(.*?)" class="(.*?)"\](.*?)\[\/col\]~s'=>'<div class="col-lg-12 $2" id="$1">$3</div>',


	        '~\[dropdown\](.*?)\[\/dropdown\]~s'=>'<div class="dropdown">$1</div>',
	        '~\[drbutton class="(.*?)"\](.*?)\[\/drbutton\]~s'=>'<button class="btn btn-default $1 dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">$2<span class="caret"></span></button>',
	        '~\[drmenu\](.*?)\[\/drmenu\]~s'=>'<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">$1</ul>',
	        '~\[drlink href="(.*?)"\](.*?)\[\/drlink\]~i'=>'<li role="presentation"><a role="menuitem" tabindex="-1" href="$1">$2</a></li>',

	        '~\[bxslider\](.*?)\[\/bxslider\]~s'=>'<ul class="bxslider">$1</ul><script>$(document).ready(function(){$(\'.bxslider\').bxSlider({auto: true});});</script>',
	        '~\[bximg src="(.*?)"\]~s'=>'<li><img src="$1" alt="Image" /></li>',
	        '~\[bximg class="(.*?)" src="(.*?)"\]~s'=>'<li><img class="$1" alt="Image" src="$2" /></li>',

	        '~\[button class="(.*?)"\](.*?)\[\/button\]~s'=>'<button type="button" class="btn btn-default $1">$2</button>',
	        '~\[button id="(.*?)"\](.*?)\[\/button\]~s'=>'<button type="button" class="btn btn-default" id="$1">$2</button>',
	        '~\[button class="(.*?)" id="(.*?)"\](.*?)\[\/button\]~s'=>'<button type="button" class="btn btn-default $1" id="$2">$3</button>',
	        '~\[button id="(.*?)" class="(.*?)"\](.*?)\[\/button\]~s'=>'<button type="button" id="$1" class="btn btn-default $2">$3</button>',
	        '~\[button (.*?)\](.*?)\[\/button\]~s'=>'<button $1>$2</button>',

	        '~\[progress (.*?)\](.*?)\[\/progress\]~s'=>'<div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="$2" aria-valuemin="0" aria-valuemax="100" style="width: $2%;" $1><span class="sr-only">$2% Complete</span></div></div>',
	        '~\[progress:success (.*?)\](.*?)\[\/progress\]~s'=>'<div class="progress"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="$2" aria-valuemin="0" aria-valuemax="100" style="width: $2%;" $1><span class="sr-only">$2% Complete</span></div></div>',
	        '~\[progress:primary (.*?)\](.*?)\[\/progress\]~s'=>'<div class="progress"><div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="$2" aria-valuemin="0" aria-valuemax="100" style="width: $2%;" $1><span class="sr-only">$2% Complete</span></div></div>',
	        '~\[progress:warning (.*?)\](.*?)\[\/progress\]~s'=>'<div class="progress"><div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="$2" aria-valuemin="0" aria-valuemax="100" style="width: $2%;" $1><span class="sr-only">$2% Complete</span></div></div>',
	        '~\[progress:danger (.*?)\](.*?)\[\/progress\]~s'=>'<div class="progress"><div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="$2" aria-valuemin="0" aria-valuemax="100" style="width: $2%;" $1><span class="sr-only">$2% Complete</span></div></div>',

	        '~\[badge\](.*?)\[\/badge\]~s'=>'<span class="badge">$1</span>',
	        '~\[badge (.*?)\](.*?)\[\/badge\]~s'=>'<span class="badge" $1>$2</span>',

	        '~\[icon:(.*?)\]~i'=>'<span class="glyphicon glyphicon-$1" aria-hidden="true"></span>',

	        '~\[root_url\]~i'=>ROOT_URL,
	        '~\[site_url\]~i'=>ROOT_URL

	    );


	    $replaces = array(

	        '[unordered_list]' => '<ul>', '[/unordered_list]' => '</ul>',
	        '[list]' => '<ul>', '[/list]' => '</ul>',
	        '[ul]' => '<ul>', '[/ul]' => '</ul>',
	        '[ordered_list]' => '<ol>', '[/ordered_list]' => '</ol>',
	        '[ol]' => '<ol>', '[/ol]' => '</ol>',
	        '[list_item]' => '<li>', '[/list_item]' => '</li>',
	        '[li]' => '<li>', '[/li]' => '</li>',
	        '[*]' => '<li>', '[/*]' => '</li>',
	        '[code]' => '<code>', '[/code]' => '</code>',
	        '[code]' => '<pre>', '[/code]' => '</pre>',
	        '[code]' => '<pre>', '[/code]' => '</pre>',
	        '[heading1]' => '<h1>', '[/heading1]' => '</h1>',
	        '[heading2]' => '<h2>', '[/heading2]' => '</h2>',
	        '[heading3]' => '<h3>', '[/heading3]' => '</h3>',
	        '[h1]' => '<h1>', '[/h1]' => '</h1>',
	        '[h2]' => '<h2>', '[/h2]' => '</h2>',
	        '[h3]' => '<h3>', '[/h3]' => '</h3>',
	        '[p]' => '<p>', '[/p]' => '</p>',
	        '[para]' => '<p>', '[/para]' => '</p>',
	        '[p]' => '<p>', '[/p]' => '</p>',
	        '[p][p]' => '','[p][p][p]' => '','[p][p][p][p]' => '',
	        '[/p][/p]' => '','[/p][/p][/p]' => '','[/p][/p][/p][/p]' => '',
	        '[b]' => '<b>', '[/b]' => '</b>',
	        '[b]' => '<strong>', '[/b]' => '</strong>',
	       	'<newline>'=>"\r\n", '[br]'=>'<br/>'


	    );

    	$str = preg_replace(array_keys($find), array_values($find), $str);
	    $str = str_replace(array_keys($replaces), array_values($replaces), $str);

	    // $find = array("<br>", "<br/>", "<br />");

	    // $str = str_replace($find, "\r\n", $str);

	    // $str = trim(strip_tags($str));

	    Cache::saveKey('dbcache/system/bbcode/'.$hash,serialize($str));

	    return $str;		
	}

	public static function toBBCode($str)
	{
		$str=trim($str);

		$tmp=explode("\r\n", $str);

		$str='[p]'.implode('[/p]'."\r\n".'[p]', $tmp).'[/p]';

		$str=String::clearSpace($str);

		$str=preg_replace('/[\s]+\]/i', ']', $str);

	// HTML tags to replace BBcode
	    $regex = array(
	        '/<span style="color:(.*?);">(.*?)<\/span>/i'=>'[color="$1"]$2[/color]',
	        '/<span style="font-size:(\d+)px;">(.*?)<\/span>/i'=>'[size="$1"]$2[/color]',

	        '/<div class="col-lg-12 (.*?)" id="(.*?)">(.*?)<\/div>/i'=>'[col id="$2" class="$1"]$3[/col]',
	        '/<div class="col-lg-12 (.*?)" id="(.*?)">(.*?)<\/div>/i'=>'[col class="$1" id="$2"]$3[/col]',
	        '/<div class="col-lg-12" id="(.*?)">(.*?)<\/div>/i'=>'[col id="$1"]$2[/col]',
	        '/<div class="col-lg-12 (.*?)">(.*?)<\/div>/i'=>'[col class="$1"]$2[/col]',
	        '/<div class="col-lg-12">(.*?)<\/div>/i'=>'[col]$1[/col]',

	        '/<div class="row (.*?)" id="(.*?)">(.*?)<\/div>/i'=>'[row id="$2" class="$1"]$3[/row]',
	        '/<div class="row" id="(.*?)">(.*?)<\/div>/i'=>'[row id="$1"]$2[/row]',
	        '/<div class="row (.*?)">(.*?)<\/div>/i'=>'[row class="$1"]$2[/row]',
	        '/<div class="row">(.*?)<\/div>/i'=>'[row]$1[/row]',

	        '/<div role="tabpanel">(.*?)<\/div>/i'=>'[tab]$1[/tab]',
	        '/<div class="tab-content">(.*?)<\/div>/i'=>'[tabcontent]$1[/tabcontent]',
	        '/<div role="tabpanel" class="tab-pane" id="(.*?)">(.*?)<\/div>/i'=>'[tabpanel id="$1"]$2[/tabpanel]',
	        '/<div role="tabpanel" class="tab-pane active" id="(.*?)">(.*?)<\/div>/i'=>'[tabpanel:active id="$1"]$2[/tabpanel]',
	        '/<ul class="nav nav-tabs" role="tablist">(.*?)<\/ul>/i'=>'[navtabs]$1[/navtabs]',
	        '/<li role="presentation"><a href="#(.*?)" aria-controls="(.*?)" role="tab" data-toggle="tab">(.*?)<\/a><\/li>/i'=>'[taburl id="$1"]$3[/taburl]',
	        '/<li role="presentation" class="active"><a href="#(.*?)" aria-controls="(.*?)" role="tab" data-toggle="tab">(.*?)<\/a><\/li>/i'=>'[taburl:active id="$1"]$3[/taburl]',

	        '/<div class="panel panel-default (.*?)">(.*?)<\/div>/i'=>'[panel class="$1"]$2[/panel]',
	        '/<div class="panel panel-default">(.*?)<\/div>/i'=>'[panel]$1[/panel]',
	        '/<div class="panel-heading">(.*?)<\/div>/i'=>'[paneltitle]$1[/paneltitle]',
	        '/<div class="panel-body">(.*?)<\/div>/i'=>'[panelbody]$1[/panelbody]',

	        '/<div class="alert alert-default (.*?)">(.*?)<\/div>/i'=>'[alert class="$1"]$2[/alert]',
	        '/<span class="label label-default (.*?)">(.*?)<\/span>/i'=>'[label class="$1"]$2[/label]',

	        '/\[url=?(\'|\"|)(.*?)?(\'|\"|)\](.*?)\[\/url\]/i'=>'[url href="$2"]$4[/url]',
	        '/<a.*?href="(.*?)".*?>(.*?)<\/a>/i'=>'[url href="$1"]$2[/url]',

	        '/<img src="" alt="image" data-src="(.*?)".*?>/i'=>'[img]$1[/img]',
	        '/<img.*?src="(.*?)".*?>/i'=>'[img]$1[/img]',
	        	   
	        '/\r\n/'=>'[br]',
	        	   
	        '/<row>(.*?)<\/row>/is'=>'[row]$1[/row]',
	        '/<col>(.*?)<\/col>/is'=>'[col]$1[/col]'
	   	

	    );


	    $replaces = array(

	        '[unordered_list]' => '<ul>', '[/unordered_list]' => '</ul>',
	        '[list]' => '<ul>', '[/list]' => '</ul>',
	        '[ul]' => '<ul>', '[/ul]' => '</ul>',
	        '[ordered_list]' => '<ol>', '[/ordered_list]' => '</ol>',
	        '[ol]' => '<ol>', '[/ol]' => '</ol>',
	        '[list_item]' => '<li>', '[/list_item]' => '</li>',
	        '[li]' => '<li>', '[/li]' => '</li>',
	        '[*]' => '<li>', '[/*]' => '</li>',
	        '[code]' => '<code>', '[/code]' => '</code>',
	        '[code]' => '<pre>', '[/code]' => '</pre>',
	        '[code]' => '<pre>', '[/code]' => '</pre>',
	        '[heading1]' => '<h1>', '[/heading1]' => '</h1>',
	        '[heading2]' => '<h2>', '[/heading2]' => '</h2>',
	        '[heading3]' => '<h3>', '[/heading3]' => '</h3>',
	        '[h1]' => '<h1>', '[/h1]' => '</h1>',
	        '[h2]' => '<h2>', '[/h2]' => '</h2>',
	        '[h3]' => '<h3>', '[/h3]' => '</h3>',
	        '[p]' => '<p>', '[/p]' => '</p>',
	        '[para]' => '<p>', '[/para]' => '</p>',
	        '[p]' => '<p>', '[/p]' => '</p>',
	        '' => '<p><p>','' => '</p></p>',
	        '' => '<p><p><p>','' => '</p></p></p>',
	        '' => '<p><p><p><p>','' => '</p></p></p></p>',
	        
	        '[b]' => '<b>', '[/b]' => '</b>',

	        '[b]' => '<strong>', '[/b]' => '</strong>',
	        '' => '<br>', '' => '<br/>',

	    );	

    	$str = preg_replace(array_keys($regex), array_values($regex), $str);

	    $str = str_replace(array_values($replaces), array_keys($replaces), $str);

	    return $str;	

	}
}
?>