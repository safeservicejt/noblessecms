<?php

function importProcess($conn,$fileName = 'db.sql')
{
    $filePath=dirname(__FILE__);

    $filePath.='/'.$fileName;

    if (file_exists($filePath)) {


        $conn->query("SET NAMES 'utf8';");

        // Temporary variable, used to store current query
        $templine = '';
        // Read in entire file
        $lines = file($filePath);
        // Loop through each line
        foreach ($lines as $line)
        {
        // Skip it if it's a comment
        if (substr($line, 0, 2) == '--' || $line == '')
            continue;

        // Add this line to the current segment
        $templine .= $line;
        // If it has a semicolon at the end, it's the end of the query
          if (substr(trim($line), -1, 1) == ';')
          {
              // Perform the query
              $conn->query($templine);
              if(isset($conn->error[5]))
              {
                throw new Exception($conn->error);
                      
              }   

              // Reset temp variable to empty
              $templine = '';
          }
        }       

    }

    return true;

}

?>