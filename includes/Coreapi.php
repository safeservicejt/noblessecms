<?php

class Coreapi
{

	public function parseUri()
	{
		$method='';

		$addons='';

		$resultData=array('error'=>'ERROR');

		if(!$matches=Uri::match('^api\/json\/(\w+)\/?'))
		{		
			return json_encode($resultData);
		}		

		// print_r($matches);die();

		$method=strtolower(trim($matches[1]));

		$resultData=self::get($method);

		return $resultData;
	}

	public function get($method='')
	{
		if(isset($_REQUEST['method']))
		{
			$method=trim($_REQUEST['method']);
		}

		$resultData='';

		switch ($method) {
			case 'post':
				Model::load('api/core/post');
				break;
			case 'comments':
				Model::load('api/core/comments');
				break;
			case 'category':
				Model::load('api/core/category');
				break;
			case 'contacts':
				Model::load('api/core/contacts');
				break;
			case 'pages':
				Model::load('api/core/pages');
				break;
			case 'products':
				Model::load('api/core/products');
				break;
			case 'reviews':
				Model::load('api/core/reviews');
				break;
				

		}

		$resultData=getApi();

		return $resultData;

	}

}

?>