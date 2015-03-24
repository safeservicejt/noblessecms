<?php

class Siteinfo
{
	public function get($keyName='')
	{
		$result=isset(GlobalCMS::$setting[$keyName])?GlobalCMS::$setting[$keyName]:'';

		return $result;
	}
}
?>