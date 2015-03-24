<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">List products

    <div class="pull-right">
    <a href="<?php echo ADMINCP_URL;?>products/addnew" class="btn btn-primary btn-xs">Add new</a>
    </div>
    </h3>
  </div>
  <div class="panel-body">
<div class="row">

		<div class="col-lg-12">
<!-- Form Action -->
		<div class="row">
		<form action="" method="post" enctype="multipart/form-data">
		<div class="col-lg-3">
			<select class="form-control" name="action">
			<option value="delete">Delete</option>
			<option value="publish">Set as publish</option>
			<option value="unpublish">Set as unpublish</option>   
			<option value="setFeatured">Set as featured</option>   
			<option value="unsetFeatured">unSet featured</option>   
			</select>
		</div>
		<div class="col-lg-2">
			<button type="submit" class="btn btn-info" name="btnAction">Apply</button>
		</div>

		<!-- right -->
		<div class="col-lg-4 pull-right text-right">
		
    <div class="input-group">
      <input type="text" class="form-control" name="txtKeywords" placeholder="Search for...">
      <span class="input-group-btn">
        <button class="btn btn-primary" name="btnSearch" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
      </span>
    </div><!-- /input-group -->
    
		</div>
		<!-- right -->

		</div>

		<!-- List -->
		<div class="row">
			<div class="col-lg-12">

				<table class="table">
				<thead>
					<tr>
					<td class="col-lg-1"><input type="checkbox" id="selectAll" /></td>
					<td class="col-lg-7">Title</td>
					<td class="col-lg-2">Price</td>

					<td class="col-lg-1">Status</td>
					<td class="col-lg-1"></td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($products);

				$li='';

				$status='<span class="label label-danger">Pending</span>';

				$views='';

				$date_added='';

				$isFeatured='';

				if(isset($products[0]['productid']))
				for($i=0;$i<$totalRow;$i++)
				{
					$isFeatured='';

					$status='<span class="label label-danger">Pending</span>';
					
					if((int)$products[$i]['status']==1)
					{
						$status='<span class="label label-success">Publish</span>';
					}

					$views='<span class="glyphicon glyphicon-eye-open"></span> '.$products[$i]['viewed'];

					$date_added='<span class="glyphicon glyphicon-calendar"></span> '.$products[$i]['date_added'];

					if((int)$products[$i]['is_featured']==1)
					{
						$isFeatured='<span class="label label-success">Featured</span>';					
					}

					$li.='

					<tr>
					<td>
					<input type="checkbox" id="cboxID" name="id[]" value="'.$products[$i]['productid'].'" />
					</td>
					<td>'.$products[$i]['title'].'
					<br>
					'.$views.' '.$date_added.' '.$isFeatured.'
					</td>
					<td>'.$products[$i]['priceFormat'].'</td>
					<td>'.$status.'</td>

					<td><a href="'.ROOT_URL.'admincp/products/edit/'.$products[$i]['productid'].'" class="btn btn-xs btn-warning">Edit</a></td>

					</tr>
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
    
  </div>
</div>