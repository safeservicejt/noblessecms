<?php

class controlHome
{
	public function index()
	{

		$pageData=array('alert'=>'');

		$alert='';


		if(Request::has('btnSend'))
		{
			try {
				settingProcess();

				$send_categories=Request::get('send_categories');

				if(isset($send_categories[0]))
				{
					$saveData=array(
						'site_homepage_categories_content'=>$send_categories
						);			
						
					saveSetting($saveData);
				}


				$alert='<div class="alert alert-success">Save changes success.</div>';

			} catch (Exception $e) {
				$alert='<div class="alert alert-warning">Error: '.$e->getMessage().'</div>';
			}
		}

		// $pageData=array();

		$pageData=loadSetting();

		$pageData['categories']=Categories::get(array(
			'cache'=>'no',
			'orderby'=>'order by title asc'
			));

		$pageData['list_category']=$pageData['site_homepage_categories_content'];

		$pageData['alert']=$alert;

		CtrTheme::admincpHeader();

		CtrTheme::admincpLeft();

		CtrTheme::view('head');

		CtrTheme::view('left');

		CtrTheme::view('homepageView',$pageData);

		CtrTheme::admincpFooter();
	}


}
?>