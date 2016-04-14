<?php

class controlRegister
{
	public function index()
	{

        if(System::$setting['register_user_status']!='enable')
        {
            Alert::make('We not allow for register account at this time.');
        }

        CustomPlugins::load('before_register_user');

        $postData=array('alert'=>'');

        Model::load('admincp/register');

        // if(Session::has('userid'))
        // {
        //     Redirect::to(System::getAdminUrl());
        // }

        if(Request::has('btnRegister'))
        {
            try {

                registerProcess();

                $postData['alert']='<div class="alert alert-success">Success. Your account '.Request::get('send.username').' and password '.Request::get('send.password').' have been create completed.</div>';

                // Redirect::to(System::getAdminUrl());
                
            } catch (Exception $e) {
                $postData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
            }
        }

        $postData['captchaHTML']='';
        
        if(System::getSetting('system_captcha')=='enable')
        {
            $postData['captchaHTML']=Captcha::makeForm();

        }

        System::setTitle('Register Account - '.ADMINCP_TITLE);
        
		View::make('admincp/headNonSB');

		View::make('admincp/registerView',$postData);

		View::make('admincp/footerNonSB');

	}
    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/nav');
                
        View::make('admincp/left');  
              
        View::make('admincp/startContent');

        View::make('admincp/'.$viewPath,$inputData);

        View::make('admincp/endContent');
         // View::make('admincp/right');

    }
}
