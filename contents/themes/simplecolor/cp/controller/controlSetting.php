<?php

$themePath=THEMES_PATH.'simplecolor/cp/';

$pageData=array('alert'=>'');

$alert='';

Model::loadWithPath('settingModel',$themePath.'model/');

if(Request::has('btnSend'))
{
	try {
		settingProcess();

		$alert='<div class="alert alert-success">Save changes success.</div>';

	} catch (Exception $e) {
		$alert='<div class="alert alert-warning">Error: '.$e->getMessage().'</div>';
	}
}

// $pageData=array();

$pageData=loadSetting();

$pageData['alert']=$alert;

// print_r($pageData);die();

View::makeWithPath('head',array(),$themePath.'view/');

View::makeWithPath('left',array(),$themePath.'view/');

View::makeWithPath('settingView',$pageData,$themePath.'view/');

?>