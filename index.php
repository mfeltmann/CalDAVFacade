<?php

// Required Objects
include_once( './obj/requestHandler.php' );

// Instance vars for functional purposes
$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

$requestPathComponents = explode( '/', $request_uri );

// Write something to the access log for debugging purposes.
$file = fopen('./access.log', 'a');
$timestamp = time();
$output_text = strval( $timestamp )."\t".$request_method."\t".$request_uri."\n";

$result = fwrite( $file, $output_text, strlen($output_text) );
fclose( $file );
// EOW

// Example Path: /~feltmann/CarSharing/entity/1
// Path #0 is ''
// Path #1 is ~feltmann
// Path #2 is CarSharing

// Path #3 is Entity Type
// Path #4 is Entity ID

$entityType = '';
$entityID = '';

if( count( $requestPathComponents ) == 5 ) {
    
    $entityType = $requestPathComponents[3];
    $entityID = $requestPathComponents[4];
}

else if( count( $requestPathComponents ) == 4 ) {
    
    $entityType = $requestPathComponents[3];
}

$phpInput = fopen('php://input', 'r');
$requestBody = '';

while( $line = fgets( $phpInput) != false ) {
    
    $requestBody .= $line;
}

$phpRequestHandler = new HttpRequestHandler( );

$phpRequestHandler->handle( $request_method, apache_request_headers(), $entityType, $entityID, $line);

?>
