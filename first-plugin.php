<?php
/**
 * package firstplugin
 */
/*
plugin Name: first plugin
plugin URI: http://test.appfoster.com/
Description: This is my first attempt on writting a custom plugin.
Version: 1.0.0
Author: Animal  
Author URI: https://en.wikipedia.org/wiki/Animal
*/



add_shortcode( 'external_data', 'callback_function_name' );

function callback_function_name() {


    $url = 'https://raw.githubusercontent.com/LearnWebCode/json-example/master/animals-1.json' ;
   
    $arguments = array(
        'method' => 'GET',
    );
   
    $response = wp_remote_get( $url , $arguments );

    if ( is_wp_error( $response ) ) {
       $error_message = $response->get_error_message();
       return "something went wrong: $error_message";
    }

    $results = json_decode( wp_remote_retrieve_body( $response ) );
   
    $html = '';
    $html .= '<table>';
   
    $html .= '<tr>';
    $html .= '<td rowspan="2">Name</td>';
    $html .= '<td rowspan="2">Species</td>';
    $html .= '<td colspan="2">Foods</td>';
    $html .= '</tr>';
    $html .= '<tr>';
    $html .= '<td>likes</td>';
    $html .= '<td>dislikes</td>';
    $html .= '</tr>'; 
   
    foreach( $results as $result ) {
       $strLike = implode(" , " ,$result->foods->likes);
       $strDislike = implode(" , " ,$result->foods->dislikes);
   
    $html .= '<tr>';
    $html .= '<td>' . $result->name . '</td>';
    $html .= '<td>' . $result->species . '</td>';

     
   
    $html .= '<td>'  . $strLike . '</td>';
    $html .= '<td>' . $strDislike . '</td>';
    $html .= '</tr>';
    }
   
   
   
   
    $html .= '</table>';


    return $html;
}