<?php

class controlLogin
{
	public function index()
	{
        $postData=array('alert'=>'');

        Model::load('admincp/login');

        // if(Session::has('userid'))
        // {
        //     Redirect::to(System::getAdminUrl());
        // }

        if(Request::has('btnLogin'))
        {
            try {

                loginProcess();

                Redirect::to(System::getAdminUrl());
                
            } catch (Exception $e) {
                $postData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
            }
        }

        if(Request::has('provider'))
        {
            $provider_name = $_REQUEST["provider"];
             
            try
            {
                // inlcude HybridAuth library
                // change the following paths if necessary
                $config   = ROOT_PATH . 'includes/extentions/hybridauth/config.php';
                require_once( ROOT_PATH . "includes/extentions/hybridauth/Hybrid/Auth.php" );

                // initialize Hybrid_Auth class with the config file
                $hybridauth = new Hybrid_Auth( $config );
         
                // try to authenticate with the selected provider
                $adapter = $hybridauth->authenticate( $provider_name );
         
                // then grab the user profile
                $user_profile = $adapter->getUserProfile();
            }
         
            // something went wrong?
            catch( Exception $e )
            {
                Redirect::to(System::getUrl().'admincp');
            }

            // print_r($user_profile);die();

            $email=$user_profile->email;

            if(!isset($email[4]))
            {
                Redirect::to(System::getUrl().'admincp');
            }
         
            // check if the current user already have authenticated using this provider before
            // $user_exist = get_user_by_provider_and_id( $provider_name, $user_profile->identifier );

            $loadUser=Users::get(array(
                'cache'=>'no',
                'where'=>"where email='$email'"
                ));

            if(!isset($loadUser[0]['email']))
            {
                $username=String::randText(10);

                $password=String::randNumber(6);

                $insertData=array(
                    'email'=>$email,
                    'username'=>$username,
                    'password'=>$password,
                    'firstname'=>'Your',
                    'lastname'=>'Name'
                    );
                
                try {
                    Users::makeRegister($insertData);

                    Users::makeLogin($username,$password);

                    $_SESSION["user_connected"] = true;

                    Redirect::to(System::getUrl().'admincp');                    
                } catch (Exception $e) {
                    $postData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
                }                
            }
         
            // set the user as connected and redirect him

        }

        $postData['captchaHTML']=Captcha::makeForm();

        System::setTitle('Login - '.ADMINCP_TITLE);
        
		View::make('admincp/headNonSB');

		View::make('admincp/login',$postData);

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

?>