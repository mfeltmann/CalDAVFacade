<?php

class HttpBody {
    
    function sendBody( $requestMethod, $queryString, $requestHeaders, $requestBody ) {
        
        // Neither HEAD nor OPTIONS require a body.
                
        if( $requestMethod == get_request ) {
            
            echo self::getBodyForResourceFilteredByHeaders( $queryString, $requestHeaders );
        }
        else if( $requestMethod == post_request ) {

            if( $queryString == 'create' ) {

                echo self::getBodyForResourceFilteredByHeaders( $queryString, $requestHeaders, $requestBody );                
            }
        }
        else if( $requestMethod == put_request ) {
            
            if( $queryString == 'entityID=common' ) {
                
                echo 'Success';
                return;
            }
            
            else  if( $queryString == 'entityID=emptee' ) {
                
                return;
            }

            else  if( $queryString == 'entityID=null' ) {
                
                return;
            }
            
            else  if( $queryString == 'entityID=missing' ) {
                
                return;
            }            
        }
    }

    function getBodyForResourceFilteredByHeaders( $resource, $requestHeaders ) {
    
        return self::getBodyForResourceFilteredByHeadersAndBody($resource, $requestHeaders, '' );
    }
    
    function getBodyForResourceFilteredByHeadersAndBody( $resource, $requestHeaders, $requestBody ) {
        
        if( $resource == 'create' ) {
            
            return 'http://localhost/~feltmann/CarSharing/index.php?entityID=1';
        }
        
        else if( $resource != '' ) {
            
            return '';
        }
        
        $possibleArray = ['all', 'new', 'old', 'matched', 'unmatched', 'ranged'];
        
        /** Restriction Mask Values
         *  1   If-Modified-Since
         *  2   If-Unmodified-Since
         *  4   If-Match
         *  8   If-None-Match
         *  16  If-Range
         */
        $restrictionMask = 0;
        
        foreach ( $requestHeaders as $requestRestrictionKey=>$value ) {
            if( $requestRestrictionKey == 'If-Modified-Since' ) {

                $restrictionMask = 1;
            }
            else if( $requestRestrictionKey == 'If-Unmodified-Since' ) {

                $restrictionMask = 2;
            }
            else if( $requestRestrictionKey == 'If-Match' ) {

                $restrictionMask = 3;
            }
            else if( $requestRestrictionKey == 'If-None-Match' ) {

                $restrictionMask = 4;
            }
            else if( $requestRestrictionKey == 'If-Range' ) {

                $restrictionMask = 5;
            }
        }
        
        $result = '<queries>';
        
        if( $restrictionMask == 0 ) {
            foreach( $possibleArray as $index=>$value ) {
            
                $result .= "<$index>$value</$index>";
            }
        }
        
        else {
            
            $result .= "<$restrictionMask>$possibleArray[$restrictionMask]</$restrictionMask>";
        }

        $result .= '</queries>';
        
        return $result;
    }
}

?>