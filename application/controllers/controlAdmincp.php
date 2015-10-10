<?php

class controlAdmincp
{
	public function index()
	{
		$controlName='admincp/controlDashboard';

		Domain::checkAdminCP();

		if(Cookie::has('userid'))
		{
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_view_admincp');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}
			
			$controlName='admincp/controlDashboard';

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

			if($match=Uri::match('^admincp\/(\w+)'))
			{
				$controlName='admincp/control'.ucfirst($match[1]);
			}		
		}
		else
		{
			$controlName='admincp/controlLogin';

			if($match=Uri::match('^admincp\/forgotpass'))
			{
				$controlName='admincp/controlForgotpass';
			}			
		}

		$codeHead=Plugins::load('admincp_header');

		$codeHead=is_array($codeHead)?'':$codeHead;

		$codeFooter=Plugins::load('admincp_footer');

		$codeFooter=is_array($codeFooter)?'':$codeFooter;

		// print_r($codeHead);die();

		System::defineGlobalVar('admincp_header',$codeHead);

		System::defineGlobalVar('admincp_footer',$codeFooter);

		Controller::load($controlName);
	}
}

?>