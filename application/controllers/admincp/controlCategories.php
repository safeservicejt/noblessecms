<?php

class controlCategories
{
	public function index()
	{

		
		$post=array('alert'=>'');

		Model::load('admincp/categories');
		
		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		if(Request::has('btnAction'))
		{
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_remove_category');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}			
			actionProcess();
		}

		if(Request::has('btnAdd'))
		{

			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_addnew_category');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}			

			try {
				
				insertProcess();

				$post['alert']='<div class="alert alert-success">Add new category success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		if(Request::has('btnSave'))
		{
			$valid=UserGroups::getPermission(Users::getCookieGroupId(),'can_edit_category');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}

			$match=Uri::match('\/edit\/(\d+)');

			try {
				
				updateProcess($match[1]);

				$post['alert']='<div class="alert alert-success">Update category success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		$addWhere='';

		$addPage='';

		if(Request::has('btnSearch'))
		{
			$txtKeywords=trim(Request::get('txtKeywords',''));

			$addWhere="where title LIKE '%$txtKeywords%'";

			$addPage='/search/'.base64_encode($txtKeywords);
		}

		if($matchS=Uri::match('\/search\/([a-zA-Z0-9_\-\=\+]+)'))
		{
			$txtKeywords=base64_decode($matchS[1]);

			$addWhere="where title LIKE '%$txtKeywords%'";

			$addPage='/search/'.base64_encode($txtKeywords);
		}

		$post['theList']=Categories::get(array(
			'limitShow'=>30,
			'limitPage'=>$curPage,
			'where'=>$addWhere,
			'orderby'=>'order by catid desc',
			'cache'=>'no'
			));


		$getTotal=Categories::get(array(
			'where'=>$addWhere,
			'selectFields'=>'count(catid) as totalRow',
			'cache'=>'no'
			));

		$total=count($post['theList']);

		if((int)$total > 0)
		{
			for ($i=0; $i < $total; $i++) { 
				$parentid=$post['theList'][$i]['parentid'];

				if((int)$parentid > 0)
				{
					$catData=Categories::get(array(
						'cache'=>'no',
						'where'=>"where catid='$parentid'"
						));

					if(isset($catData[0]['title']))
					{
						$post['theList'][$i]['title']=$catData[0]['title'].' -> '.$post['theList'][$i]['title'];
					}
				}
			}
		}

		$post['listCat']=Categories::get(array(
			'orderby'=>'order by title asc',
			'cache'=>'no'
			));

		$total=count($post['listCat']);

		if((int)$total > 0)
		{
			for ($i=0; $i < $total; $i++) { 
				$parentid=$post['listCat'][$i]['parentid'];

				if((int)$parentid > 0)
				{
					$catData=Categories::get(array(
						'cache'=>'no',
						'where'=>"where catid='$parentid'"
						));

					if(isset($catData[0]['title']))
					{
						$post['listCat'][$i]['title']=$catData[0]['title'].' -> '.$post['listCat'][$i]['title'];
					}
				}
			}
		}



		$totalRow=$getTotal[0]['totalRow'];

		$totalPage=intval((int)$totalRow/30);


		$post['pages']=Misc::genSmallPage('admincp/categories',$curPage,$totalPage);

		if($match=Uri::match('\/edit\/(\d+)'))
		{
			$loadData=Categories::get(array(
				'where'=>"where catid='".$match[1]."'",
				'cache'=>'no'
				));

			$post['edit']=$loadData[0];
		}


		System::setTitle('Categories list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('categoriesList',$post);

		View::make('admincp/footer');

	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>