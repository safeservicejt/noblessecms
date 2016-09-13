<?php

class Log
{
	public static function report($code, $message, $file, $line)
	{
		  ob_end_clean();

		  $message=$message.' in file '.$file.' at line '.$line;

		  self::error($message);
	}
	public static function error($message)
	{
		self::setLog($message,E_USER_ERROR);
	}

	public static function warning($message)
	{
		self::setLog($message,E_USER_WARNING);
	}

	public static function notice($message)
	{
		self::setLog($message);
	}

	public static function showError($message)
	{
		Alert::make($message);
	}

	public static function setLog($message, $level=E_USER_NOTICE) 
	{
	    // $caller = next(debug_backtrace());

	    // trigger_error($message.' in file '.$caller['file'].' lines '.$caller['line'], $level);

	    // echo $message;

	    self::showError($message);

	    die();
	}

}