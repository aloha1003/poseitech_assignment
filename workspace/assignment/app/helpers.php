<?php

/**
 * Global helpers file with misc functions
 *
 */
 if (!function_exists('output_result')) {
    function output_result($data) 
    { 
        $return = ['data' => $data];
        return \Response::json($return);
    }
 }
if (!function_exists('output_errorresult')) {
    function output_errorresult($data) 
    { 
        $return = [
                    'error'   => $data
                  ];
        return \Response::json($return);
    }
}
