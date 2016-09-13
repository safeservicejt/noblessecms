<?php


Shortcode::flyAdd('flash','shortcode_flash');

function shortcode_flash($inputData=array())
{
	$value=isset($inputData['value'])?$inputData['value']:'';

  $responsive=isset($inputData['attr']['responsive'])?' flash-responsive ':'';

	$width=isset($inputData['attr']['width'])?$inputData['attr']['width']:800;

	$height=isset($inputData['attr']['height'])?$inputData['attr']['height']:600;

	$id=isset($inputData['attr']['id'])?' id="'.$inputData['attr']['id'].'" ':'';

	$class=isset($inputData['attr']['class'])?' class="'.$inputData['attr']['class'].' '.$responsive.'" ':'';


	return '   
	<div '.$id.$class.'>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
            codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0"
            width="'.$width.'" height="'.$height.'" id="gamefile" align="middle">
        <param name="allowScriptAccess" value="always" />
        <param name="movie" value="'.$value.'" />
        <param name="quality" value="high" />
        <param name="wmode" value="window" />
        <param name="allowfullscreen" value="" />
        <param name="allowfullscreeninteractive" value="false" />
        <param name="fullScreenAspectRatio" value="" />
        <param name="quality" value="" />
        <param name="play" value="true" />
        <param name="loop" value="true" />
        <param name="menu" value="" />
        <param name="flashvars" value="gameID=17865" />
        <param name="hasPriority" value="true" />
        <embed src="'.$value.'"
               quality="high"
               width="'.$width.'"
               height="'.$height.'"
               id="gamefileEmbed"
               name="gamefile"
               align="middle"
               wmode="window"
               allowfullscreen=""
               allowfullscreeninteractive="false"
               fullScreenAspectRatio=""
               quality=""
               play="true"
               loop="true"
               menu=""
               allowScriptAccess="always"
               flashvars=""
               hasPriority="true"
               type="application/x-shockwave-flash"
               pluginspage="http://www.adobe.com/go/getflashplayer"></embed>
    </object>
    </div>
    ';	
}
