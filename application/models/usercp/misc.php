<?php


function genPage($title,$start=0,$max=5)
{
	$endpage=$start+$max;


	$li='';

	for($i=$start;$i<=$endpage;$i++)
	{
		$li.='<li><a href="'.USERCP_URL.$title.'/page/'.$i.'">'.$i.'</a></li>';
	}

	$prev=$start-1;
	$next=$max+1;




	return '
				<ul class="pagination">
				  <li><a href="'.USERCP_URL.$title.'/page/'.$prev.'">&laquo;</a></li>
				  '.$li.'
				  <li><a href="'.USERCP_URL.$title.'/page/'.$next.'">&raquo;</a></li>
				</ul>

	';


}
?>