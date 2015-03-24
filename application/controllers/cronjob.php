<?php

class cronjob
{

	public function index()
	{


	}

    public function getRun()
    {
        
        if(Uri::has('cronjob\/run\/all.php$'))
        {
            Cronjobs::run();
        }  

        if($match=Uri::match('cronjob\/run\/(\d+).php$'))
        {
            Cronjobs::runSingle($match[1]);
        }        

    }
}

?>