<?php

class Url
{

	public function get($str)
	{
		$str=ROOT_URL.$str;

		return $str;
	}

	public function cronjob($id=0)
	{
		$url=((int)$id==0)?ROOT_URL.'cronjob/run/all.php':ROOT_URL.'cronjob/run/'.$id.'.php';

		return $url;
	}

	public function product($row=array())
	{
		if(!isset($row['productid']))
		{
			return '';
		}

		$resultData=ROOT_URL.'product-'.$row['productid'].'-'.$row['friendly_url'].'.html';

		return $resultData;
	}
	public function tag($tagStr='')
	{
		$resultData=ROOT_URL.'tag-'.$tagStr;

		return $resultData;
	}
	
	public function cart()
	{
		$resultData=ROOT_URL.'cart';

		return $resultData;
	}

	public function checkout()
	{
		$resultData=ROOT_URL.'checkout';

		return $resultData;
	}
	public function login()
	{
		$resultData=ROOT_URL.'usercp/login';

		return $resultData;
	}
	public function register()
	{
		$resultData=ROOT_URL.'usercp/register';

		return $resultData;
	}
	public function forgotpw()
	{
		$resultData=ROOT_URL.'usercp';

		return $resultData;
	}
	public function account()
	{
		$resultData=ROOT_URL.'usercp';

		return $resultData;
	}
	public function rss()
	{
		$resultData=ROOT_URL.'rss';

		return $resultData;
	}

	public function category($row=array())
	{
		if(!isset($row['catid']))
		{
			return '';
		}		

		$resultData=ROOT_URL.'category-'.$row['catid'].'-'.$row['friendly_url'];

		return $resultData;

	}
	public function page($row=array())
	{
		if(!isset($row['pageid']))
		{
			return '';
		}		
		$resultData=ROOT_URL.'page-'.$row['pageid'].'-'.$row['friendly_url'].'.html';

		return $resultData;

	}
	public function download($row=array())
	{
		if(!isset($row['orderid']))
		{
			return '';
		}
		
		$friendly_url=self::makeFriendly($row['title']);

		$resultData=USERCP_URL.'getfile/orderid/'.$row['orderid'].'/file/'.$row['downloadid'].'_'.$friendly_url;

		return $resultData;

	}

	public function manufacturer($row=array())
	{
		if(!isset($row['manufacturerid']))
		{
			return '';
		}		
		$resultData=ROOT_URL.'manufacturer-'.$row['manufacturerid'].'-'.$row['friendly_url'];

		return $resultData;

	}
	public function post($row=array())
	{
		if(!isset($row['postid']))
		{
			return '';
		}		
		$resultData=ROOT_URL.'post-'.$row['postid'].'-'.$row['friendly_url'].'.html';

		return $resultData;

	}

	public function bannerImg()
	{
		$data=GlobalCMS::$setting['bannerImg'];

		return ROOT_URL.$data;
	}
	public function bannerText()
	{
		$data=GlobalCMS::$setting['banner_text'];

		return $data;
	}

	public function makeFriendly($inputStr='',$type='_')
	{
		if(!isset($inputStr[2]))
		{
			return $inputStr;
		}

		// $retext=preg_replace('/\U/i', '', $inputStr);

		$retext=String::stripUnicode($inputStr);

		preg_match_all('/([a-zA-Z0-9]+)/i', $retext,$matches);
	
		$retext=implode($type, $matches[1]);
		
		return $retext;
	}
}

?>