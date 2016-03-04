<?php

class Autothumb
{
	// Return image path: uploads/images/thumbnail/1/1_150x150.jpg
	public static function get($inputData=array())
	{
		$path=$inputData['path'];

		$postid=$inputData['postid'];

		$result='';

		if(!is_dir(ROOT_PATH.$path.$postid))
		{
			Dir::create(ROOT_PATH.$path.$postid);
		}

		$fileName=$postid.'_'.$inputData['width'].'x'.$inputData['height'].'.jpg';

		$filePath=$path.$postid.'/'.$fileName;

		if(!file_exists(ROOT_PATH.$filePath))
		{
			$result=self::make($inputData);
		}
		else
		{
			$result=$filePath;
		}

		return $result;
	}


	public static function make($inputData=array())
	{
		$image=isset($inputData['image'][6])?$inputData['image']:'contents/plugins/autopostthumb/images/nothumbnail.jpg';

		$shortPath='uploads/images/thumbnail/'.$inputData['postid'].'/'.$inputData['postid'].'_'.$inputData['width'].'x'.$inputData['height'].'.jpg';

		$shortPath=trim($shortPath);

		if(preg_match('/.*?\.(png|gif|jpeg)$/i', $shortPath))
		{
			$tmpPath='uploads/images/thumbnail/'.$inputData['postid'].'/tmp.jpg';

			$imorig='';

	        $gis = getimagesize(ROOT_PATH.$image);
	        $type = $gis[2];
	        switch ($type) {
	            case "1":
	                $imorig = imagecreatefromgif(ROOT_PATH.$image);
	                break;
	            case "2":
	                $imorig = imagecreatefromjpeg(ROOT_PATH.$image);
	                break;
	            case "3":
	                $imorig = imagecreatefrompng(ROOT_PATH.$image);
	                break;
	            default:
	                $imorig = imagecreatefromjpeg(ROOT_PATH.$image);
	        }

	        imagejpeg($imorig, ROOT_PATH.$tmpPath);

	        $image=$tmpPath;
		}



		$descPath=ROOT_PATH.$shortPath;

		$width=$inputData['width'];

		$height=((int)$inputData['height']==0)?$width:$inputData['height'];

		// Image::cropCenter(ROOT_PATH.$image,$width,$height,$descPath);
		Image::reSize(ROOT_PATH.$image,$width,$height,$descPath);

		return $shortPath;
	}
}
