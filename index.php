<?php


// Required Constants
include_once( 'const/RequestMethods.php' );


// Required Objects
include_once( 'obj/httpHeader.php' );
include_once( 'obj/httpBody.php' );


// Instance vars for functional purposes
$request_method = $_SERVER['REQUEST_METHOD'];
$query_string = $_SERVER['QUERY_STRING'];

$phpHeader = new HttpHeader();
$phpBody = new HttpBody();

// Write something to the access log for debugging purposes.
$file = fopen('./access.log', 'a');
$timestamp = time();
$output_text = strval( $timestamp )."\t".$request_method."\n";

$result = fwrite( $file, $output_text, strlen($output_text) );
fclose( $file );
// EOW

$phpHeader->sendHeader( $request_method, $query_string );

$phpBody->sendBody( $request_method, $query_string );

?>
