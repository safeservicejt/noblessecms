<?php

class Rss
{
	public function isenable()
	{
		if((int)GlobalCMS::$setting['enable_rss']==1)
		{
			return true;
		}

		return false;
	}
	
}
?>