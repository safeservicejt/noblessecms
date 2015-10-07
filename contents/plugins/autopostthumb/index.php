<?php

Plugins::install('install_autopostthumb');

Plugins::uninstall('uninstall_autopostthumb');

function install_autopostthumb()
{
	Dir::remove(CACHES_PATH.'dbcache/system/autothumb');
	
	Dir::remove(CACHES_PATH.'autothumb');

	Dir::create(CACHES_PATH.'dbcache/system/autothumb');

	Dir::remove(ROOT_PATH.'uploads/images/thumbnail');

	Dir::remove(ROOT_PATH.'uploads/images/crop');

	Dir::create(ROOT_PATH.'uploads/images/thumbnail');

	Dir::create(ROOT_PATH.'uploads/images/crop');

	$installPath=dirname(__FILE__).'/install/';

	$dbFile=$installPath.'db.sql';

	if(file_exists($dbFile))
	{
		Database::import($dbFile);
	}

	$dbFile=$installPath.'update.sql';

	if(file_exists($dbFile))
	{
		Database::import($dbFile);
	}


	Route::add('autothumb','autopostthumb_make');
	Route::add('autocropcenter','autopostcropcenter_make');

}

function autopostcropcenter_make()
{


	$result='';

	$inputData=array();

	$uri=System::getUri();

	$noimg=System::getUrl().'contents/plugins/autopostthumb/images/nothumbnail.jpg';

	$fromContent='no';

	if(!$match=Uri::match('autocropcenter\/post_(\d+)_(\d+)x(\d+)\.jpg'))
	{
		if($match=Uri::match('autocropcenter\/post_content_(\d+)_(\d+)x(\d+)\.jpg'))
		{
			$fromContent='yes';
		}
		else
		{
			Redirect::to($noimg,301);

			exit;			
		}

	}

	$postid=(int)$match[1];

	$imgW=(int)$match[2];

	$imgH=(int)$match[3];

	if($postid==0 || $imgW==0)
	{
		Redirect::to($noimg,301);

		exit;		
	}

	$filePath='uploads/images/crop/'.$postid.'_'.$imgW.'x'.$imgH.'.jpg';

	if(file_exists(ROOT_PATH.$filePath))
	{
		Redirect::to(System::getUrl().$filePath,301);

		exit;
	}

	$postData=Post::get(array(
		'cacheTime'=>60,
		'isHook'=>'no',
		'where'=>"where postid='$postid'"
		));


	if(!isset($postData[0]['postid']))
	{
		Redirect::to($noimg,301);

		exit;		
	}

	$imagePath=$postData[0]['image'];

	if($fromContent=='yes')
	{
		if(!preg_match('/(http[a-zA-Z0-9_\-\.\:\/\(\)\&\@\!\#\$]+\.(jpg|png))/i', $postData[0]['content'], $matches))
		{
			Redirect::to($noimg,301);

			exit;			
		}
		else
		{
			$imgData=Http::getDataUrl($matches[1]);

			if($imgData!=false)
			{
				$savePath='uploads/images/crop/';

				$imagePath=$savePath.basename($matches[1]);

				File::create(ROOT_PATH.$imagePath,$imgData);
			}
			else
			{
				Redirect::to($noimg,301);

				exit;				
			}


		}
	}
	
	if(preg_match('/.*?\.(png|gif|jpg|jpeg)/i', $imagePath))
	{
		$data=Image::getSize(ROOT_PATH.$imagePath);

		if((int)$imgW >= (int)$data['width'])
		{
			Redirect::to(System::getUrl().$imagePath,301);

			exit;	
		}

	}


	$shortPath='uploads/images/crop/';

	$inputData['data']=$postData[0];

	$inputData['postid']=$postid;

	$inputData['width']=$imgW;

	$inputData['height']=$imgH;

	$inputData['path']=$shortPath;

	// $fileName=$postid.'_'.$imgW.'x'.$imgH.'.jpg';

	// $imgPath=$filePath.$fileName;

	$image=$imagePath;

	$descPath=ROOT_PATH.$filePath;

	File::create($descPath,'');

	copy(ROOT_PATH.$image, $descPath);

	// Image::cropCenter(ROOT_PATH.$image,$width,$height,$descPath);
	Image::cropCenter(ROOT_PATH.$image,$imgW,$imgH,$descPath);

	$result=System::getUrl().$filePath;
	
	Redirect::to($result,301);

	exit;
}

function autopostthumb_make()
{


	$result='';

	$inputData=array();

	$uri=System::getUri();

	$noimg=System::getUrl().'contents/plugins/autopostthumb/images/nothumbnail.jpg';

	$fromContent='no';

	if(!$match=Uri::match('autothumb\/post_(\d+)_(\d+)x(\d+)\.jpg'))
	{
		if($match=Uri::match('autothumb\/post_content_(\d+)_(\d+)x(\d+)\.jpg'))
		{
			$fromContent='yes';
		}
		else
		{
			Redirect::to($noimg,301);

			exit;			
		}
	}

	$postid=(int)$match[1];

	$imgW=(int)$match[2];

	$imgH=(int)$match[3];

	if($postid==0 || $imgW==0)
	{
		Redirect::to($noimg,301);

		exit;		
	}



	$filePath='uploads/images/thumbnail/'.$postid.'_'.$imgW.'x'.$imgH.'.jpg';

	if(file_exists(ROOT_PATH.$filePath))
	{
		Redirect::to(System::getUrl().$filePath,301);

		exit;
	}

	$postData=Post::get(array(
		'cacheTime'=>60,
		'isHook'=>'no',
		'where'=>"where postid='$postid'"
		));


	if(!isset($postData[0]['postid']))
	{
		Redirect::to($noimg,301);

		exit;		
	}

	$imagePath=$postData[0]['image'];

	if($fromContent=='yes')
	{
		if(!preg_match('/(http[a-zA-Z0-9_\-\.\:\/\(\)\&\@\!\#\$]+\.(jpg|png))/i', $postData[0]['content'], $matches))
		{
			Redirect::to($noimg,301);

			exit;			
		}
		else
		{
			$imgData=Http::getDataUrl($matches[1]);

			if($imgData!=false)
			{
				$savePath='uploads/images/thumbnail/';

				$imagePath=$savePath.basename($matches[1]);

				File::create(ROOT_PATH.$imagePath,$imgData);				
			}
			else
			{
				Redirect::to($noimg,301);

				exit;				
			}

		}
	}


	if(preg_match('/.*?\.(png|gif|jpg|jpeg)/i', $imagePath))
	{
		$data=Image::getSize(ROOT_PATH.$imagePath);

		if((int)$imgW >= (int)$data['width'])
		{
			Redirect::to(System::getUrl().$imagePath,301);

			exit;	
		}

	}


	$shortPath='uploads/images/thumbnail/';

	$inputData['data']=$postData[0];

	$inputData['postid']=$postid;

	$inputData['width']=$imgW;

	$inputData['height']=$imgH;

	$inputData['path']=$shortPath;

	// $fileName=$postid.'_'.$imgW.'x'.$imgH.'.jpg';

	// $imgPath=$filePath.$fileName;

	$image=$imagePath;

	$descPath=ROOT_PATH.$filePath;

	$width=$imgW;

	$height=((int)$imgH==0)?'auto':$imgH;

	File::create($descPath,'');

	copy(ROOT_PATH.$image, $descPath);

	// Image::cropCenter(ROOT_PATH.$image,$width,$height,$descPath);
	Image::reSize(ROOT_PATH.$image,$imgW,$imgH,$descPath);

	$result=System::getUrl().$filePath;

	Redirect::to($result,301);

	exit;
}


function uninstall_autopostthumb()
{	

	Dir::remove(ROOT_PATH.'uploads/images/thumbnail');

	Dir::remove(ROOT_PATH.'uploads/images/crop');

	Dir::remove(CACHES_PATH.'dbcache/system/autothumb');
	
	Dir::remove(CACHES_PATH.'autothumb');

}

?>