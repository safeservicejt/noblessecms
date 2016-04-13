<?php

class controlGeneral
{
	public function index()
	{

		CtrTheme::model('home');

		$pageData=array('alert'=>'');

		$alert='';


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

		CtrTheme::admincpHeader();

		CtrTheme::admincpLeft();

		CtrTheme::view('head');

		CtrTheme::view('left');

		CtrTheme::view('general',$pageData);

		CtrTheme::admincpFooter();
	}

}
?>