<!-- <h3>Dashboard</h3>  -->
<script src="<?php echo ROOT_URL;?>bootstrap/chartjs/Chart.min.js"></script>
<!-- Panel -->
<div class="panel panel-default">
  <div class="panel-body">


    <!-- Row -->
    <div class="row">
    	<div class="col-lg-12">
     		<h4>Welcome to Noblesse CMS</h4>   		
    	</div>
    </div>
    <!-- End Row -->

    <!-- Row -->
    <div class="row">
    	<div class="col-lg-4">
     		<!-- <p><h4>Get Started</h4></p>	 -->
     		<img src="<?php echo ROOT_URL;?>bootstrap/images/logo128.png" />
    	</div>
      	<div class="col-lg-4">
     		<h4>Next Steps</h4> 
     		<ul class="ulDashboard">
     		<li><a href="<?php echo ROOT_URL;?>admincp/news/addnew"><span class="glyphicon glyphicon-plus-sign"></span> Write a post</a></li>
     		<li><a href="<?php echo ROOT_URL;?>admincp/pages/addnew"><span class="glyphicon glyphicon-th-large"></span> Create a page</a></li>
     		<li><a href="<?php echo ROOT_URL;?>admincp/categories"><span class="glyphicon glyphicon-th-list"></span> Manage categories</a></li>

     		</ul>     		  		
    	</div>
      	<div class="col-lg-4">
     		<h4>More Actions</h4>
      		<ul class="ulDashboard">
     		<li><a href="<?php echo ROOT_URL;?>admincp/setting"><span class="glyphicon glyphicon-cog"></span> Change your system status</a></li>
     		<li><a href="<?php echo ROOT_URL;?>admincp/setting"><span class="glyphicon glyphicon-list-alt"></span> Config your site information</a></li>
     		<li><a href="<?php echo ROOT_URL;?>admincp/plugins"><span class="glyphicon glyphicon-wrench"></span> Manage plugins</a></li>

     		</ul>    		   		
    	</div>

    </div>
    <!-- End Row -->




  </div>
</div>
 <!-- End panel -->
<!-- Panel -->
<div class="panel panel-default">
  <div class="panel-body">


    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">
            <h4>News feed:</h4>           
        </div>
    </div>
    <!-- End Row -->

    <!-- Row -->
    <div class="row">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=882186538492766&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>    
        <div class="col-lg-6">
<div class="fb-post" data-href="https://www.facebook.com/permalink.php?story_fbid=858563977529771&id=858562830863219" data-width="500"></div>              
 
        </div>
        <div class="col-lg-6">


<div class="fb-post" data-href="https://www.facebook.com/permalink.php?story_fbid=1600068756891459&id=1600068363558165" data-width="500"></div>              
      </div>

  
    </div>
    <!-- End Row -->




  </div>
</div>
 <!-- End panel -->

<!-- Panel -->
<div class="panel panel-default">
  <div class="panel-body">


    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">
            <h4>Statitics:</h4>           
        </div>
    </div>
    <!-- End Row -->

    <!-- Row -->
    <div class="row">
        <div class="col-lg-3">
            <!-- <p><h4>Get Started</h4></p>     -->
        <h4>Post</h4> 
        <ul class="ulDashboard">
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Today post: <span id="todayPost">0</span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total post: <span id="totalPost">0</span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Pubished posts: <span id="publishPost">0</span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Pending posts: <span id="pendingPost">0</span></a></li>
  
        </ul> 
        </div>
        <div class="col-lg-3">
        <h4>Comments</h4> 
        <ul class="ulDashboard">
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Today comments: <span id="todayComment">0</span></a></li>
       <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total comments: <span id="totalComment">0</span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Approved comments: <span id="approvedComment">0</span></a></li>
       <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Pending comments: <span id="pendingComment">0</span></a></li>

        </ul>               
      </div>
              <div class="col-lg-3">
        <h4>Contacts</h4> 
        <ul class="ulDashboard">
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Today contacts: <span id="todayContact">0</span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total contacts: <span id="totalContact">0</span></a></li>

        </ul>               
      </div>
            <div class="col-lg-3">
            <h4>Users</h4> 
            <ul class="ulDashboard">
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Today users: <span id="todayUsers">0</span></a></li>
       <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total users: <span id="totalUsers">0</span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Pending users: <span id="pendingUsers">0</span></a></li>

            </ul>                   
        </div>

  
    </div>
    <!-- End Row -->




  </div>
</div>
 <!-- End panel -->

    <!-- row -->
    <div class="row">


        <div class="col-lg-6">
            <div class="panel panel-default">
              <div class="panel-body">
                <h4>Top posts view</h4>
                
                <table class="table table-hover">
                <thead>
                    <tr>
                    <td class="col-lg-6">Title</td>
                    <td class="col-lg-6 text-right">Views</td>
                    </tr>
                </thead>

                <tbody id="trTopViews">

                </tbody>
                </table>
              </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
              <div class="panel-body">
                <h4>Top posts comment</h4>
                
                <table class="table table-hover">
                <thead>
                    <tr>
                    <td class="col-lg-6">Title</td>
                    <td class="col-lg-6 text-right">Comments</td>
                    </tr>
                </thead>

                <tbody id="trTopComments">

                </tbody>
                </table>
              </div>
            </div>
        </div>

    </div>
    <!-- row -->
    <!-- row -->
    <div class="row">


        <div class="col-lg-6">
            <div class="panel panel-default">
              <div class="panel-body">
                <h4>Last post comment</h4>
                
                <table class="table table-hover">
                <thead>
                    <tr>
                    <td class="col-lg-3">Date</td>
                    <td class="col-lg-3">Full name</td>
                    <td class="col-lg-6">PostTitle</td>
                    
                    </tr>
                </thead>

                <tbody id="trLastPostComments">

                </tbody>
                </table>
              </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
              <div class="panel-body">
                <h4>Last contactus</h4>
                
                <table class="table table-hover">
                <thead>
                    <tr>
                    <td class="col-lg-3">Date</td>
                    <td class="col-lg-3">Fullname</td>
                    <td class="col-lg-6 text-right">Email</td>
                    </tr>
                </thead>

                <tbody id="trLastContactus">

                </tbody>
                </table>
              </div>
            </div>
        </div>

    </div>
    <!-- row -->

<script>
var api_url='<?php echo ADMINCP_URL;?>dashboard/stats/';


$(document).ready(function(){

loadSummaryStats();

loadTopViews();

loadTopComments();

lastPostComments();

lastContactus();

});

function loadSummaryStats()
{
    
    $.ajax({
type: "POST",
url: api_url+'summarystats',
data: ({
      do : "loadStats"
      }),
dataType: "json",
success: function(msg)
                {
                 // alert(msg);
                 $('#todayPost').html(msg['todayPost']);
                 $('#totalPost').html(msg['totalPost']);
                 $('#publishPost').html(msg['publishPost']);
                 $('#pendingPost').html(msg['pendingPost']);
                 $('#todayComment').html(msg['todayComment']);
                 $('#totalComment').html(msg['totalComment']);
                 $('#approvedComment').html(msg['approvedComment']);
                 $('#pendingComment').html(msg['pendingComment']);
                 $('#todayContact').html(msg['todayContact']);
                 $('#totalContact').html(msg['totalContact']);
                 $('#todayUsers').html(msg['todayUsers']);
                 $('#totalUsers').html(msg['totalUsers']);
                 $('#pendingUsers').html(msg['pendingUsers']);
                 
                 }
     });

}


function loadTopComments()
{
    
    $.ajax({
type: "POST",
url: api_url+'topcomments',
data: ({
      do : "loadStats"
      }),
dataType: "html",
success: function(msg)
                {
                 // alert(msg);
                 $('#trTopComments').html(msg);
                 }
     });

}

function loadTopViews()
{
    
    $.ajax({
type: "POST",
url: api_url+'topviews',
data: ({
      do : "loadStats"
      }),
dataType: "html",
success: function(msg)
                {
                 // alert(msg);
                 $('#trTopViews').html(msg);
                 }
     });

}
function lastPostComments()
{
    
    $.ajax({
type: "POST",
url: api_url+'lastpostcomments',
data: ({
      do : "loadStats"
      }),
dataType: "html",
success: function(msg)
                {
                 // alert(msg);
                 $('#trLastPostComments').html(msg);
                 }
     });

}
function lastContactus()
{
    
    $.ajax({
type: "POST",
url: api_url+'lastcontactus',
data: ({
      do : "loadStats"
      }),
dataType: "html",
success: function(msg)
                {
                 // alert(msg);
                 $('#trLastContactus').html(msg);
                 }
     });

}

</script>