<script src="<?php echo ROOT_URL; ?>bootstrap/ckeditor/ckeditor.js"></script>
  <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/admincp/css/chosen.min.css">


<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Add new post</h3>
  </div>
  <div class="panel-body">

<div class="row">
		<form action="" method="post" enctype="multipart/form-data">
			<div class="col-lg-12">

				<?php echo $alert;?>
			</div>		


		<div class="col-lg-8">


			<!-- Add new -->
			<p>
			<label><strong>Title:</strong></label>
			<input type="text" name="send[title]" class="form-control" placeholder="Post title..." />
			</p>
			<p>
			<label><strong>Content:</strong></label>
			<textarea id="editor1" class="form-control ckeditor" rows="15" name="send[content]">Content here (support BBCode)</textarea>
			</p>
			<p>
			<label><strong>SEO Keywords:</strong></label>
			<input type="text" name="send[keywords]" class="form-control" placeholder="Keywords..." />
			</p>

			<p>
			<label><strong>Tags: (separate by commas)</strong></label>
			<input type="text" name="tags" class="form-control" placeholder="Tags..." />
			</p>



		</div>

		<!-- Right -->
		<div class="col-lg-4">
			<div class="row">
			<div class="col-lg-12">

        <p>
        <label><strong>Post type:</strong></label>
        <select class="form-control" name="send[post_type]">
        <option value="normal">Normal</option>
          <option value="image">Image</option>
          <option value="fullwidth">Full Width</option>

        </select>
        </p>

				<p class="pChosen">
				<div class="row">
				<div class="col-lg-12">
				<label><strong>Category</strong></label>
				<input type="text" class="form-control txtAuto" data-maxselect="1" data-numselected="0" data-method="category" data-key="jsonCategory" placeholder="Type here..." />
	              <div class="listAutoSuggest"><ul></ul></div>	
                  <ul class="ulChosen"></ul>
				</div>
				</div>

				</p>
				<p class="pChosen">
				<div class="row">
				<div class="col-lg-12">
				<label><strong>Page</strong></label>
				<input type="text" class="form-control txtAuto" data-maxselect="1" data-numselected="0" data-method="page" data-key="jsonPage" placeholder="Type here..." />
	              <div class="listAutoSuggest"><ul></ul></div>	
                  <ul class="ulChosen"></ul>
				</div>
				</div>

				</p>

			</div>
			<div class="col-lg-12">

				<p>
				<label><strong>Upload preview image:</strong></label>
				<select class="form-control uploadIMGMethod" name="uploadIMGMethod">
					<option value="frompc">From your PC</option>
					<option value="fromurl">From Url</option>
				</select>
				</p>

				<p class="pUploadIMGFromPc" style="display:block;">
				<label><strong>Choose image from pc:</strong></label>
				<input type="file" name="pcThumbnail" />
				</p>

					<p class="pUploadIMGFromUrl" style="display:none;">
				<label><strong>Or upload from url:</strong></label>
				<input type="text" class="form-control" name="urlThumbnail" placeholder="Url..." />
				</p>

			</div>

			</div>
		</div>
		<!-- end right -->
		<div class="col-lg-12">
			<p>
			<input type="hidden" name="send[status]" value="1" />
			<button type="submit" class="btn btn-info" name="btnAdd">Add new</button>
			</p>
		</div>		
		</form>


	</div>    
    
  </div>
</div>
  <script type="text/javascript">

			var root_url='<?php echo ROOT_URL;?>';

           $(document).ready(function(){

           	$('.uploadIMGMethod').change(function(){
           		var thisVal=$(this).val();

           		if(thisVal=='frompc')
           		{
           			$('.pUploadIMGFromPc').show();
            			$('.pUploadIMGFromUrl').hide();
           		}
           		if(thisVal=='fromurl')
           		{
           			$('.pUploadIMGFromPc').hide();
            			$('.pUploadIMGFromUrl').show();
           		}


           	});



           });

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
    	newLi+='<input type="hidden" name="catid" class="valueChosen" value="'+theID+'" />';
    }
    if(theMethod=='page')
    {
    	newLi+='<input type="hidden" name="pageid" class="valueChosen" value="'+theID+'" />';
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
