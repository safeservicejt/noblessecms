<?php

function system_shortcode_list()
{
	$outData=array(
		'youtube'=>'shortcode_youtube',
		
		'video'=>'shortcode_youtube'
		);


	return $outData;
}

function shortcode_youtube($inputData=array())
{
	$value=$inputData['value'];

	return '<a href="http://youtube.com?v='.$value.'">Click to watch video</a>';	
}

?>