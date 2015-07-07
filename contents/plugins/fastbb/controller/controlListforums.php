<?php

// define("THIS_URL", ROOT_URL.'admincp/plugins/runc/Y29udHJvbGxlci9jb250cm9sQ2hhcHRlci5waHA=/firemanga/');

class controlListforums
{
	private static $thisPath='';
	public function index()
	{
		self::$thisPath=ROOT_PATH.'contents/plugins/fastbb/';
		
		$post=array('alert'=>'');

		Model::setPath(self::$thisPath.'model/');
		Model::load('chapter');
		Model::resetPath();

		if($match=Uri::match('\/fastbb\/listforums\/(\w+)'))
		{
			if(method_exists("controlListforums", $match[1]))
			{	
				$method=$match[1];

				$this->$method();
				
			}
			
		}
		else
		{
			die('3434');
		}		

	
	}


	public function makeContent($keyName='',$post=array())
	{
		View::makeWithPath($keyName,$post,ROOT_PATH.'contents/plugins/fastbb/views/');		
	}

}

$run=new controlListforums();

$run->index();

// controlManga::index();

?>