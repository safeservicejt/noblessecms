<?php

class Render
{
	public function pluginView($viewPath,$viewName,$inputData=array())
	{
		$headData=$inputData['headData'];

		View::make('admincp/head',$headData);

		if(!isset($inputData['noNavbar']))
        View::make('admincp/nav');

		if(!isset($inputData['noLeft']))        
        View::make('admincp/left');  
              
        View::make('admincp/startContent');

        // View::make('admincp/'.$viewPath,$inputData);

		View::setPath($viewPath);

		View::make($viewName,$inputData);

		View::resetPath();

        View::make('admincp/endContent');

		View::make('admincp/footer');	        
	}

	public function admincpView($viewPath,$inputData=array())
	{	
		$headData=$inputData['headData'];

		View::make('admincp/head',$headData);

		if(!isset($inputData['noNavbar']))
        View::make('admincp/nav');

		if(!isset($inputData['noLeft']))        
        View::make('admincp/left');  
              
        View::make('admincp/startContent');

        View::make('admincp/'.$viewPath,$inputData);

        View::make('admincp/endContent');

		View::make('admincp/footer');	          
	}

	public function thumbnail($image)
	{
		if(!preg_match('/.*?\.\w+/i', $image))
		{
			$image='bootstrap/images/noimg.jpg';
		}

		$image=ROOT_URL.$image;

		return $image;
	}

	public function rawContent($inputData,$offset=-1,$to=0)
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

	public function dateFormat($inputDate)
	{
		$formatStr=GlobalCMS::$setting['default_dateformat'];

		// echo $formatStr;die();

		$formatStr=date($formatStr,strtotime($inputDate));

		return $formatStr;
	}

	public function numberFormat($inputData)
	{
		$inputData=number_format($inputData,5);

		$replaces=array(
			'/\.[0]+/i'=>''
			);
		// $replaces=array(
		// 	'/\.[0]+/i'=>'',
		// 	'/[0]+$/i'=>''
		// 	);

		$inputData=preg_replace(array_keys($replaces), array_values($replaces), $inputData);

		// preg_match('/(.*?)[0]+/i', $inputData,$matche);

		// $inputData=$matche[1];
		// $inputData=round($inputData,5);

		// $inputData=sprintf('%01.2f', $inputData);

		$inputData=($inputData=='')?0:$inputData;

		return $inputData;
	}

	public function content_top($pagename='home')
	{
		$resultData=self::getContent('content_top',$pagename);

		return $resultData;
	}
	public function content_left($pagename='home')
	{
		$resultData=self::getContent('content_left',$pagename);
		return $resultData;		
	}
	public function content_right($pagename='home')
	{
		$resultData=self::getContent('content_right',$pagename);
		return $resultData;		
	}
	public function content_bottom($pagename='home')
	{
		$resultData=self::getContent('content_bottom',$pagename);
		return $resultData;		
	}

	public function getContent($method='content_top',$pagename='')
	{

		// return Plugins::loadZone('content_top');
		

		// if($loadData=Cache::loadKey('caches_'.$method.'_'.$pagename,-1))
		// {
		// 	$loadData=stripslashes($loadData);

		// 	return $loadData;
		// }


		$resultData='';

		// if(!$pluginData=Cache::loadKey($method))
		// {
		// 	return $resultData;
		// }

		// $pluginData=json_decode($pluginData,true);

		$pluginData=array();

		$query=Database::query("select foldername,status,layoutname,func,layoutposition from plugins_meta where zonename='$method' AND layoutname='$pagename' order by layoutposition asc");

		$num_rows=Database::num_rows($query);

		if($num_rows == 0)
		{
			return false;
		}

		while($row=Database::fetch_assoc($query))
		{
			$pluginData[]=$row;
		}

		$total=count($pluginData);

		for($i=0;$i<$total;$i++)
		{
			if((int)$pluginData[$i]['status']==0)
			{
				continue;
			}

			if($pluginData[$i]['layoutname'] != $pagename)
			{
				continue;
			}

			$folderName=$pluginData[$i]['foldername'];

			$func=$pluginData[$i]['func'];

			$filePath=PLUGINS_PATH.$folderName.'/'.$folderName.'.php';

			if(!file_exists($filePath) || !isset($func[6]))
			{
				continue;
			}

			if(!function_exists($func))
			{
				require($filePath);
			}

			$resultData.=$func($pluginData[$i])."\r\n";
		}

		Cache::saveKey('caches_'.$method.'_'.$pagename,addslashes($resultData));

		return $resultData;
	}

	public function adminMenu($positionName='plugins_menu')
	{
		// $pluginData=Plugins::loadZone('plugins_menu');
		$positionData=array('plugins_menu','admin_left_menu','themes_menu','admin_nav_menu','setting_menu','usercp_left_menu','usercp_nav_menu');

		if(!in_array($positionName, $positionData))
		{
			return false;
		}

		$resultData=array();

		if(!isset(Plugins::$adminzoneCaches[$positionName]))
		{
			return false;
		}

		$resultData=Plugins::$adminzoneCaches[$positionName];

		$total=count($resultData);

		if($total == 0)
		{
			return false;
		}

		for($i=0;$i<$total;$i++)
		{
			if((int)$resultData[$i]['status']==0)
			{
				unset($resultData[$i]);
			}

	
		}

		$balance=count($resultData);

		if($balance > 0)
		{
			sort($resultData);				
		}
		return $resultData;
	}

	public function usercpMenu($positionName='plugins_menu')
	{
		// $pluginData=Plugins::loadZone('plugins_menu');
		$positionData=array('usercp_left_menu','usercp_nav_menu');

		if(!in_array($positionName, $positionData))
		{
			return false;
		}

		$resultData=array();

		if(!isset(Plugins::$usercpzoneCaches[$positionName]))
		{
			return false;
		}

		$resultData=Plugins::$usercpzoneCaches[$positionName];

		$total=count($resultData);

		if($total == 0)
		{
			return false;
		}

		for($i=0;$i<$total;$i++)
		{
			if((int)$resultData[$i]['status']==0)
			{
				unset($resultData[$i]);
			}

	
		}

		$balance=count($resultData);

		if($balance > 0)
		{
			sort($resultData);				
		}
		return $resultData;
	}

	public function get($keyName)
	{
		$resultData='';

		if(!$pluginData=Cache::loadKey($keyName))
		{
			return $resultData;
		}

		$resultData=json_decode($pluginData,true);

		$total=count($resultData);

		if($total == 0)
		{
			return false;
		}

		for($i=0;$i<$total;$i++)
		{
			if((int)$resultData[$i]['status']==0)
			{
				unset($resultData[$i]);
			}

		}

		$balance=count($resultData);

		if($balance > 0)
		{
			sort($resultData);	

			$total=count($resultData);

			$li='';

			for($i=0;$i<$total;$i++)
			{
				$li.=stripslashes($resultData[$i]['content'])."\r\n";
			}

			return $li;
		}
	}



}
?>