<?php

function settingProcess()
{
	$send=Request::get('send');

	Theme::saveSetting('cleanwp',$send);

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

				Theme::saveSetting('cleanwp',$send);
			
		}
	}



}

?>