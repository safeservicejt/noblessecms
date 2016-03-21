<?php

class controlAdmincp
{
	public function index()
	{
		$controlName='admincp/controlDashboard';

		CustomPlugins::load('before_admincp_start');

		if(Cookie::has('userid'))
		{
			$groupid=Users::getCookieGroupId();

			if((int)$groupid > 0)
			{
				$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_view_admincp');

				if($valid!='yes')
				{
					Alert::make('You not have permission to view this page');
				}				
			}

			// Auto load global data

			$loadPath=ROOT_PATH.'bootstrap/css/global/';

			if(is_dir($loadPath))
			{
				$loadData=Dir::listFiles($loadPath.'admincp/');

				if(isset($loadData[0]))
				{
					$total=count($loadData);

					$result=array();

					$li='';
					
					if(!System::issetVar('cssGlobal'))
					{
						System::defineVar('cssGlobal',array());	
					}

					if((int)$total > 0)
					{
						for ($i=0; $i < $total; $i++) { 

							if(!preg_match('/.*?\.css/i', $loadData[$i]))
							{
								continue;
							}

							$li='<script src="'.ROOT_URL.'bootstrap/css/global/admincp/'.$loadData[$i].'"></script>';

							System::pushVar('cssGlobal',$li);
						}
					}
				}				
			}
			// Auto load global data

			// Auto load global data
			$loadPath=ROOT_PATH.'bootstrap/js/global/';

			if(is_dir($loadPath))
			{
				$loadData=Dir::listFiles($loadPath.'admincp/');

				if(isset($loadData[0]))
				{
					$total=count($loadData);

					$result=array();

					$li='';

					if((int)$total > 0)
					{
						if(!System::issetVar('jsGlobal'))
						{
							System::defineVar('jsGlobal',array());	
						}

						for ($i=0; $i < $total; $i++) { 

							if(!preg_match('/.*?\.js/i', $loadData[$i]))
							{
								continue;
							}

							$li='<script src="'.ROOT_URL.'bootstrap/js/global/admincp/'.$loadData[$i].'"></script>';

							System::pushVar('jsGlobal',$li);
						}
					}
				}				
			}


			// Auto load global data

			$uriStr=System::getUri();
			
			$pageName='dashboard';
			
			if(preg_match('/admincp\/(\w+)/i',$uriStr,$match))
			{
				$pageName=$match[1];
			}
			
			$controlName='admincp/control'.ucfirst($pageName);

			$funcName='index';

			$default_adminpage_method=trim(System::getSetting('default_adminpage_method','none'));
			

			if($default_adminpage_method=='url')
			{
				$default_adminpage=trim(System::getSetting('default_adminpage_url','admincp/'));

				if($default_adminpage!='admincp/' && System::getUri()=='admincp/')
				{
					$beginUri='admincp';

					if($default_adminpage[0]!='/')
					{
						$beginUri.='/';
					}
				
					

					System::setUri($beginUri.$default_adminpage);
				}
			}

			if($match=Uri::match('^\/?admincp\/(\w+)'))
			{
				$controlName='admincp/control'.ucfirst($match[1]);

			}	

			if($match=Uri::match('^\/?admincp\/plugins\/privatecontroller\/(\w+)\/(\w+)'))
			{
				$funcName='privatecontroller';
			}	

		}
		else
		{
			$controlName='admincp/controlLogin';

			if($match=Uri::match('^\/?admincp\/forgotpass'))
			{
				$controlName='admincp/controlForgotpass';
			}	
			if($match=Uri::match('^\/?admincp\/register'))
			{
				$controlName='admincp/controlRegister';
			}	

		}


		$codeHead=Plugins::load('admincp_header');

		$codeHead=is_array($codeHead)?'':$codeHead;

		$codeFooter=Plugins::load('admincp_footer');

		$codeFooter=is_array($codeFooter)?'':$codeFooter;

		if(!System::issetVar('admincp_header'))
		{
			System::defineGlobalVar('admincp_header',$codeHead);
		}
		else
		{
			System::pushVar('admincp_header',$codeHead);
		}

		if(!System::issetVar('admincp_footer'))
		{
			System::defineGlobalVar('admincp_footer',$codeFooter);
		}
		else
		{
			System::pushVar('admincp_footer',$codeFooter);
		}

		Controller::load($controlName,$funcName);
	}
}