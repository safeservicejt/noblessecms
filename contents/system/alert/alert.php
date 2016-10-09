<!DOCTYPE html>
<html>
<head>
	<title>Alert</title>
</head>
<style type="text/css">
body
{
	margin: 0px;
	padding: 0px;
	color: #ffffff;
	background-color: #0083ff;
}
.wrapper
{	margin:0px;
	padding: 0px;
	width: 100%;
	min-height: 600px;
	
	text-align: center;
	font-size: 22px;
}

.wrapper-link
{
	position: absolute;
	bottom: 0px;
	right: 10px;

}

.wrapper-link a,
.wrapper-link a:visited
{
	color: #ffffff;
	text-decoration: none;
}

.wrapper .box-center
{
	padding-top: 15%;
}
</style>
<body>
<div class="wrapper">
	<div class="box-center"><?php echo $inputData;?></div>

</div>

<div class="wrapper-link"><a target="_blank" href="http://noblessecms.com/">Powered by Noblesse CMS</a></div>
</body>
</html>