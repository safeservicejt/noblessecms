<?php

class Forgotpassword
{

	public function index()
	{
		Model::load('admincp/forgotpw');

		$post=array();

		$post['alert']='';

		if(Request::has('btnRequest'))
		{
			if(forgotProcess())
			{
				$post['alert']='<div class="alert alert-success">Success. Check your email for get new password!</div>';
			}
			else
			{
				$post['alert']='<div class="alert alert-warning">Error. Have error while trying send new password to your email!</div>';
			}
		}

        View::make('usercp/head',array('title'=>'Forgot Password - '.ADMINCP_TITLE));

        View::make('usercp/forgotpw',$post);

        // View::make('usercp/footer');



	}
}

?>