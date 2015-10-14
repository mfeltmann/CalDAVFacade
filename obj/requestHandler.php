<?php

require_once('./obj/http/httpHeader.php');
require_once('./obj/http/httpBody.php');
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
    
    function handle( $requestMethod, $requestHeader, $entityType, $entityID, $requestBody = '' ) {
        
        if( $requestMethod == head_request ) {
            
            self::_handleHeadRequest( $requestHeader, $entityType, $entityID );
            return;
        }
        
        else if( $requestMethod == options_request ) {
            
            self::_handleOptionsRequest( );
        }
        
        else if( $requestMethod == get_request ) {
            
            self::_handleGetRequest( $requestHeader, $entityType, $entityID, $requestBody );
        }
        
        else if( $requestMethod == post_request ) {
            
            self::_handlePostRequest( $requestHeader, $entityType, $entityID, $requestBody );
        }
        
        else if( $requestMethod == put_request ) {
            
            self::_handlePutRequest( $requestHeader, $requestBody, $entityType, $entityID );
        }
        
        else if( $requestMethod == delete_request ) {
            
            self::_handleDeleteRequest( $requestHeader, $requestBody, $entityType, $entityID );
        }
    }
    
    
    // Internal Methods
    
    function _handleGetRequest( $requestHeader, $entityType, $entityID, $requestBody = '' ) {
        
        if( self::_doesEntityExist( $entityType, $entityID ) === true ) {
            
            $this->httpHeader->send_ok_header();
            echo $this->httpBody->sendBody( get_request, $entityType, $entityID, $requestHeader, $requestBody );
        }
        
        else {
            
            $this->httpHeader->send_not_found_header();
        }
    }
    
    function _handleHeadRequest( $requestHeader, $entityType, $entityID ) {
        
        if( self::_doesEntityExist( $entityType, $entityID ) === true ) {
            
            $this->httpHeader->send_ok_header();
        }
        
        else {
            
            $this->httpHeader->send_not_found_header();
        }
    }
    
    function _handleOptionsRequest( ) {
        
        $this->httpHeader->send_options_header();
    }
    
    function _handlePostRequest( $requestHeader, $entityType, $entityID, $requestBody ='' ) {
        
        if( self::_doesEntityAwaitAnswer( $entityType, $entityID ) === false ) {
            
            $this->httpHeader->send_no_content_header();
        }
        
        else if( self::_doesEntityNeedCreation( $entityType, $entityID ) === true ) {
            
            $this->httpHeader->send_create_header( 'http://localhost/~feltmann/CarSharing/entity/created' );
        }
        
        else if( self::_doesEntityExist( $entityType, $entityID ) === true ) {
            
            $this->httpHeader->send_ok_header();
            echo $this->httpBody->sendBody( post_request, $entityType, $entityID, $requestHeader, $requestBody );
        }

        else {
            
            $this->httpHeader->send_not_found_header();
        }       
    }
    
    function _handlePutRequest( $requestHeader, $requestBody, $entityType, $entityID ) {
        
        if( self::_isEntityImplemented( $entityType, $entityID ) === false ) {
            
            $this->httpHeader->send_not_implemented_header();
        }
        
        else if( self::_doesEntityNeedCreation( $entityType, $entityID ) === true ) {
            
            $this->httpHeader->send_ok_header();
            $this->httpBody->sendBodyMessage( 'Success' );
        }
        
        else if( self::_hasEntityMoved( $entityType, $entityID ) ) {
            
            $this->httpHeader->send_moved_permanently_header( 'http://localhost/~feltmann/CarSharing/entity/moved' );
        }
        
        else if( self::_doesEntityAwaitAnswer( $entityType, $entityID ) === false ) {
            
            $this->httpHeader->send_no_content_header();
        }
    }
    
    function _handleDeleteRequest( $requestHeader, $requestBody, $entityType, $entityID ) {
        
        if( self::_isEntityImplemented( $entityType, $entityID ) === false ) {
            
            $this->httpHeader->send_not_implemented_header();
        }        
        
        else if( self::_doesEntityAwaitAnswer( $entityType, $entityID ) === false ) {
            
            $this->httpHeader->send_no_content_header();
        }

        else if( self::_doesEntityNeedCreation( $entityType, $entityID ) ) {
            
            $this->httpHeader->send_ok_header();
            $this->httpBody->sendBodyMessage( 'Success' );
        }
        
        else if( self::_isEntityAccepted( $entityType, $entityID ) ) {
            
            $this->httpHeader->send_accept_header();            
        }
        
        else if( self::_doesEntityExist( $entityType, $entityID ) === false ) {
            
            $this->httpHeader->send_not_found_header();
        }
        
    }
    
    
    // Conditionals
    
    function _doesEntityExist( $entityType, $entityID ) {
        
        if( $entityType === 'NothingInHere' || $entityType === 'QueryStringNotFound' || $entityID === 'missing' ) {
            
            return false;
        }
        
        return true;
    }
    
    function _doesEntityAwaitAnswer( $entityType, $entityID ) {
        
        if( $entityType === 'post' || $entityID === 'emptee' ) {
            
            return false;
        }
        
        return true;
    }
    
    function _doesEntityNeedCreation( $entityType, $entityID ) {
        
        if( $entityType === 'create' || $entityID === 'common' ) {
            
            return true;
        }
        
        return false;
    }
    
    function _isEntityImplemented( $entityType, $entityID ) {
        
        if( $entityID === 'null' ) {
            
            return false;
        }
        
        return true;
    }
    
    function _hasEntityMoved( $entityType, $entityID ) {
        
        if( $entityID === 'missing' ) {
            
            return true;
        }
        
        return false;
    }
    
    function _isEntityAccepted( $entityType, $entityID ) {
        
        if( $entityID === 'pending' ) {
            
            return true;
        }
        
        return false;
    }
}

?>