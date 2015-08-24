<?php

class Alert
{
    public static function make($alertMessage = '')
    {
        ob_end_clean();

       	Response::headerCode(404);

        View::make('alert', array('alert' => $alertMessage));

        die();

    }
}


?>