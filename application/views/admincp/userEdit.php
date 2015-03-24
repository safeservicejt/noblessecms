  <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/admincp/css/chosen.min.css">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit User</h3>
  </div>
  <div class="panel-body">
    

<div class="row">
<?php echo $alert;?>
		<div class="col-lg-6">
		<form action="" method="post" enctype="multipart/form-data">
		<p>
			<label><strong>Usergroup:</strong></label>
			<select name="send[groupid]" class="form-control chosen-select" id="jsGroup" data-placeholder="Choose a user group...">

			<?php
			$total=count($usergroups);

			for($i=0;$i<$total;$i++)
			{
				if((int)$edit['groupid']==$usergroups[$i]['groupid'])
				{
				echo '<option value="'.$usergroups[$i]['groupid'].'" selected>'.stripslashes($usergroups[$i]['group_title']).'</option>';
			
				}
				else
				{
				echo '<option value="'.$usergroups[$i]['groupid'].'">'.stripslashes($usergroups[$i]['group_title']).'</option>';

				}
			}

			?>
			</select>

			</p>		
			<p>
			<label><strong>First name:</strong></label>
			<input type="text" name="address[firstname]" class="form-control" placeholder="First name..." value="<?php echo stripslashes(trim($edit['firstname']));?>" />
			</p>
					
			<p>
			<label><strong>Last name:</strong></label>
			<input type="text" name="address[lastname]" class="form-control" placeholder="Last name..." value="<?php echo stripslashes(trim($edit['lastname']));?>" />
			</p>	
				<p>
			<label><strong>Phone:</strong></label>
			<input type="text" name="address[phone]" class="form-control" placeholder="Phone..." value="<?php echo stripslashes(trim($edit['phone']));?>" />
			</p>

				<p>
			<label><strong>Fax:</strong></label>
			<input type="text" name="address[fax]" class="form-control" placeholder="Fax..." value="<?php echo stripslashes(trim($edit['fax']));?>" />
			</p>	



		</div>

		<div class="col-lg-6">
	
				<p>
			<label><strong>Address 1:</strong></label>
			<input type="text" name="address[address_1]" class="form-control" placeholder="Address 1..." value="<?php echo stripslashes(trim($edit['address_1']));?>" />
			</p>

				<p>
			<label><strong>Address 2:</strong></label>
			<input type="text" name="address[address_2]" class="form-control" placeholder="Address 2..." value="<?php echo stripslashes(trim($edit['address_2']));?>" />
			</p>


				<p>
			<label><strong>City:</strong></label>
			<input type="text" name="address[city]" class="form-control" placeholder="City..." value="<?php echo stripslashes(trim($edit['city']));?>" />
			</p>

				<p>
			<label><strong>Postcode:</strong></label>
			<input type="text" name="address[postcode]" class="form-control" placeholder="Postcode..." value="<?php echo stripslashes(trim($edit['postcode']));?>" />
			</p>

				<p>
			<label><strong>Country:</strong></label>
			<input type="text" name="address[country]" class="form-control" placeholder="Country..." value="<?php echo stripslashes(trim($edit['country']));?>" />
			</p>



		
		</div>


		<div class="col-lg-12">
		<button type="submit" class="btn btn-info" name="btnSave">Save changes</button>
		</div>


	</form>



	</div>    
  </div>
</div>

<script src="<?php echo ROOT_URL;?>bootstrap/admincp/js/chosen.jquery.min.js"></script>
  <script type="text/javascript">
    $(".chosen-select").chosen({max_selected_options: 1});
  </script>