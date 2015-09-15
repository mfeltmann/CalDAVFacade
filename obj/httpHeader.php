<?php

class HttpHeader {
    
    private $_supportedRequestMethods;
    
    function __construct( $supportedRequestMethods ) {
        
        $this->_supportedRequestMethods = $supportedRequestMethods;
    }
    
    function sendHeader( $requestMethod, $queryString ) {
        
        
        
        if( $queryString != '' ) {

            self::_send_not_found_header();
            return;
        }

        if( $requestMethod == options_request ) {
            
            self::_send_options_header();
            return;
        }
        
        self::_send_ok_header();
        return;
    }

    function _send_options_header() {
    
        header( 'HTTP/1.1 200 OK', false, 200 );
        header( 'Allow: '.$this->_supportedRequestMethods );
        header( 'Content-Length: 0' );
    }
    

    function _send_not_found_header() {
    
        header( 'HTTP/1.1 404 NOT FOUND', false, 404 );
        header( 'Content-Length: 0' );
    }

    function _send_ok_header() {

        header( 'HTTP/1.1 200 OK', false, 200 );
        header( 'Content-Length: 0' );
    }

}

?>