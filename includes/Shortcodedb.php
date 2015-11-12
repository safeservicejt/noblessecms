<?php

function system_shortcode_list()
{
	$outData=array(
		'youtube'=>'shortcode_youtube',
		
		'video'=>'shortcode_youtube',

		'link'=>'shortcode_url',
		'url'=>'shortcode_url',

		'img'=>'shortcode_img'
		);


	return $outData;
}

function shortcode_img($inputData=array())
{
	$value=$inputData['value'];

	$id=isset($inputData['attr']['id'])?' id="'.$inputData['attr']['id'].'" ':'';

	$responsive=isset($inputData['attr']['responsive'])?' img-responsive ':'';

	$class=isset($inputData['attr']['class'])?' class="'.$inputData['attr']['class'].' '.$responsive.'" ':'';

	$target=isset($inputData['attr']['target'])?' target="'.$inputData['attr']['target'].'" ':'';

	$alt=isset($inputData['attr']['alt'])?' alt="'.$inputData['attr']['alt'].'" ':'';

	return '<img src="'.$value.'" '.$id.$class.$target.$alt.' />';	
}

function shortcode_url($inputData=array())
{
	$id=isset($inputData['attr']['id'])?' id="'.$inputData['attr']['id'].'" ':'';

	$class=isset($inputData['attr']['class'])?' class="'.$inputData['attr']['class'].'" ':'';

	$target=isset($inputData['attr']['target'])?' target="'.$inputData['attr']['target'].'" ':'';

	$href=isset($inputData['attr']['href'])?' href="'.$inputData['attr']['href'].'" ':'';

	$value=isset($inputData['value'])?$inputData['value']:$href;

	return '<a '.$href.$id.$class.$target.'>'.$value.'</a>';	
}

function shortcode_youtube($inputData=array())
{
	$value=$inputData['value'];

	return '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$value.'" frameborder="0" allowfullscreen></iframe></div>';	
}

?>