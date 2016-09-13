<?php

class SelfApi
{
	public static function route()
	{
		$listRoute=array(
			'abc'=>'function_to_call'

			);

		return $listRoute;
	}

	public static function function_to_call()
	{
		return 'ok api';
	}
}