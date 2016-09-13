<?php

class Alert
{
	public static function make($inputData='')
	{
        ob_end_clean();

       	Response::headerCode(404);

       	include(ROOT_PATH.'contents/system/alert/alert.php');

       	die();
	}
}