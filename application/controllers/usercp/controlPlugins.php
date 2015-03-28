<?php

class controlPlugins
{

	public function index()
	{
		if(Uri::match('\/run\/'))
		{
			$this->run();
			die();
		}
		if(Uri::match('\/runc\/'))
		{
			$this->runc();
			die();
		}


		// $post['pages']=genPage('plugins',$curPage);

		// $post['plugins']=listPlugins();


		// View::make('admincp/head',array('title'=>'List plugins - '.ADMINCP_TITLE));

        // View::make('admincp/nav');
   
        // View::make('admincp/left');
          
        // View::make('admincp/newsList',$post);

        // $this->makeContents('pluginsList',$post);        

        // View::make('admincp/footer'); 		
	}

	public function run()
	{
		$fileName=Uri::getNext('run');

		$foldername=Uri::getNext($fileName);

		// echo $foldername;die();

		$fileName=base64_decode($fileName);

		if(!preg_match('/\.php$/i', $fileName))
		{
			$fileName.='.php';
		}

		$post=array(
			'foldername'=>$foldername,
			'fileName'=>$fileName
			);


		// echo Render::adminHeader();die();

		View::make('usercp/head',array('title'=>'Plugin '.$foldername.' - '.ADMINCP_TITLE));

        $this->makeContents('pluginContent',$post);           

        View::make('usercp/footer'); 
	}
	public function runc()
	{
		$fileName=Uri::getNext('runc');

		if(!$match=Uri::match('\/func\/(.*?)\/'))
		{
			$foldername=Uri::getNext($fileName);
		}
		else
		{
			$foldername=Uri::getNext($match[1]);
		}
		

		// echo $foldername;die();

		$fileName=base64_decode($fileName);

		if(!preg_match('/\.php$/i', $fileName))
		{
			$fileName.='.php';
		}

		$post=array(
			'foldername'=>$foldername,
			'fileName'=>$fileName
			);

		if($match=Uri::match('\/func\/(.*?)\/'))
		{
			$post['func']=base64_decode($match[1]);
		}
		// echo Render::adminHeader();die();

		View::make('usercp/head',array('title'=>'Plugin '.$foldername.' - '.ADMINCP_TITLE));

        $this->makeContents('pluginRuncContent',$post);           

        View::make('usercp/footer'); 
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('usercp/nav');
                
        View::make('usercp/left');  
              
        View::make('usercp/startContent');

        View::make('usercp/'.$viewPath,$inputData);

        View::make('usercp/endContent');
         // View::make('admincp/right');

    }	
}

?>