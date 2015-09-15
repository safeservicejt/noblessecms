<?php

function system_shortcode_list()
{
	$outData=array(
		'youtube'=>'shortcode_youtube',
		
		'video'=>'shortcode_youtube',

		'link'=>'shortcode_url',

		'img'=>'shortcode_img'
		);


	return $outData;
}

function shortcode_img($inputData=array())
{
	$value=$inputData['value'];

	$id=isset($inputData['attr']['id'])?' id="'.$inputData['attr']['id'].'" ':'';

	$class=isset($inputData['attr']['class'])?' class="'.$inputData['attr']['class'].'" ':'';

	$target=isset($inputData['attr']['target'])?' target="'.$inputData['attr']['target'].'" ':'';

	$href=isset($inputData['attr']['href'])?' href="'.$inputData['attr']['href'].'" ':'';

	$alt=isset($inputData['attr']['alt'])?' alt="'.$inputData['attr']['alt'].'" ':'';

	return '<img src="'.$value.'" '.$id.$class.$target.$alt.' />';	
}

function shortcode_url($inputData=array())
{
	$value=$inputData['value'];

	$id=isset($inputData['attr']['id'])?' id="'.$inputData['attr']['id'].'" ':'';

	$class=isset($inputData['attr']['class'])?' class="'.$inputData['attr']['class'].'" ':'';

	$target=isset($inputData['attr']['target'])?' target="'.$inputData['attr']['target'].'" ':'';

	$href=isset($inputData['attr']['href'])?' href="'.$inputData['attr']['href'].'" ':'';

	return '<a href="'.$href.'" '.$id.$class.$target.'>'.$value.'</a>';	
}

function shortcode_youtube($inputData=array())
{
	$value=$inputData['value'];

	return '<a href="http://youtube.com?v='.$value.'">Click to watch video</a>';	
}

?>