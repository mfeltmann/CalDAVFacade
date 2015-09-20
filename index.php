<?php

// Required Objects
include_once( './obj/requestHandler.php' );

// Instance vars for functional purposes
$request_method = $_SERVER['REQUEST_METHOD'];
$query_string = $_SERVER['QUERY_STRING'];

// Write something to the access log for debugging purposes.
$file = fopen('./access.log', 'a');
$timestamp = time();
$output_text = strval( $timestamp )."\t".$request_method."\t".$query_string."\n";

$result = fwrite( $file, $output_text, strlen($output_text) );
fclose( $file );
// EOW

$phpInput = fopen('php://input', 'r');
$requestBody = '';

while( $line = fgets( $phpInput) != false ) {
    
    $requestBody .= $line;
}

$phpRequestHandler = new HttpRequestHandler( );

$phpRequestHandler->handle( $request_method, apache_request_headers(), $query_string, $line);

?>
