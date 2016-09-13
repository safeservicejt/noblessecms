<?php

class controlNpanel
{
	public static function index()
	{
		self::before_npanel_start();

		$func='home';

		if($match=Uri::match('^\/?npanel\/(\w+)'))
		{
			$func=$match[1];
		}

		if($func=='login' || $func=='register' || $func=='logout' || $func=='forgotpassword' || $func=='resendverify')
		{
			self::$func();
		}
		else
		{
			if(!Users::hasLogin())
			{
				Redirects::to(System::getUrl().'npanel/login');
			}		

			$method='index';

			if($match=Uri::match('^\/?npanel\/(\w+)\/(\w+)'))
			{
				$method=$match[2];
			}	



			Controllers::load(ucfirst($func),$method,'application/npanel');
		}
		

		
	}

	public static function before_npanel_start()
	{
		// Load plugins
		Plugins::load('before_npanel_start');

	}	

	public static function logout()
	{
        Users::logout();

        Redirects::to(System::getUrl().'npanel');		
	}
	
	public static function register()
	{
		$pageData=array('alert'=>'','captchaHTML'=>'');

		if(Request::has('btnLogin'))
		{
			try {
				Users::makeLogin(Request::get('send.username',''),Request::get('send.password',''));

				Redirects::to(System::getUrl().'npanel');
			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}
		
       	$pageData['captchaHTML']='';

        if(System::getSetting('system_captcha')=='enable')
        {
            $pageData['captchaHTML']=Captcha::makeForm();
        }

		Views::make('headNon');

		Views::make('login',$pageData);

		Views::make('footerNon');

	}
	
	public static function forgotpassword()
	{
		$pageData=array('alert'=>'','captchaHTML'=>'');

		if(Request::has('btnSend'))
		{
			try {
				Users::makeLogin(Request::get('send.username',''),Request::get('send.password',''));

				Redirects::to(System::getUrl().'npanel');
			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}
		
       	$pageData['captchaHTML']='';

        if(System::getSetting('system_captcha')=='enable')
        {
            $pageData['captchaHTML']=Captcha::makeForm();
        }

		Views::make('headNon');

		Views::make('forgotpassword',$pageData);

		Views::make('footerNon');

	}
	
	public static function login()
	{
		$pageData=array('alert'=>'','captchaHTML'=>'');

		if(Request::has('btnLogin'))
		{
			try {
				Users::makeLogin(Request::get('send.username',''),Request::get('send.password',''));

				Redirects::to(System::getUrl().'npanel');
			} catch (Exception $e) {
				$pageData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

       	$pageData['captchaHTML']='';

        if(System::getSetting('system_captcha')=='enable')
        {
            $pageData['captchaHTML']=Captcha::makeForm();
        }

		Views::make('headNon');

		Views::make('login',$pageData);

		Views::make('footerNon');

	}


}
