
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Request Payment History </h3>
  </div>
  <div class="panel-body">
    
<form action="" method="post" enctype="multipart/form-data">
<div class="row">

	<div class="col-lg-12 table-responsive">
	<table class="table table-hover">
	<thead>
		<tr>
		<td class="col-lg-2">Date request</td>
		<td class="col-lg-2">Total</td>
		<td class="col-lg-7">Comments</td>
		<td class="col-lg-1">Status</td>
		</tr>
	</thead>
	<tbody>
		
		<?php 
		$total=count($theList);

		$li='';

		$status='';

		if(isset($theList[0]['userNodeid']))
			for($i=0;$i<$total;$i++)
			{
				$theList[$i]['status']=((int)$theList[$i]['status']==1)?'Sended':'Pending';
				
				$li.='
					<!-- row -->
					<tr>
					<td>'.$theList[$i]['date_added'].'</td>
					<td>'.$theList[$i]['total_requestFormat'].'</td>
					<td>'.$theList[$i]['comments'].'</td>
					<td><span class="label label-success">'.$theList[$i]['status'].'</span></td>

					</tr>
					<!-- row -->

				';
			}

		echo $li;
		?>

	</tbody>
	</table>
	</div>
			<div class="col-lg-12 text-right">
				<?php  echo $pages; ?>
			</div>
</div> 
</form>	   
  </div>
</div>
