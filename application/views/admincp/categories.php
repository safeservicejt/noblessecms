  <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/admincp/css/chosen.min.css">

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Categories</h3>
  </div>
  <div class="panel-body">
    <div class="row">
		<div class="col-lg-7 showBorderRight">
		<p>
			<h4>List categories</h4>
		</p>

<!-- Form Action -->
		<div class="row">
		<form action="" method="post" enctype="multipart/form-data">
		<div class="col-lg-3">
			<select class="form-control" name="action">
			<option value="delete">Delete</option>
			</select>
		</div>
		<div class="col-lg-2">
			<button type="submit" class="btn btn-primary" name="btnAction">Apply</button>
		</div>
		<!-- right -->
		<div class="col-lg-5 pull-right text-right">
		
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
					<td class="col-lg-11">Name</td>
						<td class="col-lg-1"></td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($categories);

				$li='';
				
				if(isset($categories[0]['catid']))
				for($i=0;$i<$totalRow;$i++)
				{
					$li.='

					<tr>
					<td>
					<input type="checkbox" id="cboxID" name="id[]" value="'.$categories[$i]['catid'].'" />
					</td>
					<td>'.$categories[$i]['cattitle'].'</td>
					<td><a href="'.ROOT_URL.'admincp/categories/edit/'.$categories[$i]['catid'].'" class="btn btn-xs btn-warning">Edit</a></td>

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


		<div class="col-lg-5">
		<form action="" method="post" enctype="multipart/form-data">

			<?php if($showEdit=='no'){ ?>
			<!-- Add new -->
			<div style="display:block;">
			<p>
			<h4>Add new category</h4>
			</p>
			<?php echo $alert;?>
			<p>
			<label><strong>Name:</strong></label>
			<input type="text" name="send[cattitle]" class="form-control" placeholder="Category name..." />
			</p>
				<p class="pChosen">
				<div class="row">
				<div class="col-lg-12">
				<label><strong>Parent category</strong></label>
				<input type="text" class="form-control txtAuto" data-maxselect="1" data-numselected="0" data-method="category" data-key="jsonCategory" placeholder="Type here..." />
	              <div class="listAutoSuggest"><ul></ul></div>	
                  <ul class="ulChosen"></ul>
				</div>
				</div>

				</p>			
	<p>
			<label><strong>Image:</strong></label>
			<input type="file" name="thumbnail" class="form-control" />

			</p>
			<p>
			<button type="submit" class="btn btn-info" name="btnAdd">Add new</button>
			</p>
			</div>
			<?php } ?>


			<?php if($showEdit=='yes'){ ?>
			<!-- Edit -->
			<div style="display:block;">
			<p>
			<h4>Edit category</h4>
			</p>
			<?php echo $alert;?>
			<p>
			<label><strong>Category name:</strong></label>
			<input type="text" name="send[cattitle]" class="form-control" placeholder="Category name..." value="<?php if($showEdit=='yes')echo stripslashes($edit['cattitle']);?>" />

			</p>
			<p>
			<label><strong>Friendly url:</strong></label>
			<input type="text" name="send[friendly_url]" class="form-control" placeholder="Friendly url..." value="<?php echo stripslashes($edit['friendly_url']);?>" />

			</p>

			<p class="pChosen">
			<div class="row">
			<div class="col-lg-12">
			<label><strong>Parent category</strong></label>
			<input type="text" class="form-control txtAuto" data-maxselect="1" data-numselected="0" data-method="category" data-key="jsonCategory" placeholder="Type here..." />
              <div class="listAutoSuggest"><ul></ul></div>	
              <ul class="ulChosen"></ul>
			</div>
			</div>

			</p>
	<p>
			<label><strong>Image:</strong></label>
			<input type="file" name="thumbnail" class="form-control" />

			</p>
			<?php $thumbnail=$edit['image']; if(isset($thumbnail[5])){ ;?>	
			<p>
			<img src="<?php echo ROOT_URL.$thumbnail;?>" class="img-responsive" />
			</p>

			<?php } ?>	
			<p>
			<label><strong>Sort order:</strong></label>
			<input type="text" name="send[sort_order]" class="form-control" value="<?php echo $edit['sort_order'];?>" placeholder="Sort order..." />
			</p>				
			<p>
			<button type="submit" class="btn btn-info" name="btnSave">Save Changes</button>
			<a href="<?php echo ADMINCP_URL;?>categories" class="btn btn-default pull-right">Cancel</a>
			</p>
			</div>
			<?php } ?>



		</form>
		</div>




	</div>
  </div>
</div>


  <script type="text/javascript">
			var root_url='<?php echo ROOT_URL;?>';

 $( document ).on( "click", "span.removeTextChosen", function() {

  var txtAuto=$(this).parent().parent().parent().children('.txtAuto');

    var theMaxSelect=txtAuto.attr('data-maxselect');

    var theNumSelect=txtAuto.attr('data-numselected');

    theNumSelect=parseInt(theNumSelect)-1;

    txtAuto.attr('data-numselected',theNumSelect);

    if(parseInt(theNumSelect) < parseInt(theMaxSelect))
    {
    	txtAuto.attr('disabled',false);
    }   

  	$(this).parent().remove();
});		          
$( document ).on( "mouseout", "div.listAutoSuggest > ul",function(){
  // $(this).slideUp('fast');
        });  

$( document ).on( "keydown", "input.txtAuto", function() {


  var theValue=$(this).val();

  var listUl=$(this).parent().children('.listAutoSuggest');

  var keyName=$(this).attr('data-key');


  if(theValue.length > 1 )
  {

    $.ajax({
     type: "POST",
     url: root_url+"admincp/news/"+keyName,
     data: ({
        do : "load",
        keyword : theValue
        }),
     dataType: "html",
     success: function(msg)
            {
             // $('#listtenPhuongAuto').html('<ul>'+msg+'</ul>');

             // $('#listtenPhuongAuto').slideDown('fast');
              listUl.html('<ul>'+msg+'</ul>');

            listUl.slideDown('fast');

             }
       });            
  }

});    

$( document ).on( "click", "div.listAutoSuggest > ul > li > span", function() {

    var theValue=$(this).text();

    var theID=$(this).attr('data-id');

    var theMethod=$(this).attr('data-method');

    var txtAuto=$(this).parent().parent().parent().parent().children('.txtAuto');

    txtAuto.val('');

    var theMaxSelect=txtAuto.attr('data-maxselect');

    var theNumSelect=txtAuto.attr('data-numselected');

    var numLi=$(this).parent().parent().parent().parent().children('.ulChosen').children('.li').length;

    if(parseInt(theNumSelect)==0 && parseInt(numLi) == parseInt(theMaxSelect))
    {

    	txtAuto.attr('disabled',true);

    	$(this).parent().parent().parent().slideUp('fast');

    	return false;
    } 
    var newLi='<li><span class="textChosen" >'+theValue+'</span><span title="Remove this" class="removeTextChosen">[x]</span>';

    if(theMethod=='category')
    {
    	newLi+='<input type="hidden" name="send[parentid]" class="valueChosen" value="'+theID+'" />';
    }

    	newLi+='</li></ul>';

    $(this).parent().parent().parent().parent().children('ul.ulChosen').append(newLi);
    $(this).parent().parent().parent().slideUp('fast');

    theNumSelect=parseInt(theNumSelect)+1;

    txtAuto.attr('data-numselected',theNumSelect);

    if(parseInt(theNumSelect) >= parseInt(theMaxSelect))
    {
    	txtAuto.attr('disabled',true);
    }

});    			
  </script>