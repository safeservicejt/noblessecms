<?php

function isLogin()
{
    $valid=Validator::check(array(

    Cookie::get('email')=>'email|max:150|slashes',

    Cookie::get('password')=>'min:2|slashes'

    ));

    if(!$valid)
    {
        return false;
    }
       
    $username = Cookie::get('email');
    $password = Cookie::get('password');

    // if (!isset($username[1]) && !isset($password[1])) {
    //     return false;
    // }

    // $dbName=Multidb::renderDb('users');

    // $query = Database::query("select userid,nodeid,groupid from $dbName where email='$username' AND password='$password'");

    // $numRows = Database::num_rows($query);

    // if ((int)$numRows == 0)
    // {
    //     return false;
    // } 

    // $row=Database::fetch_assoc($query);

    DBCache::disable();

    $loadUser=Users::get(array(
        'where'=>"where  email='$username' AND password='$password'"
        ));

    if(!isset($loadUser[0]['userid']))
    {
        return false;
    }

    DBCache::enable();

    Session::make('groupid',$loadUser[0]['groupid']);  

    Session::make('userid',$loadUser[0]['userid']);

    return true;
}

function isUser($username, $password)
{
    $_REQUEST['email']=$username;
    
    $_REQUEST['password']=$password;
    
    $valid=Validator::make(array(

    'email'=>'email|max:150|slashes',

    'password'=>'min:2|slashes'

    ));

    if(!$valid)
    {
        return false;
    }

   
    $password = md5($password);

    // $query = Database::query("select userid,nodeid,groupid from $dbName where email='$username' AND password='$password'");

    // $numRows = Database::num_rows($query);

    DBCache::disable();

    $loadUser=Users::get(array(
        'where'=>" where email='$username' AND password='$password'"
        ));
    
    DBCache::enable();

    if (isset($loadUser[0]['userid'])) {  
//        Create cookie store login info,expires is 1 day

        // $row=Database::fetch_assoc($query);

        Cookie::make('email', $username, 8460);

        Cookie::make('password', $password, 8460);

        Session::make('groupid',$loadUser[0]['groupid']);
        
        Session::make('userid',$loadUser[0]['userid']);
        // echo Session::get('groupid');die();

        UserGroups::loadCaches();

        return true;
    }

    return false;

}

?>