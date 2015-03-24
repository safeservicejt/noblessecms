<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">List plugins</h3>
  </div>
  <div class="panel-body">
<div class="row">

		<div class="col-lg-12">
<!-- Form Action -->
		<div class="row">
		<form action="" method="post">



		</div>

		<!-- List -->
		<div class="row">
			<div class="col-lg-12">

				<table class="table">
				<thead>
					<tr>
					<td class="col-lg-1">#</td>
					<td class="col-lg-3">Title</td>
					<td class="col-lg-8">Descriptions</td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($plugins);

				$li='';

				$status='';

				$activate='';

				$control='';

				$pluginSetting='';


				for($i=0;$i<$totalRow;$i++)
				{
					$status='<a href="'.ROOT_URL.'admincp/plugins/uninstall/'.$plugins[$i]['foldername'].'">Uninstall</a>';		

					$activate='<a href="'.ROOT_URL.'admincp/plugins/deactivate/'.$plugins[$i]['foldername'].'">Deactivate</a>&nbsp;&nbsp;&nbsp;';	

					$control='';	

					$pluginSetting='';	

					if($plugins[$i]['install'] == 'no')
					{
			
						$status='<a href="'.ROOT_URL.'admincp/plugins/install/'.$plugins[$i]['foldername'].'">Install</a>';						
					}

					if((int)$plugins[$i]['status'] == 0 && $plugins[$i]['install']=='yes')
					{
			
						$activate='<a href="'.ROOT_URL.'admincp/plugins/activate/'.$plugins[$i]['foldername'].'">Activate</a>&nbsp;&nbsp;&nbsp;';		
											
					}elseif((int)$plugins[$i]['status'] == 0 && $plugins[$i]['install']=='no')
					{
			
						$activate='';		
											
					}

					if($plugins[$i]['control']!='no' && (int)$plugins[$i]['status'] == 1 && $plugins[$i]['install']=='yes')
					{
						$control='<a href="'.ROOT_URL.'admincp/plugins/control/'.$plugins[$i]['foldername'].'/'.base64_encode($plugins[$i]['control']).'">Controls</a>&nbsp;&nbsp;&nbsp;';		

					}

					if($plugins[$i]['setting']!='no' && (int)$plugins[$i]['status'] == 1 && $plugins[$i]['install']=='yes')
					{
						$pluginSetting='<a href="'.ROOT_URL.'admincp/plugins/setting/'.$plugins[$i]['foldername'].'/'.base64_encode($plugins[$i]['setting']).'">Setting</a>&nbsp;&nbsp;&nbsp;';		

					}


					$li.='

					<tr>
					<td>
					<input type="checkbox" name="id[]" value="'.$plugins[$i]['foldername'].'" />
					</td>
					<td>'.stripslashes($plugins[$i]['title']).'
					<p style="margin-top:10px;">
					'.$pluginSetting.$control.$activate.$status.'
					</p>
					</td>
					<td>'.stripslashes($plugins[$i]['summary']).'

					<p style="margin-top:10px;">
					<span>Version '.$plugins[$i]['version'].'</span> | By <a href="'.$plugins[$i]['url'].'">'.$plugins[$i]['author'].'</a> &nbsp;| 
					</p>

					</td>

					</tr>
					';

				}

				echo $li;

				?>


				</tbody>
				</table>
			</div>
		</div>
		</form>



		</div>		






	</div>    
    
  </div>
</div>