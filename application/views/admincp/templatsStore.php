
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Templates Store</h3>
  </div>
  <div class="panel-body">


    <!-- row -->
  <div class="row">
  	<div class="col-lg-6">
        <ul class="plugin-store-ul">
          <li><a href="#" id="showLastest">Lastest</a> </li>
           <li><a href="#" id="showFeatured">Featured</a> </li>
           <li><a href="#" id="showPopular">Popular</a> </li>

        </ul>
    </div>

    <div class="col-lg-3 col-lg-offset-3 text-right">
      <div class="input-group input-group-sm">
        <input type="text" class="form-control" placeholder="Search for...">
        <span class="input-group-btn">
          <button class="btn btn-primary" type="button"><span  class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
        </span>
      </div><!-- /input-group -->      
    </div>
  </div>
    <!-- row -->
  </div>
</div>

<div class="row rowListItem">

  <?php echo $theList;?> 
  
</div>

<div class="row">
	<div class="col-lg-12 text-right">
  <nav>
    <ul class="pagination pagination-sm">
    <li class="previous"><a href="#" id="btnShowOlder"><span aria-hidden="true">&larr;</span> Older</a></li>
    <li class="next"><a href="#" id="btnShowNewer">Newer <span aria-hidden="true">&rarr;</span></a></li>
    </ul>
  </nav>		
	</div>
</div>


<script>

var root_url='<?php echo ROOT_URL;?>';
var api_url=root_url+'api/';

var showType='lastest';

var showMethod='template';

var thePage=0;

  function panda_show_loading()
  {
    // $('.panda-loading').show();
  }

  function panda_hide_loading()
  {
    // $('.panda-loading').hide();
  }

$(document).ready(function(){

  $('#showLastest').click(function(){

    panda_show_loading();

    showType='lastest';

    thePage=0;

   $.ajax({
    async: false,
     type: "POST",
     url: api_url+'pluginstore/loadhtml',
     dataType: "json",
   data: ({
          send_page : thePage,
          send_showtype : showType,
          send_method : showMethod
          }),
     error : function(XMLHttpRequest, textStatus, errorThrown){

      panda_hide_loading();

      alert('Error: '+textStatus);

     },
     success: function(msg)
            {
              // alert(msg);return false;
              panda_hide_loading();

              $(this).attr('disabled',false);

              $('.rowListItem').html(msg['data']);
              
             }
       });    
  });
  $('#showFeatured').click(function(){

    panda_show_loading();

    showType='featured';

    thePage=0;

    $.ajax({
      async: false,
       type: "POST",
       url: api_url+'pluginstore/loadhtml',
       dataType: "json",
     data: ({
            send_page : thePage,
            send_showtype : showType,
            send_method : showMethod
            }),
       error : function(XMLHttpRequest, textStatus, errorThrown){
        panda_hide_loading();

        alert('Error: '+textStatus);

       },
       success: function(msg)
              {
                // alert(msg);return false;
                panda_hide_loading();

                $(this).attr('disabled',false);

                $('.rowListItem').html(msg['data']);
                
               }
         });     
  });
	$('#showPopular').click(function(){

    panda_show_loading();

    showType='popular';

    thePage=0;

    $.ajax({
      async: false,
       type: "POST",
       url: api_url+'pluginstore/loadhtml',
       dataType: "json",
     data: ({
            send_page : thePage,
            send_showtype : showType,
            send_method : showMethod
            }),
       error : function(XMLHttpRequest, textStatus, errorThrown){
      panda_hide_loading();

        alert('Error: '+textStatus);

       },
       success: function(msg)
              {
                // alert(msg);return false;
                panda_hide_loading();

                $(this).attr('disabled',false);

                $('.rowListItem').html(msg['data']);
                
               }
         }); 
  });


});

$( document ).on( "click", "#btnShowNewer", function() {

panda_show_loading();

  $(this).attr('disabled',true);

  // alert(theUrl);return false;

  thePage=parseInt(thePage)+1;


  $.ajax({
    async: false,
     type: "POST",
     url: api_url+'pluginstore/loadhtml',
     dataType: "json",
   data: ({
          send_page : thePage,
          send_showtype : showType,
          send_method : showMethod
          }),
     error : function(XMLHttpRequest, textStatus, errorThrown){

      alert('Error: '+textStatus);
      panda_hide_loading();

     },
     success: function(msg)
            {
              // alert(msg);return false;
              panda_hide_loading();

              $(this).attr('disabled',false);

              $('.rowListItem').html(msg['data']);
              
             }
       }); 
}); 
$( document ).on( "click", "#btnShowOlder", function() {

panda_show_loading();

  $(this).attr('disabled',true);

  // alert(theUrl);return false;

  if(parseInt(thePage)==0)
  {
    return false;
  }
    thePage=parseInt(thePage)-1;



  $.ajax({
    async: false,
     type: "POST",
     url: api_url+'pluginstore/loadhtml',
     dataType: "json",
   data: ({
          send_page : thePage,
          send_showtype : showType,
          send_method : showMethod
          }),
     error : function(XMLHttpRequest, textStatus, errorThrown){
      panda_hide_loading();

      alert('Error: '+textStatus);

     },
     success: function(msg)
            {
              // alert(msg);return false;
             panda_hide_loading();

              $(this).attr('disabled',false);

              $('.rowListItem').html(msg['data']);
              
             }
       }); 
}); 

$( document ).on( "click", "button#btnInstall", function() {

  var theUrl=$(this).attr('data-url');

  $(this).attr('disabled',true);

  // alert(theUrl);return false;

  $.ajax({
    async: false,
     type: "POST",
     url: api_url+'pluginstore/install',
     dataType: "json",
   data: ({
          send_url : theUrl,
          send_method : showMethod
          }),
     error : function(XMLHttpRequest, textStatus, errorThrown){

      alert('Error: '+textStatus);

     },
     success: function(msg)
            {
              if(msg['error']=='no')
              {
                alert('Download success. Your can go to templates manage page!');
              }
              else
              {
                alert(msg['message']);
              }
              
             }
       }); 
}); 

</script>
