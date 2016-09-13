
<style type="text/css">

.wrapper_products
{
  border:1px solid #cbcbcb;
  width: 100%;
  min-height: 300px;
  margin-bottom: 20px;
  overflow: scroll;
      overflow-y: auto;
    overflow-x: hidden;  
    max-height: 300px;  
}  

</style>
<form action="" method="post" enctype="multipart/form-data">

<!-- row -->
<div class="row">
  <!-- left -->
  <div class="col-lg-12 ">
    <!-- panel -->
    <div class="panel panel-default">
      <div class="panel-body">
      <h3>Add new collection</h3>
      <hr>      
        <?php echo $alert;?>

        <p>
          <label>Paste products's url which you want create collection into below box:</label>
          <textarea rows="15" class="form-control" name="urls"></textarea>
          
        </p>

<!--         <div class="wrapper_products">
          
        </div> -->

        <p>
          <button type="submit" name="btnAdd" class="btn btn-primary">Create</button>
        </p>
      </div>
    </div>
    <!-- panel -->



  </div>
  <!-- left -->
</div>
<!-- row -->



</form>

<script type="text/javascript">
var api_url='<?php echo System::getUrl();?>api/plugin/fastecommerce/';

var choices = [['Australia', 'au'], ['Austria', 'at'], ['Brasil', 'br']];

var my_autoComplete;

function autoCompleteProcess()
{
  my_autoComplete = new autoComplete({
      selector: 'input[name="product_title"]',
      minChars: 1,
      source: function(term, suggest){
          term = term.toLowerCase();
          
          var suggestions = [];
          for (i=0;i<choices.length;i++)
              if (~(choices[i][0]+' '+choices[i][1]).toLowerCase().indexOf(term)) suggestions.push(choices[i]);
          suggest(suggestions);
      },
      renderItem: function (item, search){
          search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
          var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
          return '<div class="autocomplete-suggestion" data-langname="'+item[0]+'" data-lang="'+item[1]+'" data-val="'+search+'">'+item[0].replace(re, "<b>$1</b>")+'</div>';
      },
      onSelect: function(e, term, item){
          alert('Item "'+item.getAttribute('data-langname')+' ('+item.getAttribute('data-lang')+')" selected by '+(e.type == 'keydown' ? 'pressing enter' : 'mouse click')+'.');
      }
  });  


}


function stopAutoComplete()
{
  my_autoComplete.destroy();
}

function getProductsJson()
{

}

$(document).ready(function(){

});
  

$( document ).on( "keydown", ".prod-title", function() {
  var val=$(this).val();

});  
</script>