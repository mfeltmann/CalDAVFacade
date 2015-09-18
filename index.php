<?php


// Required Constants
include_once( 'const/RequestMethods.php' );


// Required Objects
include_once( 'obj/httpHeader.php' );
include_once( 'obj/httpBody.php' );


// Instance vars for functional purposes
$request_method = $_SERVER['REQUEST_METHOD'];
$query_string = $_SERVER['QUERY_STRING'];

$phpHeader = new HttpHeader( 'HEAD,OPTIONS,GET,POST,PUT,DELETE' );
$phpBody = new HttpBody();

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

$phpHeader->sendHeader( $request_method, $query_string, $requestBody );
$phpBody->sendBody( $request_method, $query_string, apache_request_headers(), $requestBody );

?>
