<?php

class HttpBody {
    
    function sendBody( $requestMethod, $queryString ) {
        
        if( $requestMethod == head_request ) {
            
            echo self::emptyBody();
            return;
        }
    }
    
    function emptyBody() {
        return '';
    }
}

?>