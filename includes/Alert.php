<?php
/*
	Custom alert page:

	Create file alert.php at: contents/securiry/alert/alert.php
*/

class Alert
{
    public static function make($alertMessage = '')
    {
        ob_end_clean();

       	Response::headerCode(404);

       	if(file_exists(ROOT_PATH.'contents/securiry/alert/alert.php'))
       	{
       		include(ROOT_PATH.'contents/securiry/alert/alert.php');
       	}
       	else
       	{
	       	CustomPlugins::load('before_alert_page',array('message'=>$alertMessage));

	        View::make('alert', array('alert' => $alertMessage));

	        die();       		
       	}


    }
}


?>