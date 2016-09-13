<?php


Shortcode::flyAdd('youtube','shortcode_youtube');


function shortcode_youtube($inputData=array())
{
	$value=isset($inputData['value'])?$inputData['value']:'';

	$autoplay=isset($inputData['attr']['autoplay'])?'?autoplay=1':'';

	return '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$value.$autoplay.'" frameborder="0" allowfullscreen></iframe></div>';	
}
