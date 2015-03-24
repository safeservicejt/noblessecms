<?php

class usercp
{
    function __construct()
    {
        GlobalCMS::startUserCP();
        // print_r(Plugins::$adminzoneCaches);
        // die();

        
    }
    //Default func will be load when call to this controller
    public function index()
    {
        $post=array('title'=>ADMINCP_TITLE);
                
        $this->checkLogin();

        // Model::load('admincp/news');

        // Model::load('admincp/usergroups');

        View::make('usercp/head',$post);
   
        $this->makeContents('dashboard');

        View::make('usercp/footer');    

    }

    public function makeContents($viewPath,$inputData=array())
    {

        View::make('usercp/nav');
                
        View::make('usercp/left');  
              
        View::make('usercp/startContent');

        View::make('usercp/'.$viewPath,$inputData);

        View::make('usercp/endContent');
         // View::make('admincp/right');

    }

    // Ecommerce
    public function getProducts()
    {
        $this->checkLogin();

         Controller::load('usercp/controlProducts');                  
    }
    public function getRequestpayment()
    {
        $this->checkLogin();

         Controller::load('usercp/controlRequestpayment');                  
    }

    public function getOrders()
    {
        $this->checkLogin();

         Controller::load('usercp/controlOrders');                  
    }
    public function getPayments()
    {
        $this->checkLogin();

         Controller::load('usercp/controlPayments');                  
    }


    // End ecommerce

    public function getApi()
    {
        $this->checkLogin();

         Controller::load('usercp/controlApi');                  
    }

    public function getCategories()
    {
        $this->checkLogin();

        Controller::load('usercp/controlCategories');   
    }
    public function getPages()
    {
        $this->checkLogin();

        Controller::load('usercp/controlPages');   
    }
    public function getNews()
    {
        $this->checkLogin();

        Controller::load('usercp/controlNews');   
    }
     public function getComments()
    {
        $this->checkLogin();

        Controller::load('usercp/controlComments');   
    }
    public function getPlugins()
    {
        $this->checkLogin();

        Controller::load('usercp/controlPlugins');   
    } 
    public function getUsers()
    {
        $this->checkLogin();

        Controller::load('usercp/controlUsers');   
    } 
    public function getGetfile()
    {
        $this->checkLogin();

        Controller::load('usercp/controlGetfile');   
    } 

    public function getLogout()
    {

      Cookie::destroy('username');
      Cookie::destroy('password');
      
      Session::forget('userid');

      Redirect::to('usercp/login');

    }
    public function getForgotpassword()
    {
        Controller::load('usercp/forgotpassword');  
    }

    public function checkLogin()
    {
       Model::load('usercp/login');

       if(!isLogin())
       {
            Redirect::to('usercp/login/');
            die();
       }
    }

    public function getRegister()
    {
        if((int)GlobalCMS::$setting['enable_register']==0)
        {
            Alert::make('We not allow register new account at this time.');
        }

        $post=array('title'=>ADMINCP_TITLE);
        $post['alert']='';
        //Call to model 'login'
        Model::load('usercp/register');

        if(Request::has('btnRegister'))
        {
            $valid=processRegister();

            $post['alert']=$valid;
        }

        View::make('usercp/headRegister',$post);

        View::make('usercp/register',$post);
    }


    public function getLogin()
    {
        $post=array('title'=>ADMINCP_TITLE);


        //Call to model 'login'
        Model::load('usercp/login');

//        Cache::enable(15);

        View::make('usercp/headLogin',$post);

        if (!isLogin()) {

            $alert = '';
            //If click onto login button
            if (Request::has('btnLogin')) {
 
                if (isUser(Request::get('email'), Request::get('password'))) {

                Redirect::to('usercp');

                } else {
                    $alert = '<div class="alert alert-danger">Wrong. Check login info again!</div>';
                }


            }

            View::make('usercp/login', array('alert' => $alert));
        }
        else
        {

            Redirect::to('usercp');
            die();
        }

    }
}

?>