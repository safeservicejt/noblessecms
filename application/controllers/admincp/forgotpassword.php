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

        View::make('admincp/head',array('title'=>'Forgot Password - '.ADMINCP_TITLE));

        View::make('admincp/forgotpw',$post);

        View::make('admincp/footer');



	}
}

?>