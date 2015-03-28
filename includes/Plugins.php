<?php

class Plugins
{

	public static $zoneCaches=array();
	public static $adminzoneCaches=array();
	public static $usercpzoneCaches=array();

	public static $canAddZone='no';

	public static $isInstall='no';

	public static $isUninstall='no';

	public static $folderName='';

	public static $control='no';

	public static $setting='no';

	public static $controlTitle='no';

	public function add($type='global_function',$inputData=array())
	{
		Cache::removeKey('zoneCaches');

		$type=strtolower(trim($type));

		// $resultData=array();

		switch ($type) {

			case 'special_page':
				self::addZone('special_page',$inputData);
				break;
			case 'global_function':
				self::addZone('global_function',$inputData);
				break;

			case 'before_system_load':
				self::addZone('before_system_load',$inputData);		
				break;
			case 'after_system_load':
				self::addZone('after_system_load',$inputData);	
				break;

			case 'process_post_title':
				self::addZone('process_post_title',$inputData);		
				break;
			case 'process_post_content':
				self::addZone('process_post_content',$inputData);					

				break;
			case 'process_page_title':
				self::addZone('process_page_title',$inputData);		
				break;
			case 'process_page_content':
				self::addZone('process_page_content',$inputData);					

				break;
			case 'process_product_title':
				self::addZone('process_product_title',$inputData);		
				break;
			case 'process_product_content':
				self::addZone('process_product_content',$inputData);
				break;

			case 'process_comment_content':
				self::addZone('process_comment_content',$inputData);		
				break;

			case 'process_review_content':
				self::addZone('process_review_content',$inputData);		
				break;


				
			case 'shortcode':
				if(!isset($inputData['name']) && !isset($inputData['func']))
				{
					return false;
				}
				Cache::removeKey('listShortcode');			
				self::addZone('shortcode',$inputData);					

				break;
			case 'content_top':
				if(!isset($inputData['func']))
				{
					return false;
				}
				Cache::removeKey('caches_content_top');			
				self::addZone('content_top',$inputData);					

				break;

			case 'content_left':
				if(!isset($inputData['func']))
				{
					return false;
				}
				Cache::removeKey('caches_content_left');						
				self::addZone('content_left',$inputData);					

				break;
			case 'content_right':
				if(!isset($inputData['func']))
				{
					return false;
				}
				Cache::removeKey('caches_content_right');						
				self::addZone('content_right',$inputData);					

				break;
			case 'content_bottom':
				if(!isset($inputData['func']))
				{
					return false;
				}
				Cache::removeKey('caches_content_bottom');						
				self::addZone('content_bottom',$inputData);					

				break;


			case 'before_insert_category':
			// $inputData is insert data of category
				self::addZone('before_insert_category',$inputData);					

				break;
			case 'before_insert_post':
			// $inputData is insert data of post
				self::addZone('before_insert_post',$inputData);	
				break;
			case 'before_insert_page':
				// $inputData is insert data of page
				self::addZone('before_insert_page',$inputData);		
				break;
			case 'before_insert_product':
				// $inputData is insert data of product
				self::addZone('before_insert_product',$inputData);				

			break;
			case 'before_insert_users':
				// $inputData is insert data of product
				self::addZone('before_insert_users',$inputData);				

			break;

			case 'before_insert_comments':
					// $inputData is insert data of comment
				self::addZone('before_insert_comments',$inputData);		
			break;

			case 'before_insert_reviews':
					// $inputData is insert data of reviews
				self::addZone('before_insert_reviews',$inputData);		
			break;

			case 'after_insert_category':
					// $inputData is insert data of category
				self::addZone('after_insert_category',$inputData);		
				break;
			case 'after_insert_post':
					// $inputData is insert data of post
				self::addZone('after_insert_post',$inputData);						

				break;
			case 'after_insert_page':
					// $inputData is insert data of page
				self::addZone('after_insert_page',$inputData);	

				break;
			case 'after_insert_product':
						// $inputData is insert data of product
				self::addZone('after_insert_product',$inputData);				

			break;
			
			case 'after_insert_customers':
						// $inputData is insert data of customer
				self::addZone('after_insert_users',$inputData);	

			break;

			case 'after_insert_orders':
						// $inputData is insert data of order 
				self::addZone('after_insert_orders',$inputData);	

			break;
			case 'after_success_orders':
				
						// $inputData is insert data of order 
				self::addZone('after_success_orders',$inputData);	

			break;

			case 'after_approved_orders':
							// $inputData is insert data of order 
				self::addZone('after_approved_orders',$inputData);	
			
			break;
			case 'after_insert_comments':
								// $inputData is insert data of comments 
				self::addZone('after_insert_comments',$inputData);	

			break;
			case 'after_insert_reviews':
									// $inputData is insert data of reviews 
				self::addZone('after_insert_reviews',$inputData);	

			break;
			case 'plugins_menu':

			// print_r($inputData);die();
									// $inputData is insert data of reviews 
			if(!isset($inputData['text']) || !isset($inputData['filename']))
			{
				return false;
			}

				self::addZone('plugins_menu',$inputData);	

			break;

			case 'themes_menu':

			// print_r($inputData);die();
									// $inputData is insert data of reviews 
			if(!isset($inputData['text']) || !isset($inputData['filename']))
			{
				return false;
			}

				self::addZone('themes_menu',$inputData);	

			break;

			case 'setting_menu':
									// $inputData is insert data of reviews 
			if(!isset($inputData['text']) || !isset($inputData['filename']))
			{
				return false;
			}			
				self::addZone('setting_menu',$inputData);	

			break;
			case 'admin_left_menu':
									// $inputData is insert data of reviews 
			if(!isset($inputData['text']) || !isset($inputData['filename']))
			{
				return false;
			}			
				self::addZone('admin_left_menu',$inputData);	

			break;
			case 'admin_nav_menu':
									// $inputData is insert data of reviews 
			if(!isset($inputData['text']) || !isset($inputData['filename']))
			{
				return false;
			}			
				self::addZone('admin_nav_menu',$inputData);	

			break;

			case 'admin_header':
									// $inputData is insert data of reviews 
			if(!isset($inputData['content']))
			{
				return false;
			}			

			$inputData['content']=addslashes($inputData['content']);
				self::addZone('admin_header',$inputData);	

			break;
			case 'admin_footer':
									// $inputData is insert data of reviews 
			if(!isset($inputData['content']))
			{
				return false;
			}	
			$inputData['content']=addslashes($inputData['content']);			
				self::addZone('admin_footer',$inputData);	

			break;
			case 'usercp_left_menu':
									// $inputData is insert data of reviews 
			if(!isset($inputData['text']) || !isset($inputData['filename']))
			{
				return false;
			}			
				self::addZone('usercp_left_menu',$inputData);	

			break;
			case 'usercp_nav_menu':
									// $inputData is insert data of reviews 
			if(!isset($inputData['text']) || !isset($inputData['filename']))
			{
				return false;
			}			
				self::addZone('usercp_nav_menu',$inputData);	

			break;

			case 'usercp_header':
									// $inputData is insert data of reviews 
			if(!isset($inputData['content']))
			{
				return false;
			}			

			$inputData['content']=addslashes($inputData['content']);
				self::addZone('usercp_header',$inputData);	

			break;
			case 'usercp_footer':
									// $inputData is insert data of reviews 
			if(!isset($inputData['content']))
			{
				return false;
			}	
			$inputData['content']=addslashes($inputData['content']);			
				self::addZone('usercp_footer',$inputData);	

			break;


			case 'theme_footer':
									// $inputData is insert data of reviews 
			if(!isset($inputData['content']))
			{
				return false;
			}
			$inputData['content']=addslashes($inputData['content']);							
				self::addZone('theme_footer',$inputData);	

			break;
			case 'theme_header':
									// $inputData is insert data of reviews 
			if(!isset($inputData['content']))
			{
				return false;
			}
			$inputData['content']=addslashes($inputData['content']);							
				self::addZone('theme_header',$inputData);	

			break;

		}

		// return $resultData;
	}


	public function load($type='global_function',$inputData=array())
	{
		$type=strtolower(trim($type));


		$resultData=array();

		switch ($type) {
			case 'special_page':
				$resultData=self::loadZone('special_page');
				break;
			case 'global_function':
				$resultData=self::loadZone('global_function');
				break;


			case 'before_system_load':
				self::loadZone('before_system_load');		
				break;
			case 'after_system_load':
				self::loadZone('after_system_load');	
				break;
			case 'process_post_title':
				$resultData=self::loadZone('process_post_title',$inputData['title']);		
				break;
			case 'process_post_content':
				$resultData=self::loadZone('process_post_content',$inputData['content']);					

				break;
				case 'shortcode':
				if(!$resultData=Cache::loadKey('listShortcode'))
				{
					$resultData=self::loadZone('shortcode');				
				}
				
				$resultData=json_decode($resultData);
				break;
				case 'content_top':
				$resultData=self::loadZone('content_top');	
				break;

					case 'content_left':
				$resultData=self::loadZone('content_left');	
				break;
					case 'content_right':
				$resultData=self::loadZone('content_right');	
				break;
					case 'content_bottom':
				$resultData=self::loadZone('content_bottom');	
				break;
							
			case 'before_insert_category':
			// $inputData is insert data of category
				self::loadZone('before_insert_category',$inputData);					

				break;
			case 'before_insert_post':
			// $inputData is insert data of post
				self::loadZone('before_insert_post',$inputData);	
				break;
			case 'before_insert_page':
				// $inputData is insert data of page
				self::loadZone('before_insert_page',$inputData);		
				break;
			case 'before_insert_product':
				// $inputData is insert data of product
				self::loadZone('before_insert_product',$inputData);				

			break;
			case 'before_insert_comments':
					// $inputData is insert data of comment
				self::loadZone('before_insert_comments',$inputData);		
			break;

			case 'before_insert_reviews':
					// $inputData is insert data of reviews
				self::loadZone('before_insert_reviews',$inputData);		
			break;
			case 'before_insert_customers':
					// $inputData is insert data of reviews
				self::loadZone('before_insert_customers',$inputData);		
			break;

			case 'after_insert_category':
					// $inputData is insert data of category
				self::loadZone('after_insert_category',$inputData);		
				break;
			case 'after_insert_post':
					// $inputData is insert data of post
				self::loadZone('after_insert_post',$inputData);						

				break;
			case 'after_insert_page':
					// $inputData is insert data of page
				self::loadZone('after_insert_page',$inputData);	

				break;
			case 'after_insert_product':
						// $inputData is insert data of product
				self::loadZone('after_insert_product',$inputData);				

			break;
			
			case 'after_insert_customers':
						// $inputData is insert data of customer
				self::loadZone('after_insert_customers',$inputData);	

			break;

			case 'after_insert_orders':
						// $inputData is insert data of order 
				self::loadZone('after_insert_orders',$inputData);	

			break;
			case 'after_success_orders':
				
						// $inputData is insert data of order 
				self::loadZone('after_success_orders',$inputData);	

			break;

			case 'after_approved_orders':
							// $inputData is insert data of order 
				self::loadZone('after_approved_orders',$inputData);	
			
			break;
			case 'after_insert_comments':
								// $inputData is insert data of comments 
				self::loadZone('after_insert_comments',$inputData);	

			break;
			case 'after_insert_reviews':
									// $inputData is insert data of reviews 
				self::loadZone('after_insert_reviews',$inputData);	

			break;
			case 'plugins_menu':
									// $inputData is insert data of reviews 
				$resultData=self::loadZone('plugins_menu');	

			break;
			case 'themes_menu':
									// $inputData is insert data of reviews 
				$resultData=self::loadZone('themes_menu');	

			break;
			
			case 'setting_menu':
									// $inputData is insert data of reviews 
				$resultData=self::loadZone('setting_menu');	

			break;
			case 'admin_menu':
									// $inputData is insert data of reviews 
				$resultData=self::loadZone('admin_menu');	

			break;
			case 'admin_left_menu':
									// $inputData is insert data of reviews 
				$resultData=self::loadZone('admin_left_menu');	

			break;
			case 'admin_nav_menu':
									// $inputData is insert data of reviews 
				$resultData=self::loadZone('admin_nav_menu');	

			break;

			case 'admin_header':
									// $inputData is insert data of reviews 
				$resultData=self::loadZone('admin_header');	

			break;
			case 'admin_footer':
									// $inputData is insert data of reviews 
				$resultData=self::loadZone('admin_footer');	

			break;
			case 'usercp_left_menu':
									// $inputData is insert data of reviews 
				$resultData=self::loadZone('usercp_left_menu');	

			break;
			case 'usercp_nav_menu':
									// $inputData is insert data of reviews 
				$resultData=self::loadZone('usercp_nav_menu');	

			break;

			case 'usercp_header':
									// $inputData is insert data of reviews 
				$resultData=self::loadZone('usercp_header');	

			break;
			case 'usercp_footer':
									// $inputData is insert data of reviews 
				$resultData=self::loadZone('usercp_footer');	

			break;

			case 'theme_footer':
									// $inputData is insert data of reviews 
				$resultData=self::loadZone('theme_footer');	

			break;
			case 'theme_header':
									// $inputData is insert data of reviews 
				$resultData=self::loadZone('theme_header');	

			break;


		}

		return $resultData;
	}


	public function systemInstall($folderName)
	{
		if(preg_match('/\/contents\/plugins\//i', __FILE__))
		{
			return false;
		}

		$pluginPath=PLUGINS_PATH.$folderName;

		if(!is_dir($pluginPath))
		{
			return false;
		}

		$filePath=$pluginPath.'/'.$folderName.'.php';

		if(!file_exists($filePath))
		{
			return false;
		}

		// Database::query("insert into plugins(foldername,status) values('$folderName','1')");

		// require($filePath);

	}

	public function systemUninstall($folderName)
	{
		if(preg_match('/\/contents\/plugins\//i', __FILE__))
		{
			return false;
		}

		$pluginPath=PLUGINS_PATH.$folderName;

		// if(!is_dir($pluginPath))
		// {
		// 	return false;
		// }

		// $filePath=$pluginPath.'/'.$folderName.'.php';

		// if(!file_exists($filePath))
		// {
		// 	return false;
		// }

		// require($filePath);

		$query=Database::query("select metaid,zonename,func,layoutname from plugins_meta where foldername='$folderName'");

		$num_rows=Database::num_rows($query);

		$listID=array();

		$i=0;

		if((int)$num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{

				self::removeZone($row['zonename'],array('metaid'=>$row['metaid'],'foldername'=>$folderName));

				self::removeZoneCaches($row['zonename']);

				Cache::removeKey('caches_'.$row['zonename'].'_'.$row['layoutname']);

			}
		}

		Database::query("delete from plugins_meta where foldername='$folderName'");

		Database::query("delete from plugins where foldername='$folderName'");



		// self::removeZone($row['zonename'],array('metaid'=>$row['metaid'],'foldername'=>$folderName));


	}

	public function install($functionName='none')
	{
		if(self::$isInstall=='no' || self::$folderName=='')
		{
			return false;
		}

		if($functionName=='none')
		{
			return false;
		}

		if(!function_exists($functionName))
		{
			return false;
		}

		self::systemInstall(self::$folderName);

		$functionName();


	}	

	public function uninstall($functionName='none')
	{
		if(self::$isInstall=='no' || self::$folderName=='')
		{
			return false;
		}

		if($functionName=='none')
		{
			return false;
		}

		if(!function_exists($functionName))
		{
			return false;
		}

		// self::systemUninstall(self::$folderName);

		$functionName();
	}
	public function addZone($zoneName,$inputData=array())
	{

		if(self::$canAddZone=='no')
		{
			return false;
		}

		$inputData['foldername']=self::$folderName;

		// $inputData['path']=PLUGINS_PATH.self::$folderName.'/';

		self::insertPluginMetas($zoneName,$inputData);
	}
	public function insertPluginMetas($zoneName,$inputData=array())
	{
		// Database::query("insert into plugins_meta(pluginid,func,path,zonename,layoutname,layoutposition,pagename,variablename)");

		if(!isset($inputData['foldername']))
		{
			return false;
		}

		$func=isset($inputData['func'])?$inputData['func']:'';

		$path=isset($inputData['path'])?$inputData['path']:'';

		$layoutname=isset($inputData['layoutname'])?$inputData['layoutname']:'';

		$layoutposition=isset($inputData['layoutposition'])?$inputData['layoutposition']:'0';

		$pagename=isset($inputData['pagename'])?$inputData['pagename']:'';

		$variablename=isset($inputData['variablename'])?$inputData['variablename']:'';

		$status=isset($inputData['status'])?$inputData['status']:'0';

		$pagename=isset($inputData['pagename'])?$inputData['pagename']:'';

		$variablename=isset($inputData['variablename'])?$inputData['variablename']:'';
		
		$foldername=isset($inputData['foldername'])?$inputData['foldername']:'';

		$img_width=isset($inputData['img_width'])?$inputData['img_width']:'0';

		$img_height=isset($inputData['img_height'])?$inputData['img_height']:'0';

		$limit_number=isset($inputData['limit'])?$inputData['limit']:'0';

		$child_menu=isset($inputData['child_menu'])?$inputData['child_menu']:'';

		// print_r($inputData);die();

		// Insert into Database
		$table = new DatabaseORM('plugins_meta');

		// $table->pluginid = $pluginid;
		$table->func = $func;
		$table->path = $path;
		$table->layoutname = $layoutname;
		$table->layoutposition = $layoutposition;
		$table->variablename = $variablename;
		$table->zonename = $zoneName;
		$table->status = $status;
		$table->pagename = $pagename;
		$table->variablename = $variablename;
		$table->foldername = $foldername;
		$table->img_width = $img_width;
		$table->img_height = $img_height;
		$table->limit_number = $limit_number;
		$table->child_menu = json_encode($child_menu);

		$metaid=$table->InsertOnSubmit();

		$inputData['metaid']=$metaid;

		if(!is_numeric($metaid))
		{
			return false;
		}

		// $inputData['pluginid']=$pluginid;

		$inputData['zonename']=$zoneName;

		$inputData['status']=$status;

		// Save into caches
		self::saveZone($zoneName,$inputData);

		self::removeZoneCaches($zoneName);		
	}

	public function setStatus($setMethod='enable',$inputData=array())
	{
		$status='1';
		
		if($setMethod=='disable')
		{
			$status='0';
		}

		$enableData=array('status'=>$status);	
			
		if(isset($inputData['foldername']))
		{
			$foldername=$inputData['foldername'];

			$query=Database::query("select metaid,zonename from plugins_meta where foldername='$foldername'");

			$num_rows=Database::num_rows($query);

			if((int)$num_rows > 0)
			{


				while($row=Database::fetch_assoc($query))
				{
					self::updateZone($row['zonename'],$row['metaid'],$enableData);
				}
			}

			return true;
		}

		if(isset($inputData['metaid']) && isset($inputData['zonename']))
		{
			$metaid=$inputData['metaid'];

			$zonename=$inputData['zonename'];

			self::updateZone($zonename,$metaid,$enableData);

			return false;
		}

	}

	public function updateZone($zoneName,$metaid,$inputData=array())
	{
		$reparseData=array();

		if(!$loadZoneData=Cache::loadKey($zoneName,-1))
		{
			return false;	
		}

		$reparseData=json_decode($loadZoneData,true);

		$keyNames=array_keys($inputData);

		$totalMeta=count($reparseData);

		$totalKey=count($keyNames);

		$keyName='';

		for($i=0; $i < $totalMeta; $i++)
		{
			if($metaid==$reparseData[$i]['metaid'])
			{
				for($j=0;$j < $totalKey; $j++)
				{
					$keyName=$keyNames[$j];

					$reparseData[$i][$keyName]=$inputData[$keyName];
				}

				break;
			}

		}		

		$reparseData=json_encode($reparseData);

		Cache::saveKey($zoneName,$reparseData);

		self::removeZoneCaches($zoneName);		
	}
	public function saveZone($zoneName,$inputData=array())
	{
		if(!isset($inputData['metaid']))
		{
			return false;
		}

		$reparseData='';

		$loadZoneData=Cache::loadKey($zoneName,-1);

		if(!$loadZoneData)
		{
			$reparseData=array();		
		}
		else
		{
			$reparseData=json_decode($loadZoneData,true);

			$total=count($reparseData);

			for($i=0;$i < $total;$i++)
			{
				if($reparseData[$i]['metaid']==$inputData['metaid'])
				{
					unset($reparseData[$i]);

					break;
				}
			}			
		}



		// $reparseData[]=json_encode($inputData);
		$reparseData[]=$inputData;

		sort($reparseData);

		$reparseData=json_encode($reparseData);

		Cache::saveKey($zoneName,$reparseData);

		unset($loadZoneData);

		unset($inputData);

		unset($reparseData);

		return true;
	}
	public function clearZone($zoneName='')
	{
		if(!$zoneData=Cache::loadKey($zoneName,-1))
		{
			return true;
		}

		$resultData=array();

		Cache::saveKey($zoneName,json_encode($resultData));
	}
	public function clearPlugin($zoneName='')
	{
		if(!$zoneData=Cache::loadKey($zoneName,-1))
		{
			return false;
		}

		$resultData=array();

		Cache::saveKey($zoneName,json_encode($resultData));
	}

	public function removeZone($zoneName,$inputData=array())
	{

		// echo $zoneName;die();
		$total=count($inputData);

		if($total == 0)
		{
			return false;
		}

		if(!$loadZoneData=Cache::loadKey($zoneName,-1))
		{
			return false;
		}

		$loadZoneData=json_decode($loadZoneData,true);	

		$totalMeta=count($loadZoneData);

		$reparseData='';

		for($i=0;$i < $totalMeta; $i++)
		{
			// $plugin=$loadZoneData[$i];

			if($loadZoneData[$i]['metaid'] == $inputData['metaid'])
			{
				unset($loadZoneData[$i]);
			}
		}

		sort($loadZoneData);

		$reparseData=json_encode($loadZoneData);

		Cache::saveKey($zoneName,$reparseData);

		self::removeZoneCaches($zoneName);

		return true;
	}

	public function removeZoneCaches($zoneName)
	{
		Cache::removeKey('caches_'.$zoneName);
	}
	public function loadZone($zoneName,$inputData=array())
	{
		// $loadData=array() list plugin 
		// $loadData[0]['metaid']='1';		
		// $loadData[0]['function']='functionname';
		// $loadData[0]['path']='plugin path to run function';
		// $loadData[0]['pagename']='pagename';home|categories|product|compare|wishlist|cart|register|login|account|post|pages
		// $loadData[0]['zonename']='pagename';global_function|before_system_load...
		// $loadData[0]['layoutname']='layoutname';top|left|right|bottom
		// $loadData[0]['layoutposition']='1';0|1|2|3|4...
		// $loadData[0]['variablename']='$your_custom_variable';
		// $loadData[0]['status']='1';

		// Zonetype load|return|inputreturn|input
		// Page home|categories|product|compare|wishlist|cart|register|login|account|post|pages

		$zoneList=array(
				'before_system_load'=>'load',
				'after_system_load'=>'load',

				'global_function'=>'load',

				// 'plugins_menu'=>'return',
				// 'setting_menu'=>'return',
				// 'admin_menu'=>'return',

				// 'theme_header'=>'return',
				// 'theme_footer'=>'return',

				// 'content_top'=>'return',
				// 'content_left'=>'return',
				// 'content_right'=>'return',
				// 'content_bottom'=>'return',

				// 'process_post_title'=>'inputreturn',
				// 'process_post_content'=>'inputreturn',

				'shortcode'=>'inputreturn',

				'before_insert_category'=>'input',
				'before_insert_post'=>'input',
				'before_insert_page'=>'input',
				'before_insert_product'=>'input',
				'before_insert_comments'=>'input',
				'before_insert_reviews'=>'input',
				'before_insert_users'=>'input',
				'after_insert_category'=>'input',
				'after_insert_post'=>'input',
				'after_insert_page'=>'input',
				'after_insert_product'=>'input',
				'after_insert_users'=>'input',
				'after_insert_orders'=>'input',
				'after_success_orders'=>'input',
				'after_approved_orders'=>'input',
				'after_insert_comments'=>'input',
				'after_insert_reviews'=>'input'
			 );



		if(!isset(self::$zoneCaches[$zoneName]))
		{
			if(!$zoneData=Cache::loadKey($zoneName,-1))
			{
				return false;
			}

			$zoneData=json_decode($zoneData,true);
		}
		else
		{
			$zoneData=self::$zoneCaches[$zoneName];
		}

		$totalPlugin=count($zoneData);

		if($totalPlugin == 0)
		{
			return false;
		}

		$li='';

		$resultData=array();

		for($i=0;$i<$totalPlugin;$i++)
		{
			$plugin=$zoneData[$i];

			if((int)$plugin['status']==0)
			{
				continue;
			}

			$zoneType=$zoneList[$zoneName];

			$folderName=$plugin['foldername'];

			$pluginPath=PLUGINS_PATH.$folderName;

			if(!is_dir($pluginPath))
			{
				continue;
			}

			$filePath=$pluginPath.'/'.$folderName.'.php';

			// $func=$plugin['func'];

			switch ($zoneType) {
				case 'load':
					
					if(!function_exists($plugin['func']))
					{
						require($filePath);

					}
					$func=$plugin['func'];

					$func();					

					break;
				case 'input':
					
					if(!function_exists($plugin['func']))
					{
						require($filePath);
					}
					$func=$plugin['func'];

					$func($inputData);
					
					break;
				case 'return':
					
					if(!function_exists($plugin['func']))
					{
						require($filePath);
					}
					$func=$plugin['func'];

					$li.=$func()."\r\n";
					break;
					case 'inputreturn':
					
					if(!function_exists($plugin['func']))
					{
						require($filePath);
					}
					$func=$plugin['func'];

					$li=$func($inputData)."\r\n";

					break;
				
	
			}


		}

		// if(isset($li[5]))
		// {
		// 	return $li;
		// }
		return $li;
		// return $resultData;

	}

	public function loadadminZoneCaches()
	{
		if($loadData=Cache::loadKey('adminzoneCaches',15))
		{
			self::$adminzoneCaches=json_decode($loadData,true);

			return true;
		}

		$zoneList=array(

				'admin_left_menu'=>'return',
				'admin_nav_menu'=>'return',

				'plugins_menu'=>'return',
				'setting_menu'=>'return',
				'themes_menu'=>'return',

				'admin_header'=>'return',
				'admin_footer'=>'return'

			 );

		$zoneNames=array_keys($zoneList);

		// print_r($zoneNames);die();

		$total=count($zoneNames);

		$zoneData='';

		for($i=0; $i < $total; $i++)
		{
			$zoneName=$zoneNames[$i];

			if(!$zoneData=Cache::loadKey($zoneName,-1))
			{
				// self::$zoneCaches[$zoneName]=array();
				continue;
			}

			$zoneData=json_decode($zoneData,true);

			$totalPlugin=count($zoneData);

			for($j=0;$j < $totalPlugin;$j++)
			{
				if((int)$zoneData[$j]['status']==0)
				{
					unset($zoneData[$j]);
				}
			}

			sort($zoneData);

			self::$adminzoneCaches[$zoneName]=$zoneData;

		}

		Cache::saveKey('adminzoneCaches',json_encode(self::$adminzoneCaches));

		unset($zoneData);

		unset($zoneNames);
	}
	public function loadusercpZoneCaches()
	{
		if($loadData=Cache::loadKey('usercpzoneCaches',15))
		{

			self::$usercpzoneCaches=json_decode($loadData,true);
			// print_r(self::$usercpzoneCaches);
			// die('545');
			return true;
		}

		$zoneList=array(

				'usercp_left_menu'=>'return',
				'usercp_nav_menu'=>'return',
				'usercp_header'=>'return',
				'usercp_footer'=>'return'

			 );

		$zoneNames=array_keys($zoneList);

		// print_r($zoneNames);die();

		$total=count($zoneNames);

		$zoneData='';

		for($i=0; $i < $total; $i++)
		{
			$zoneName=$zoneNames[$i];

			if(!$zoneData=Cache::loadKey($zoneName,-1))
			{
				// self::$zoneCaches[$zoneName]=array();
				continue;
			}

			$zoneData=json_decode($zoneData,true);

			$totalPlugin=count($zoneData);

			for($j=0;$j < $totalPlugin;$j++)
			{
				if((int)$zoneData[$j]['status']==0)
				{
					unset($zoneData[$j]);
				}
			}

			sort($zoneData);

			self::$usercpzoneCaches[$zoneName]=$zoneData;

		}

		Cache::saveKey('usercpzoneCaches',json_encode(self::$usercpzoneCaches));

		unset($zoneData);

		unset($zoneNames);
	}



	public function loadZoneCaches()
	{
		if($loadData=Cache::loadKey('zoneCaches',30))
		{
			self::$zoneCaches=json_decode($loadData,true);

			return true;
		}

		$zoneList=array(
				'before_system_load'=>'load',
				'after_system_load'=>'load',

				'special_page'=>'return',
				// 'global_function'=>'return',
				// 'theme_footer'=>'return',
				// 'theme_header'=>'return',				
				'process_post_title'=>'inputreturn',
				'process_post_content'=>'inputreturn',
				'process_page_title'=>'inputreturn',
				'process_page_content'=>'inputreturn',
				'process_product_title'=>'inputreturn',
				'process_product_content'=>'inputreturn',
				// 'process_comment_title'=>'inputreturn',
				'process_comment_content'=>'inputreturn',
				'process_review_content'=>'inputreturn',
				'shortcode'=>'inputreturn',

				'before_insert_category'=>'input',
				'before_insert_post'=>'input',
				'before_insert_page'=>'input',
				'before_insert_product'=>'input',
				'before_insert_comments'=>'input',
				'before_insert_reviews'=>'input',
				'before_insert_users'=>'input',
				'after_insert_category'=>'input',
				'after_insert_post'=>'input',
				'after_insert_page'=>'input',
				'after_insert_product'=>'input',
				'after_insert_users'=>'input',
				'after_insert_orders'=>'input',
				'after_success_orders'=>'input',
				'after_approved_orders'=>'input',
				'after_insert_comments'=>'input',
				'after_insert_reviews'=>'input'
			 );

		$zoneNames=array_keys($zoneList);

		// print_r($zoneNames);die();

		$total=count($zoneNames);

		$zoneData='';

		for($i=0; $i < $total; $i++)
		{
			$zoneName=$zoneNames[$i];

			if(!$zoneData=Cache::loadKey($zoneName,-1))
			{
				// self::$zoneCaches[$zoneName]=array();
				continue;
			}

			$zoneData=json_decode($zoneData,true);

			$totalPlugin=count($zoneData);

			for($j=0;$j < $totalPlugin;$j++)
			{
				if((int)$zoneData[$j]['status']==0)
				{
					unset($zoneData[$j]);
				}
			}

			sort($zoneData);

			self::$zoneCaches[$zoneName]=$zoneData;

		}

		Cache::saveKey('zoneCaches',json_encode(self::$zoneCaches));

		unset($zoneData);

		unset($zoneNames);
	}




}
?>
