<?php

class Misc
{
	public static function genSmallPage($inputData=array())
	{
		$inputData['isSmall']='yes';

		$result=self::genPage($inputData);

		return $result;
	}

	public static function genPage($inputData=array())
	{
		$pagePath=isset($inputData['url'])?$inputData['url']:'';

		$pagePath=str_replace(System::getUrl(), '', $pagePath);

		$curPage=isset($inputData['curPage'])?$inputData['curPage']:0;

		$totalItem=isset($inputData['totalItem'])?$inputData['totalItem']:0;

		$showItem=isset($inputData['showItem'])?$inputData['showItem']:10;

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:10;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:5;

		$splitChar=isset($inputData['splitChar'])?$inputData['splitChar']:'/';

		$isSmall=isset($inputData['isSmall'])?'pagination-sm':'';

		$splitChar=($pagePath=='')?'':$splitChar;

		$endPage=$limitPage+$curPage;

		$totalPage=intval($totalItem/$limitShow);

		$endPage=($totalPage<$endPage)?$totalPage:$endPage;

		$prevPage=($curPage>0)?$curPage-1:0;

		$nextPage=($curPage<$totalPage)?$curPage+1:$curPage;

		$prevHtml='
		<li><a href="'.System::getUrl().$pagePath.$splitChar.'page'.$splitChar.$prevPage.'"><span aria-hidden="true">&laquo;</span></a></li>
		';


		$nextHtml='
		<li><a href="'.System::getUrl().$pagePath.$splitChar.'page'.$splitChar.$nextPage.'"><span aria-hidden="true">&raquo;</span></a></li>
		';

		$prevHtml=($totalPage > 0)?$prevHtml:'';

		$nextHtml=($totalPage > $curPage)?$nextHtml:'';

		$li='';

		for ($i=$curPage; $i < $endPage; $i++) { 
			$li.='<li><a href="'.System::getUrl().$pagePath.$splitChar.'page'.$splitChar.$i.'">'.$i.'</a></li>';
		}

		$result='
		<nav>
			<ul class="pagination '.$isSmall.'">
			  '.$prevHtml.$li.$nextHtml.'
			</ul>
		</nav> 

		';

		return $result;

	}
	
}
