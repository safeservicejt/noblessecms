<?php

class YoutubeTools
{
	public static function getMp4Url($id='')
	{	
		if(!isset($id[4]))
		{
			return false;
		}


		$url = 'http://youtube.com/get_video_info?video_id='.$id;
		$key = 'url_encoded_fmt_stream_map';
		$content = file_get_contents($url);
		parse_str($content, $result);

		$data=urldecode($result['url_encoded_fmt_stream_map']);

		$li='';

		if(preg_match('/^url=(.*?)\,url=/i', $data,$match))
		{
			$li=$match[1];
		}
		else
		{
			$parse=explode('&url=', $data);

			$li=$parse[1].'&'.$parse[0];
		}

		return $li;
	}
}

?>