<?php

class themeContactus
{
	public function index()
	{
		// Cache::loadPage(30);

		$inputData=array('alert'=>'');

		Model::loadWithPath('contactus',System::getThemePath().'model/');

		if(Request::has('btnSend'))
		{
			try {
				contactProcess();
				$inputData['alert']='<div class="alert alert-success">Send contact success.</div>';
			} catch (Exception $e) {
				$inputData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		System::setTitle('Contact us');
		
		$themePath=System::getThemePath().'view/';

		View::makeWithPath('head',array(),$themePath);

		View::makeWithPath('contactus',$inputData,$themePath);

		View::makeWithPath('footer',array(),$themePath);

	}



}

?>