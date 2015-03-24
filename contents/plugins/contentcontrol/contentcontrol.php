<?php

Plugins::$control='lastest_news';

// Plugins::$setting='lastest_news_setting';

Plugins::install('install_contentcontrol');



function install_contentcontrol()
{
		//Plugins::add('admin_header',array('content'=>'<script>alert("dfdf");</script>'));

		//Plugins::add('admin_footer',array('content'=>'<script>var FooterContent="demo";</script>'));

}

function lastest_news($inputData=array())
{
	$lastest=Post::get(array());

  $total=count($lastest);

  $li='';

  for($i=0;$i<$total;$i++)
  {
    $li.='

  <!--Post-->
  <div class="row post_home">
      <div class="col-md-12">
          <a href="'.Url::post($lastest[$i]).'" class="atext-brown"><h3>'.stripslashes($lastest[$i]['title']).'</h3></a>
          <span>Posted in <a href="'.$lastest[$i]['caturl'].'" class="atext-orange">'.$lastest[$i]['cattitle'].'</a></span>
      </div>
      <div class="col-md-12">
          <img src="'.$lastest[$i]['image'].'" class="img-responsive" />
      </div>
      <div class="col-md-11 text-right"><br>
          <a href="#" class="atext-orange">Comment <span class="badge">42</span></a>
          &nbsp;&nbsp;&nbsp;
          <a href="#" class="atext-orange">Read more >></a>

      </div>
  </div> 

    ';
  }

  return $li;	
}

?>