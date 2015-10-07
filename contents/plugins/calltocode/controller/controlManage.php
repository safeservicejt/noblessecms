<?php

class controlManage
{
	private static $thisPath='';
	public function index()
	{
		self::$thisPath=ROOT_PATH.'contents/plugins/calltocode/';

		$post=array('alert'=>'');

		Model::setPath(self::$thisPath.'model/');
		Model::load('manage');
		Model::resetPath();

		if($match=Uri::match('\/calltocode\/manage\/(\w+)'))
		{
			if(method_exists("controlManage", $match[1]))
			{	
				$method=$match[1];

				$this->$method();
				
			}
			
		}
		else
		{

			if(Request::has('btnAction'))
			{
				actionProcess();
			}


			$curPage=0;

			if($match=Uri::match('\/page\/(\d+)'))
			{
				$curPage=$match[1];
			}

			$theUrl=str_replace(ROOT_URL, '', THIS_URL);

			$post['theList']=CallToCode::get(array(
				'limitShow'=>20,
				'limitPage'=>$curPage,
				'orderby'=>"order by id desc"
				));

			$post['pages']=Misc::genSmallPage($theUrl,$curPage);


			self::makeContent('listView',$post);	
			
		}


	}

	public function addnew()
	{
		$post=array('alert'=>'');


		if(Request::has('btnAdd'))
		{
			try {

				insertProcess();

				$post['alert']='<div class="alert alert-success">Success. Add new code complete!</div>';

			} catch (Exception $e) {

				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';

			}
		}	

		self::makeContent('codeAdd',$post);	
	}
	public function edit()
	{
		$post=array('alert'=>'');


		$id=Uri::getNext('edit');
		$post['id']=$id;

		if(Request::has('btnSave'))
		{
			try {

				updateProcess($id);

				$post['alert']='<div class="alert alert-success">Save changes successful!</div>';
				
			} catch (Exception $e) {

				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';

			}							
		}

		$loadData=CallToCode::get(array(
			'where'=>"where id='$id'"
			));

		$post['edit']=$loadData[0];

		$headData=array('title'=>'Edit code - '.$loadData[0]['title'].'');

		self::makeContent('codeEdit',$post,$headData);	
	}

	public static function makeContent($keyName='',$post=array())
	{

		// $post['headData']=$headData;

		// Render::pluginView(ROOT_PATH.'contents/plugins/calltocode/views/',$keyName,$post);	

		View::makeWithPath($keyName,$post,ROOT_PATH.'contents/plugins/calltocode/views/');	
	}

}

$run=new controlManage();

$run->index();

// controlManage::index();

?>