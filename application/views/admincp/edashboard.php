<!-- <h3>Dashboard</h3>  -->
<script src="<?php echo ROOT_URL;?>bootstrap/chartjs/Chart.min.js"></script>
<!-- Panel -->
<div class="panel panel-default">
  <div class="panel-body">


    <!-- Row -->
    <div class="row">
    	<div class="col-lg-12">
     		<h4>Ecommerce Statitics:</h4>   		
    	</div>
    </div>
    <!-- End Row -->

    <!-- Row -->
    <div class="row">
    	<div class="col-lg-3">
     		<!-- <p><h4>Get Started</h4></p>	 -->
        <h4>Orders</h4> 
        <ul class="ulDashboard">
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Today orders: <span id="todayOrders">0</span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total orders: <span id="totalOrders">0</span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Success orders: <span id="successOrders">0</span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Pending orders: <span id="pendingOrders">0</span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Cancel orders: <span id="cancelOrders">0</span></a></li>

        </ul> 
    	</div>
        <div class="col-lg-3">
        <h4>Products</h4> 
        <ul class="ulDashboard">
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total products: <span id="totalProd">0</span></a></li>

        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Today discount: <span id="todayDiscount">0</span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total views: <span id="totalProdViews">0</span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Today reviews: <span id="todayReviews">0</span></a></li>
       <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Pending reviews: <span id="pendingReviews">0</span></a></li>

        </ul>               
      </div>
              <div class="col-lg-3">
        <h4>Coupons & Gift Vouchers</h4> 
        <ul class="ulDashboard">
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total coupons: <span id="totalCoupons">0</span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Today coupons: <span id="todayCoupons">0</span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total vouchers: <span id="totalVouchers">0</span></a></li>

        </ul>               
      </div>
           	<div class="col-lg-3">
     		<h4>Affiliate</h4> 
     		<ul class="ulDashboard">
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Current earned: <span id="currentEarned">0</span></a></li>
       <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Pending request payment: <span id="pendingRequestPayment">0</span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total completed payment: <span id="completeRequestPayment">0</span></a></li>

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
                <h4>Orders Statistics</h4>
                
                <table class="table table-hover">
                <thead>
                    <tr>
                    <td class="col-lg-3">Date</td>
                    <td class="col-lg-3">Total Products</td>
                    <td class="col-lg-5">Total Price</td>
                    <td class="col-lg-1">Status</td>
                    </tr>
                </thead>

                <tbody id="trLastOrders">

                </tbody>
                </table>
              </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
              <div class="panel-body">
                <h4>Reviews Statistics</h4>
                
                <table class="table table-hover">
                <thead>
                    <tr>
                    <td class="col-lg-3">Date</td>
                    <td class="col-lg-8">Product Name</td>
                    <td class="col-lg-1">Status</td>
                    </tr>
                </thead>

                <tbody id="trLastReviews">

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
                <h4>Affiliate Earn Statistics</h4>
                
                <table class="table table-hover">
                <thead>
                    <tr>
                    <td class="col-lg-6">Fullname</td>
                    <td class="col-lg-6 text-right">Earned</td>
                    </tr>
                </thead>

                <tbody id="trLastEarned">

                </tbody>
                </table>
              </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
              <div class="panel-body">
                <h4>Affiliate Commission Statistics</h4>
                
                <table class="table table-hover">
                <thead>
                    <tr>
                    <td class="col-lg-6">Fullname</td>
                    <td class="col-lg-6 text-right">Commission</td>
                    </tr>
                </thead>

                <tbody id="trLastCommision">

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
                <h4>Last Product Sales</h4>
                
                <table class="table table-hover">
                <thead>
                    <tr>
                    <td class="col-lg-6">Product Name</td>
                    <td class="col-lg-1">Quantity</td>
                     <td class="col-lg-5 text-right">Total Price</td>

                    </tr>
                </thead>

                <tbody id="trLastProSales">

                </tbody>
                </table>
              </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
              <div class="panel-body">
                <h4>Top Product Views</h4>
                
                <table class="table table-hover">
                <thead>
                    <tr>
                    <td class="col-lg-9">Product Name</td>
                    <td class="col-lg-3 text-right">Views</td>
                    </tr>
                </thead>

                <tbody id="trTopProdViews">

                </tbody>
                </table>
              </div>
            </div>
        </div>

    </div>
    <!-- row -->


<script>
var api_url='<?php echo ADMINCP_URL;?>ecommerce/stats/';


$(document).ready(function(){

// loadPostStats('statsPost','week');

// loadPostStats('statsUser','week');

// loadStats('ordersweek','statsOrders');

// loadStats('reviewsweek','statsReviews');

loadSummaryStats();




});


function loadStats(loadType,outPut)
{
    
    $.ajax({
type: "POST",
url: api_url+loadType,
data: ({
      do : "loadStats"
      }),
dataType: "html",
success: function(msg)
                {
                 // alert(msg);

                 $('#'+outPut).html(msg);
                 }
     });

}
function loadSummaryStats()
{
    
    $.ajax({
type: "POST",
url: api_url+'summaryStats',
data: ({
      do : "loadStats"
      }),
dataType: "json",
success: function(msg)
                {
                 // alert(msg);
                 $('#todayOrders').html(msg['todayOrders']);
                 $('#totalOrders').html(msg['totalOrders']);
                 $('#successOrders').html(msg['successOrders']);
                 $('#pendingOrders').html(msg['pendingOrders']);
                 $('#cancelOrders').html(msg['cancelOrders']);

                 $('#totalProd').html(msg['totalProd']);
                 $('#todayDiscount').html(msg['todayDiscount']);
                 $('#totalProdViews').html(msg['totalProdViews']);

                 $('#totalCoupons').html(msg['totalCoupons']);
                 $('#todayCoupons').html(msg['todayCoupons']);

                 $('#totalVouchers').html(msg['totalVouchers']);

                $('#todayReviews').html(msg['todayReviews']);
                $('#totalReviews').html(msg['totalReviews']);
                $('#pendingReviews').html(msg['pendingReviews']);
                $('#approvedReviews').html(msg['approvedReviews']);

                $('#completeRequestPayment').html(msg['completeRequestPayment']);
                $('#pendingRequestPayment').html(msg['pendingRequestPayment']);
                $('#currentEarned').html(msg['currentEarned']);

                loadLastOrders();

                loadLastReviews();

                loadLastEarned();

                loadLastCommision();

                loadLastProdSales();

                loadTopProdViews();
                 
                 }
     });

}
function loadLastOrders()
{
    
    $.ajax({
type: "POST",
url: api_url+'lastorders',
data: ({
      do : "loadStats"
      }),
dataType: "html",
success: function(msg)
                {
                 // alert(msg);
                 $('#trLastOrders').html(msg);
                 
                 }
     });

}
function loadLastReviews()
{
    
    $.ajax({
type: "POST",
url: api_url+'lastreviews',
data: ({
      do : "loadStats"
      }),
dataType: "html",
success: function(msg)
                {
                 // alert(msg);
                 $('#trLastReviews').html(msg);
                 }
     });

}
function loadLastEarned()
{
    
    $.ajax({
type: "POST",
url: api_url+'lastearned',
data: ({
      do : "loadStats"
      }),
dataType: "html",
success: function(msg)
                {
                 // alert(msg);
                 $('#trLastEarned').html(msg);
                 }
     });

}
function loadLastCommision()
{
    
    $.ajax({
type: "POST",
url: api_url+'lastcommision',
data: ({
      do : "loadStats"
      }),
dataType: "html",
success: function(msg)
                {
                 // alert(msg);
                 $('#trLastCommision').html(msg);
                 }
     });

}
function loadLastProdSales()
{
    
    $.ajax({
type: "POST",
url: api_url+'lastsales',
data: ({
      do : "loadStats"
      }),
dataType: "html",
success: function(msg)
                {
                 // alert(msg);
                 $('#trLastProSales').html(msg);
                 }
     });

}
function loadTopProdViews()
{
    
    $.ajax({
type: "POST",
url: api_url+'topprodviews',
data: ({
      do : "loadStats"
      }),
dataType: "html",
success: function(msg)
                {
                 // alert(msg);
                 $('#trTopProdViews').html(msg);
                 }
     });

}

</script>