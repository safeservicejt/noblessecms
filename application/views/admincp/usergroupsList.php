<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">List User Groups</h3>
  </div>
  <div class="panel-body">
    
 <div class="row">

		<div class="col-lg-12">
<!-- Form Action -->
		<div class="row">
		<form action="" method="post" enctype="multipart/form-data">
		<div class="col-lg-3">
            <div class="input-group input-group-sm">
                <select class="form-control" name="action">
                    <option value="delete">Delete</option>

                </select>
               <span class="input-group-btn">
                <button class="btn btn-primary" name="btnAction" type="submit">Apply</button>
              </span>

            </div><!-- /input-group -->   				
		</div>

		</div>

		<!-- List -->
		<div class="row">
			<div class="col-lg-12">

				<table class="table">
				<thead>
					<tr>
					<td class="col-lg-1">#</td>
					<td class="col-lg-10">Title</td>
					<td class="col-lg-1"></td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($theList);

				$li='';

				if(isset($theList[0]['groupid']))
				for($i=0;$i<$totalRow;$i++)
				{


					$li.='

					<tr>
					<td>
					<input type="checkbox" name="id[]" value="'.$theList[$i]['groupid'].'" />
					</td>
					<td>'.stripslashes($theList[$i]['group_title']).'
					</td>

					<td><a href="'.System::getUrl().'admincp/usergroups/edit/'.$theList[$i]['groupid'].'" class="btn btn-xs btn-warning">Edit</a></td>

					</tr>
					';

				}

				echo $li;

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
		</form>



		</div>		






	</div>
   
  </div>
</div>