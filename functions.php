<?php


function objectToArray($d) {
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $d);
    }
    else {
        // Return array
        return $d;
    }
}

function sanitize_output($buffer) {

    $search = array(
        '/[\r\n]+/s',  // strip whitespaces after tags, except space
        '/(\s)+/s',       // shorten multiple whitespace sequences
        '/\>\s+\</'       // shorten multiple whitespace sequences
    );

    $replace = array(
        '',
        '\\1',
        '><'
    );

    $buffer = preg_replace($search, $replace, $buffer);

    return $buffer;
}