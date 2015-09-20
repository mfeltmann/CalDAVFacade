<?php

require_once('./obj/httpHeader.php');
require_once('./obj/httpBody.php');
require_once('./const/RequestMethods.php');

class HttpRequestHandler {
    
    protected $supportedRequestMethods = [ head_request, options_request, get_request, post_request, put_request, delete_request ];
    
    private $httpHeader;
    private $httpBody;
    
    function __construct( ) {
        
        $supportedRequestsMethods = implode( ',', $this->supportedRequestMethods );
        
        $this->httpHeader = new HttpHeader( $supportedRequestsMethods );
        $this->httpBody = new HttpBody();
    }
    
    function handle( $requestMethod, $requestHeader, $queryString, $requestBody = '' ) {
        
        if( $requestMethod == head_request ) {
            
            self::_handleHeadRequest( $requestHeader, $queryString );
            return;
        }
        
        else if( $requestMethod == options_request ) {
            
            self::_handleOptionsRequest( );
        }
        
        else if( $requestMethod == get_request ) {
            
            self::_handleGetRequest( $requestHeader, $queryString, $requestBody );
        }
        
        else if( $requestMethod == post_request ) {
            
            self::_handlePostRequest( $requestHeader, $queryString, $requestBody );
        }
        
        else if( $requestMethod == put_request ) {
            
            self::_handlePutRequest( $requestHeader, $requestBody, $queryString );
        }
        
        else if( $requestMethod == delete_request ) {
            
            self::_handleDeleteRequest( $requestHeader, $requestBody, $queryString );
        }
    }
    
    
    // Internal Methods
    
    function _handleGetRequest( $requestHeader, $queryString, $requestBody = '' ) {
        
        if( self::_isQueryValid( $queryString ) === true ) {
            
            $this->httpHeader->send_ok_header();
            echo $this->httpBody->sendBody( get_request, $queryString, $requestHeader, $requestBody );
        }
        
        else {
            
            $this->httpHeader->send_not_found_header();
        }
    }
    
    function _handleHeadRequest( $requestHeader, $queryString ) {
        
        if( self::_isQueryValid( $queryString ) === true ) {
            
            $this->httpHeader->send_ok_header();
        }
        
        else {
            
            $this->httpHeader->send_not_found_header();
        }
    }
    
    function _handleOptionsRequest( ) {
        
        $this->httpHeader->send_options_header();
    }
    
    function _handlePostRequest( $requestHeader, $queryString, $requestBody ) {
        
         if( self::_isQueryValid( $queryString ) === true ) {
            
            $this->httpHeader->send_ok_header();
            echo $this->httpBody->sendBody( post_request, $queryString, $requestHeader, $requestBody );
        }

        else if( self::_doesQueryAwaitAnswer( $queryString ) === false ) {
            
            $this->httpHeader->send_no_content_header();
        }
        
        else if( self::_doesQueryNeedCreation( $queryString ) === true ) {
            
            $this->httpHeader->send_create_header( 'http://localhost/~feltmann/CarSharing/index.php?entityID=created' );
        }
        
        else {
            
            $this->httpHeader->send_not_found_header();
        }       
    }
    
    function _handlePutRequest( $requestHeader, $requestBody, $queryString ) {
        
        if( self::_doesQueryAwaitAnswer( $queryString ) === false ) {
            
            $this->httpHeader->send_no_content_header();
        }
        
        else if( self::_isQueryImplemented( $queryString ) === false ) {
            
            $this->httpHeader->send_not_implemented_header();
        }
        
        else if( self::_doesQueryNeedCreation( $queryString ) === true ) {
            
            $this->httpHeader->send_ok_header();
            $this->httpBody->sendBodyMessage( 'Success' );
        }
        
        else if( self::_hasQueryResultMoved( $queryString ) ) {
            
            $this->httpHeader->send_moved_permanently_header( 'http://localhost/~feltmann/CarSharing/index.php?entityID=moved' );
        }
    }
    
    function _handleDeleteRequest( $requestHeader, $requestBody, $queryString ) {
        
        if( self::_isQueryImplemented( $queryString ) === false ) {
            
            $this->httpHeader->send_not_implemented_header();
        }        
        
        else if( self::_doesQueryAwaitAnswer( $queryString ) === false ) {
            
            $this->httpHeader->send_no_content_header();
        }

        else if( self::_doesQueryNeedCreation( $queryString ) ) {
            
            $this->httpHeader->send_ok_header();
            $this->httpBody->sendBodyMessage( 'Success' );
        }
        
        else if( self::_isQueryAccepted( $queryString ) ) {
            
            $this->httpHeader->send_accept_header();            
        }
        
        else if( self::_isQueryValid( $queryString ) === false ) {
            
            $this->httpHeader->send_not_found_header();
        }
        
    }
    
    
    // Conditionals
    
    function _isQueryValid( $queryString ) {
        
        if( $queryString === '' ) {
            
            return true;
        }
        
        return false;
    }
    
    function _doesQueryAwaitAnswer( $query ) {
        
        if( $query === 'post' || $query === 'entityID=emptee' ) {
            
            return false;
        }
        
        return true;
    }
    
    function _doesQueryNeedCreation( $query ) {
        
        if( $query === 'create' || $query === 'entityID=common' ) {
            
            return true;
        }
        
        return false;
    }
    
    function _isQueryImplemented( $query ) {
        
        if( $query === 'entityID=null' ) {
            
            return false;
        }
        
        return true;
    }
    
    function _hasQueryResultMoved( $query ) {
        
        if( $query === 'entityID=missing' ) {
            
            return true;
        }
        
        return false;
    }
    
    function _isQueryAccepted( $query ) {
        
        if( $query === 'entityID=pending' ) {
            
            return true;
        }
        
        return false;
    }
}

?>