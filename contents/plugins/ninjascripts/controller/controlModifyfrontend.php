<?php

class controlModifyfrontend
{
	private static $thisPath='';
	public function index()
	{
		self::$thisPath=ROOT_PATH.'contents/plugins/ninjascripts/';

		$post=array('alert'=>'');

		Model::setPath(self::$thisPath.'model/');
		Model::load('admincp');
		Model::resetPath();

		if($match=Uri::match('\/ninjascripts\/(\w+)'))
		{
			if(method_exists("controlModifyfrontend", $match[1]))
			{	
				$method=$match[1];

				$this->$method();
				
				die();
			}
			
		}

		if(Request::has('btnSave'))
		{
			try {
				saveDataProcess('siteHeader',Request::get('send.site_header'));
				saveDataProcess('siteFooter',Request::get('send.site_footer'));

				$post['alert']='<div class="alert alert-success">Save changes success.</div>';


			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		$post['header']=stripslashes(Cache::loadKey('ninjascripts/'.Database::getPrefix().'siteHeader',-1));
		
		$post['footer']=stripslashes(Cache::loadKey('ninjascripts/'.Database::getPrefix().'siteFooter',-1));

		self::makeContent('frontEndView',$post);

	}


	public function makeContent($keyName='',$post=array())
	{	
		View::makeWithPath($keyName,$post,ROOT_PATH.'contents/plugins/ninjascripts/views/');	
	}

}

$run=new controlModifyfrontend();

$run->index();


?>