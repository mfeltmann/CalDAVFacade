<?php

class HttpHeader {
    
    private $_supportedRequestMethods;
    
    function __construct( $supportedRequestMethods ) {
        
        $this->_supportedRequestMethods = $supportedRequestMethods;
    }
    
    function sendHeader( $requestMethod, $queryString, $requestBody ) {
        
        if( ( $requestMethod == head_request || $requestMethod == get_request ) && $queryString != '' ) {

            self::_send_not_found_header();
            return;
        }

        if( $requestMethod == options_request ) {
            
            self::_send_options_header();
            return;
        }
        
        else if( $requestMethod == post_request ) {
                        
            if( $queryString == 'post' ) {

                self::_send_no_content_header();
                return;
            }
            
            else if( $queryString == 'create' ) {

                self::_send_create_header();
                return;
            }
        }
        
        else if( $requestMethod == put_request ) {
            
            if( $queryString == 'entityID=emptee' ) {
                
                self::_send_no_content_header();
                return;
            }
            
            else if( $queryString == 'entityID=common' ) {
                
                self::_send_ok_header();
                return;
            }

            else if( $queryString == 'entityID=null' ) {
                
                self::_send_not_implemented_header();
                return;
            }
            
            else if( $queryString == 'entityID=missing' ) {
                
                self::_send_moved_permanently_header( 'http://localhost/~feltmann/CarSharing/index.php?entityID=moved' );
                return;
            }

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
    
        header( 'HTTP/1.1 404 NOT FOUND', true, 404 );
        header( 'Content-Length: 0' );
    }
    
    function _send_no_content_header() {
        
        header( 'HTTP/1.1 204 NO CONTENT', true, 204 );
        header( 'Content-Length: 0' );
    }
    
    function _send_create_header() {
        
        header( 'HTTP/1.1 201 CREATED', true, 201 );
        header( 'Content-Length: 0' );
    }

    function _send_ok_header() {

        header( 'HTTP/1.1 200 OK', true, 200 );
        header( 'Content-Length: 0' );
    }

    function _send_not_implemented_header() {
        
        header( 'HTTP/1.1 501 NOT IMPLEMENTED', true, 501 );
        header( 'Content-Length: 0' );
    }
    
    function _send_moved_permanently_header( $newLocation ) {
        
        header( 'HTTP/1.1 301 MOVED PERMANENTLY', true, 301 );
        header( 'Location: ' . $newLocation );
        header( 'Content-Length: 0' );
    }
}

?>