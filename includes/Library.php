<?php

class Library
{

    public function get($keyName='')
    {
        switch ($keyName) {
            case 'bxslider':
                echo '
		        <!-- bxSlider Javascript file -->
		        <script src="'.THEME_URL.'js/jquery.bxslider.min.js"></script>
		        <!-- bxSlider CSS file -->
		        <link href="'.THEME_URL.'css/jquery.bxslider.css" rel="stylesheet" />
                ';
                break;
            case 'system':
                echo '
				<script src="'.ROOT_URL.'bootstrap/js/system.js"></script>
                ';
                break;
            
            default:
                echo '
                <link href="'.ROOT_URL.'bootstrap/css/ecommerce.css" rel="stylesheet">
                <script src="'.ROOT_URL.'bootstrap/js/ecommerce.js"></script>
                <script src="'.ROOT_URL.'bootstrap/js/system.js"></script>
		        <!-- bxSlider Javascript file -->
		        <script src="'.THEME_URL.'js/jquery.bxslider.min.js"></script>
		        <!-- bxSlider CSS file -->
		        <link href="'.THEME_URL.'css/jquery.bxslider.css" rel="stylesheet" />
                ';
                break;
        }

    }
}

?>