<?php

function prodImages($id)
{
	$resultData=array();

	$loadData=prodImages::get(array(
		'where'=>"where productid='$id'"
		));

	$total=count($loadData);

	for($i=0;$i<$total;$i++)
	{
		$resultData[$i]['image']=$loadData[$i]['image'];
		$resultData[$i]['sort_order']=$loadData[$i]['sort_order'];		
	}

	return $resultData;

}

function genProdImages($id)
{
	$selectImages=prodImages($id);

	$total=count($selectImages);

	$li='';
	for($i=0;$i<$total;$i++)
	{

		$li.='

	<!-- Row -->
		<div class="row" style="margin-top:20px;">
			<div class="col-lg-2">
			<img src="'.ROOT_URL.$selectImages[$i]['image'].'" class="img-responsive" />
			</div>
			<div class="col-lg-6">
				<span>'.$selectImages[$i]['image'].'</span>
			</div>
			<div class="col-lg-2">
							    <div class="input-group">
							      <input type="text" id="ipSortOrder" class="form-control" value="'.$selectImages[$i]['sort_order'].'" placeholder="Sort order">
							      <span class="input-group-btn">
							        <button class="btn btn-info" data-image="'.$selectImages[$i]['image'].'" id="btnSortOrder" type="button">Save</button>
							      </span>
							    </div><!-- /input-group -->									
			</div>

			<div class="col-lg-1">
				<button type="button" id="btnRemove" data-prodid="'.$id.'" data-image="'.$selectImages[$i]['image'].'" class="btn btn-danger">Remove</button>
			</div>
		</div>
		<!-- End row -->

		';
	}

	return $li;
}
function addImages_Prod($id)
{

	// Database::query("delete from products_images where productid='$id'");

	// $urlThumbnail=trim($post['urlThumbnail']);

	$filePath=ROOT_PATH.'uploads/images/';

	$shortPath='uploads/images/';


	$totalFile=count($_FILES['images']['name']);

	for($i=0;$i<$totalFile;$i++)
	{
		$tmpName=$_FILES['images']['name'][$i];

		if(isset($tmpName[1]))
		{
			preg_match('/^.*?\.(\w+)$/i', $tmpName,$matches);

			$newNumber=String::randNumber(8);

			$newName='product_'.$id.'_'.$newNumber.'.'.$matches[1];

			$filePos='images.'.$i;

			Input::file($filePos)->move($filePath,$newName);

			$shortPath='uploads/images/'.$newName;

			prodImages::insert(array(
				'productid'=>$id,
				'image'=>$shortPath,
				'sort_order'=>$i
				));	
		}
	}
}


function removeProd($post=array())
{

	if(UserGroups::enable('can_delete_all_product')==false){

		$listID="'".implode("','",$post)."'";

		$totalIn=count($post);

		$userid=Session::get('userid');

		$loadData=Products::get(array(
			'where'=>"where userid='$userid'"
			));

		if(!isset($loadData[0]['productid']))
		{
			Alert::make('Page not found');		

			return false;			
		}

	}	

	Products::remove($post);
}

?>