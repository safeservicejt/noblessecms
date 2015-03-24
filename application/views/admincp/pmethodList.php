<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">List Payment Methods</h3>
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

				$totalRow=count($methods);

				$li='';

				$status='';

				$activate='';

				$control='';

				$pluginSetting='';


				for($i=0;$i<$totalRow;$i++)
				{
					$status='<a href="'.ADMINCP_URL.'paymentmethods/uninstall/'.$methods[$i]['foldername'].'">Uninstall</a>';		

					$activate='<a href="'.ADMINCP_URL.'paymentmethods/deactivate/'.$methods[$i]['foldername'].'">Deactivate</a>&nbsp;&nbsp;&nbsp;';	

					$control='';	

					$pluginSetting='';	

					if($methods[$i]['install'] == 'no')
					{
			
						$status='<a href="'.ADMINCP_URL.'paymentmethods/install/'.$methods[$i]['foldername'].'">Install</a>';						
					}

					if((int)$methods[$i]['status'] == 0 && $methods[$i]['install']=='yes')
					{
			
						$activate='<a href="'.ADMINCP_URL.'paymentmethods/activate/'.$methods[$i]['foldername'].'">Activate</a>&nbsp;&nbsp;&nbsp;';		
											
					}elseif((int)$methods[$i]['status'] == 0 && $methods[$i]['install']=='no')
					{
			
						$activate='';		
											
					}

					if($methods[$i]['setting']!='no' && (int)$methods[$i]['status'] == 1 && $methods[$i]['install']=='yes')
					{
						$pluginSetting='<a href="'.ADMINCP_URL.'paymentmethods/setting/'.$methods[$i]['foldername'].'/'.base64_encode($methods[$i]['setting']).'">Setting</a>&nbsp;&nbsp;&nbsp;';		

					}


					$li.='

					<tr>
					<td>
					<input type="checkbox" name="id[]" value="'.$methods[$i]['foldername'].'" />
					</td>
					<td>'.stripslashes($methods[$i]['title']).'
					<p style="margin-top:10px;">
					'.$pluginSetting.$control.$activate.$status.'
					</p>
					</td>
					<td>'.stripslashes($methods[$i]['summary']).'

					<p style="margin-top:10px;">
					<span>Version '.$methods[$i]['version'].'</span> | By <a href="'.$methods[$i]['url'].'">'.$methods[$i]['author'].'</a> &nbsp;| 
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