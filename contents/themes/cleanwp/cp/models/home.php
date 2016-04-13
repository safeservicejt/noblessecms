<?php

function settingProcess()
{
	$send=Request::get('send');

	saveSetting($send);

	$imgName=isset($_FILES['imgLogo']['name'])?$_FILES['imgLogo']['name']:'';

	if(isset($imgName[2]) && !preg_match('/^.*?\.(png|gif|jpe?g)$/i', $imgName))
	{
		throw new Exception("Only allow image file");
	}
	else
	{
		if(isset($imgName[2]))
		{
			$imgPath='uploads/images/'.Database::getPrefix().$imgName;

			if(move_uploaded_file($_FILES['imgLogo']['tmp_name'], ROOT_PATH.$imgPath))
			{
				$loadSize=filesize(ROOT_PATH.$imgPath);

				if((int)$loadSize > 1000000)
				{
					unlink(ROOT_PATH.$imgPath);

					throw new Exception('We not allow file large than 1MB.');
				}

				$send['site_logo']=$imgPath;
			}

				saveSetting($send);
			
		}
	}



}


function saveSetting($inputData=array())
{
	$total=count($inputData);

	if((int)$total > 0)
	{	
		$loadData=array();

		if($loadData=Cache::loadKey('dbcache/'.Database::getPrefix().'cleanwp',-1))
		{

			$loadData=unserialize($loadData);
		}

		$listKeys=array_keys($inputData);

		for ($i=0; $i < $total; $i++) { 
			$theKey=$listKeys[$i];

			$loadData[$theKey]=$inputData[$theKey];
		}

		$loadData=serialize($loadData);

		Cache::saveKey('dbcache/'.Database::getPrefix().'cleanwp',$loadData);
	}

}

function loadSetting()
{
	$default=array(
		'facebook_app_id'=>'',
		'theme_color'=>'green',
		'site_header_content'=>'',
		'site_home_top_content'=>'',
		'site_home_bottom_content'=>'',
		'site_right_top_content'=>'',
		'site_right_bottom_content'=>'',
		'site_left_content'=>'',
		'site_footer_content'=>'',
		'site_homepage_categories_content'=>'',

		'site_logo'=>System::getUrl().'contents/themes/cleanwp/images/logo.png'
		);

	if(!$loadData=Cache::loadKey('dbcache/'.Database::getPrefix().'cleanwp',-1))
	{
		File::create(ROOT_PATH.'application/caches/dbcache/'.Database::getPrefix().'cleanwp.cache',serialize($default));

		return $default;
	}

	$loadData=unserialize($loadData);

	$loadData['facebook_app_id']=isset($loadData['facebook_app_id'])?$loadData['facebook_app_id']:'675779382554952';


	$loadData['site_homepage_categories_content']=isset($loadData['site_homepage_categories_content'])?$loadData['site_homepage_categories_content']:'';

	$loadData['site_home_top_content']=isset($loadData['site_home_top_content'])?$loadData['site_home_top_content']:'';

	$loadData['site_home_bottom_content']=isset($loadData['site_home_bottom_content'])?$loadData['site_home_bottom_content']:'';

	$loadData['site_left_content']=isset($loadData['site_left_content'])?$loadData['site_left_content']:'';

	$loadData['site_right_top_content']=isset($loadData['site_right_top_content'])?$loadData['site_right_top_content']:'';

	$loadData['site_right_bottom_content']=isset($loadData['site_right_bottom_content'])?$loadData['site_right_bottom_content']:'';

	$loadData['site_footer_content']=isset($loadData['site_footer_content'])?$loadData['site_footer_content']:'';

	$loadData['site_header_content']=isset($loadData['site_header_content'])?$loadData['site_header_content']:'';

	$loadData['theme_color']=isset($loadData['theme_color'])?$loadData['theme_color']:'blue';

	$loadData['site_logo']=isset($loadData['site_logo'])?$loadData['site_logo']:System::getUrl().'contents/themes/cleanwp/images/logoweb.png';


	return $loadData;
}

?>