<?php

class admincp
{
    function __construct()
    {
        GlobalCMS::startCP();
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

        View::make('admincp/head',$post);
   
        $this->makeContents('dashboard');

        View::make('admincp/footer');    

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
    
    public function getTemplatestore()
    {
        $this->checkLogin();

         Controller::load('admincp/controlTemplatestore');                  
    }
    public function getPluginstore()
    {
        $this->checkLogin();

         Controller::load('admincp/controlPluginstore');                  
    }

    // Ecommerce
    public function getEcommerce()
    {
        $this->checkLogin();

         Controller::load('admincp/controlEcommerce');                  
    }
    public function getProducts()
    {
        $this->checkLogin();

         Controller::load('admincp/controlProducts');                  
    }
    public function getRequestpayment()
    {
        $this->checkLogin();

         Controller::load('admincp/controlRequestpayment');                  
    }

    public function getCustomers()
    {
        $this->checkLogin();

         Controller::load('admincp/controlCustomers');                  
    }
    public function getDownloads()
    {
        $this->checkLogin();

         Controller::load('admincp/controlDownloads');                  
    }
    public function getManufacturers()
    {
        $this->checkLogin();

         Controller::load('admincp/controlManufacturers');                  
    }
    public function getReviews()
    {
        $this->checkLogin();

         Controller::load('admincp/controlReviews');                  
    }
    public function getOrders()
    {
        $this->checkLogin();

         Controller::load('admincp/controlOrders');                  
    }
    public function getPayments()
    {
        $this->checkLogin();

         Controller::load('admincp/controlPayments');                  
    }
    public function getAffiliates()
    {
        $this->checkLogin();

         Controller::load('admincp/controlAffiliates');                  
    }
    public function getGiftvouchers()
    {
        $this->checkLogin();

         Controller::load('admincp/controlVouchers');                  
    }
    public function getCoupons()
    {
        $this->checkLogin();

         Controller::load('admincp/controlCoupons');                  
    }
    public function getTaxrate()
    {
        $this->checkLogin();

         Controller::load('admincp/controlTaxrate');                  
    }
    public function getPaymentmethods()
    {
        $this->checkLogin();

         Controller::load('admincp/controlPaymentmethods');                  
    }

    public function getCurrency()
    {
        $this->checkLogin();

         Controller::load('admincp/controlCurrency');                  
    }



    // End ecommerce

    public function getApi()
    {
        $this->checkLogin();

         Controller::load('admincp/controlApi');                  
    }
    public function getDashboard()
    {
        $this->checkLogin();

         Controller::load('admincp/controlDashboard');                  
    }

    public function getCategories()
    {
        $this->checkLogin();

        Controller::load('admincp/controlCategories');   
    }
    public function getPages()
    {
        $this->checkLogin();

        Controller::load('admincp/controlPages');   
    }
    public function getNews()
    {
        $this->checkLogin();

        Controller::load('admincp/controlNews');   
    }
     public function getComments()
    {
        $this->checkLogin();

        Controller::load('admincp/controlComments');   
    }

    public function getContactus()
    {
        $this->checkLogin();

        Controller::load('admincp/controlContactus');   
    }

   
    public function getFilemanager()
    {
        $this->checkLogin();

        Controller::load('admincp/filemanager');   
    }
   
    public function getUsers()
    {
        $this->checkLogin();

        Controller::load('admincp/controlUsers');   
    }

    public function getUserGroups()
    {
        $this->checkLogin();

        Controller::load('admincp/controlUserGroups');   
    }

    public function getSetting()
    {
        $this->checkLogin();

        Controller::load('admincp/setting');    
    }

    public function getTheme()
    {
        $this->checkLogin();

        Controller::load('admincp/controlTheme');   
    }
    public function getPlugins()
    {
        $this->checkLogin();

        Controller::load('admincp/controlPlugins');   
    }

    public function getLogout()
    {

      Cookie::destroy('username');
      Cookie::destroy('password');

      Session::forget('userid');
      
      Session::forget('groupid');

      Redirect::to('admincp/login');

    }
    public function getForgotpassword()
    {
        if(Session::has('userid'))
        {
            Redirect::to(ADMINCP_URL);
        }

        Controller::load('admincp/forgotpassword');  
    }

    public function checkLogin()
    {
       Model::load('admincp/login');

       if(!isLogin())
       {
            Redirect::to('admincp/login/');
            die();
       }
    }


    public function getLogin()
    {
        $post=array('title'=>ADMINCP_TITLE);


        //Call to model 'login'
        Model::load('admincp/login');

//        Cache::enable(15);

        View::make('admincp/headLogin',$post);

        if (!isLogin()) {

            $alert = '';
            //If click onto login button
            if (Request::has('btnLogin')) {
 
                if (isUser(Request::get('email'), Request::get('password'))) {

                Redirect::to('admincp');

                } else {
                    $alert = '<div class="alert alert-danger">Wrong. Check login info again!</div>';
                }
            }

            View::make('admincp/login', array('alert' => $alert));
        }
        else
        {

            Redirect::to('admincp');
            die();
        }

    }
}

?>