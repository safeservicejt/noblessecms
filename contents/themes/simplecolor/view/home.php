<!-- body -->
<div class="container">

<!-- slide -->
<div class="row">
<div class="col-lg-12">

</div>
</div>
<!-- slide -->


<div class="row">
<!-- left -->
<div class="col-lg-8">
<?php if(isset($themeSetting['site_top_content']))echo $themeSetting['site_top_content'];?>

<?php

$li='';

$total=count($newPost);

if(isset($newPost[0]['postid']))
for($i=0;$i<$total;$i++)
{
	$image=isset($newPost[$i]['imageUrl'])?$newPost[$i]['imageUrl']:'';

	if(preg_match('/.*?\.\w+/i', $image))
	{
		$image='
		<div class="image"><a href="'.$newPost[$i]['url'].'" title="'.$newPost[$i]['title'].'"><img data-src="'.$image.'" class="js-auto-responsive" /></a></div>
		';
	}
	else
	{
		$image='';
	}

	$li.='
	<!-- items -->
	<div class="row">

	<div class="col-lg-12">
	'.$image.'
	<div class="well well-post-content">

	<!-- title -->
	<div class="row">
	<div class="col-lg-12"><a href="'.$newPost[$i]['url'].'"><h2>'.$newPost[$i]['title'].'</h2></a></div>
	</div>
	<!-- title -->
	<!-- post info -->
	<div class="row">
	<div class="col-lg-12">
	<p>
	  <span class="glyphicon glyphicon-calendar" title="Date Created"></span> <span title="'.$newPost[$i]['date_added'].'">'.$newPost[$i]['date_addedFormat'].'</span>
	  &nbsp;&nbsp;
	  <span class="glyphicon glyphicon-globe" title="Views"></span> <span title="Views">'.number_format($newPost[$i]['views']).'</span>

	</p>
	</div>
	</div>
	<!-- post info -->

	<!-- content -->
	<div class="row">
	<div class="col-lg-12">
	  '.Render::rawContent($newPost[$i]['content'],0,500).'
	</div>
	</div>
	<!-- content -->

	<!-- read more -->
	<div class="row">
	<div class="col-lg-12 text-right"><br>
	<a href="'.$newPost[$i]['url'].'" class="btn btn-danger">Read more</a>
	</div>
	</div>
	<!-- read more -->





	</div>
	</div>

	</div>
	<!-- items -->


	';
}

echo $li;

?>
<!-- page -->
<div class="row">
  <div class="col-lg-12 text-right">
   <?php echo $listPage;?>                               
  </div>
</div>
<!-- page -->

<?php if(isset($themeSetting['site_bottom_content']))echo $themeSetting['site_bottom_content'];?>

</div>
<!-- left -->
<!-- right -->
<?php View::makeWithPath('right',array(),$themePath);?>

<!-- right -->
</div>

</div>
<!-- body -->