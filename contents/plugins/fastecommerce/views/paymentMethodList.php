<div class="panel panel-default">

  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<h3>Payment methods</h3>
		
		<table class="table table-hover margin-top-30">
			<thead>
				<tr>
					<td class="col-lg-10 col-md-10 col-sm-10 "><strong>Information</strong></td>
					<td class="col-lg-2 col-md-2 col-sm-2 "><strong>Status</strong></td>
				</tr>
			</thead>

			<tbody>
				<?php 

				if(isset($theList))
				{
					$li='';

					$total=count($theList);

					$listKey=array_keys($theList);

					for ($i=0; $i < $total; $i++) { 

						$keyName=$listKey[$i];

						if(!isset($keyName[2]))
						{
							continue;
						}

						$status='<span class="text-danger">Deactivate</span>';

						$install='<a href="'.CtrPlugin::url('paymentmethod','activate').$theList[$keyName]['foldername'].'" style="font-size:13px;margin-right:15px;">Activate</a>';

						if((int)$theList[$keyName]['status']==1)
						{
							$status='<span class="text-success">Activated</span>';

							$install='<a href="'.CtrPlugin::url('paymentmethod','deactivate').$theList[$keyName]['foldername'].'" style="font-size:13px;margin-right:15px;">Deactivate</a>';							
						}

						$li.='
						<!-- tr -->
						<tr>
							<td>
								<div>'.$theList[$keyName]['title'].'</div>
								<div>
									<a href="'.CtrPlugin::url('paymentmethod','setting').$theList[$keyName]['foldername'].'" style="font-size:13px;margin-right:15px;">Setting</a>
									'.$install.'
								</div>
							</td>
							<td>
								'.$status.'
							</td>
						</tr>
						<!-- tr -->
						';
					}

					echo $li;
				}
				?>
			</tbody>
		</table>   	
    	</div>
    </div>
  </div>
</div>
