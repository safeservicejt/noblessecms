<?php

/*Shortcode
Title: Youtube Shortcode
Description: Show youtube video.
Code: youtube
*/

// Shortcode::templateAdd('youtube','simple_youtube_parse');


function simple_youtube_parse($inputData=array())
{
	$value=$inputData['value'];

	return '<a href="http://youtube.com?v='.$value.'">Click to watch video</a>';
}

?>