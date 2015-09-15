<?php

class HttpHeader {
    
    function sendHeader( $requestMethod, $queryString ) {
        
        if( $queryString == '' ) {

            self::_send_ok_header();
            return;
        }

        self::_send_not_found_header();
        return;
    }
    
    function _send_ok_header() {

        header( "HTTP/1.1 200 OK", false, 200 );
        header( "Content-Length: 0" );
    }

    function _send_not_found_header() {
    
        header( "HTTP/1.1 404 NOT FOUND", false, 404 );
        header( "Content-Length: 0" );
    }
}

?>