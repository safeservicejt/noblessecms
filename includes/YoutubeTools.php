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

		$thumbnail_url = $title = $url_encoded_fmt_stream_map = $type = $url = '';
		parse_str($content);
		
		$my_formats_array = explode(',',$url_encoded_fmt_stream_map);

		$avail_formats[] = '';
		$i = 0;
		$ipbits = $ip = $itag = $sig = $quality = '';
		$expire = time(); 

		$mp4Url='';

		foreach($my_formats_array as $format) {
			parse_str($format);
			$avail_formats[$i]['itag'] = $itag;
			$avail_formats[$i]['quality'] = $quality;
			$type = explode(';',$type);
			$avail_formats[$i]['type'] = $type[0];
			$avail_formats[$i]['url'] = urldecode($url) . '&signature=' . $sig;
			parse_str(urldecode($url));
			$avail_formats[$i]['expires'] = date("G:i:s T", $expire);
			$avail_formats[$i]['ipbits'] = $ipbits;
			$avail_formats[$i]['ip'] = $ip;

			if($type[0]=='video/mp4')
			{
				$mp4Url=$avail_formats[$i]['url'];
			}

			$i++;
		}

		return $mp4Url;
	}
}

?>