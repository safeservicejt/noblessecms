<div class="panel panel-default">

  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<h3>Statistics</h3>
    	<hr>
		    <div class="row">

		    	<div class="col-lg-6 col-md-6 col-sm-6 text-center">
		    		<div class="text-success" style="font-size:32px;"><?php echo number_format($totalRow);?></div>
		    		<span>Collections</span>
		    	</div>
		    	<div class="col-lg-6 col-md-6 col-sm-6 text-center">
		    		<div class="text-danger" style="font-size:32px;"><?php echo number_format($totalView);?></div>
		    		<span>Views</span>
		    	</div>

		    </div>    	
    	</div>
    </div>
  </div>
</div>

<!-- row -->
<div class="row">
	<div class="col-lg-12">
	
		<div class="panel panel-default">

		  <div class="panel-body">
		    <div class="row">
		    	<div class="col-lg-12">
				<h3>Collections</h3>
				<hr> 	

				<table class="table table-hover">
					<thead>
						<tr>
							<td class="col-lg-1 col-md-1 col-sm-1"><input type="checkbox" id="selectAll" /></td>

							<td class="col-lg-2 col-md-2 col-sm-2 "><strong>Date Added</strong></td>
							<td class="col-lg-3 col-md-3 col-sm-3 "><strong>Author</strong></td>
							<td class="col-lg-4 col-md-4 col-sm-4"><strong>Title</strong></td>
							<td class="col-lg-2 col-md-2 col-sm-2 text-right"><strong>Views</strong></td>
						</tr>
					</thead>

					<tbody>
					<?php

					if(isset($theList[0]['id']))
					{
						$li='';

						$total=count($theList);

						$status='';

						for ($i=0; $i < $total; $i++) { 

							$li.='
							<tr>
							<td class="col-lg-1">
								<input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['id'].'" />
							</td>							
							<td>'.date('M d, Y H:i',strtotime($theList[$i]['date_added'])).'</td>
							<td class="">'.$theList[$i]['username'].'</td>
							<td><a href="'.$theList[$i]['url'].'" target="_blank">'.$theList[$i]['friendly_url'].'</a></td>
							<td class="text-right">'.$theList[$i]['views'].'</td>

							</tr>

							';
						}

						echo $li;
					}
					?>						
					</tbody>
				</table>
		    	</div>

                <div class="col-lg-5 text-left">
                    <span>Total: <?php echo $totalPost.' of '.$totalPage.' page(s)';?></span>
                </div>              
				<div class="col-lg-7 text-right">
					<?php  echo $pages; ?>
				</div>    		    	
		    </div>
		  </div>
		</div>				
	</div>
</div> 
<!-- row -->