<?php

class HttpHeader {
    
    private $_supportedRequestMethods;
    
    function __construct( $supportedRequestMethods ) {
        
        $this->_supportedRequestMethods = $supportedRequestMethods;
    }
    
    function send_options_header() {
    
        header( 'HTTP/1.1 200 OK', false, 200 );
        header( 'Allow: '.$this->_supportedRequestMethods );
        header( 'Content-Length: 0' );
    }
    

    function send_not_found_header() {
    
        header( 'HTTP/1.1 404 NOT FOUND', true, 404 );
        header( 'Content-Length: 0' );
    }
    
    function send_no_content_header() {
        
        header( 'HTTP/1.1 204 NO CONTENT', true, 204 );
        header( 'Content-Length: 0' );
    }
    
    function send_create_header( $newLocation ) {
        
        header( 'HTTP/1.1 201 CREATED', true, 201 );
        header( 'Location: ' . $newLocation );
        header( 'Content-Length: 0' );
    }

    function send_ok_header() {

        header( 'HTTP/1.1 200 OK', true, 200 );
        header( 'Content-Length: 0' );
    }

    function send_not_implemented_header() {
        
        header( 'HTTP/1.1 501 NOT IMPLEMENTED', true, 501 );
        header( 'Content-Length: 0' );
    }
    
    function send_moved_permanently_header( $newLocation ) {
        
        header( 'HTTP/1.1 301 MOVED PERMANENTLY', true, 301 );
        header( 'Location: ' . $newLocation );
        header( 'Content-Length: 0' );
    }
    
    function send_accept_header() {
        
        header( 'HTTP/1.1 202 ACCEPT', true, 202 );
        header( 'Content-Length: 0' );
    }
}

?>