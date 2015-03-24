<?php

Plugins::$control='aboutus_page';

Plugins::install('install_addaboutspage');



function install_addaboutspage()
{

Plugins::add('special_page',array('name'=>'aboutus','func'=>'aboutus_page'));

}

function aboutus_page($inputData=array())
{

	echo 'This is about us page';
}
?>