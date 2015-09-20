<?php

class HttpBody {
    
    function sendBody( $requestMethod, $entityType, $entityID, $requestHeaders, $requestBody ) {
        
        // Neither HEAD nor OPTIONS require a body.
        
        $combinedEntityInformation = $entityType;
        
        if( $entityID !== '' ) {
            
            $combinedEntityInformation .= '='.$entityID;
        }
        
        if( $requestMethod == get_request ) {
            
            echo self::getBodyForResourceFilteredByHeaders( $combinedEntityInformation, $requestHeaders );
        }
        else if( $requestMethod == post_request ) {

            if( $entityType == 'create' ) {

                echo self::getBodyForResourceFilteredByHeaders( $combinedEntityInformation, $requestHeaders, $requestBody );                
            }
        }
        else if( $requestMethod == put_request ) {
            
            if( $entityID == 'common' ) {
                
                echo 'Success';
                return;
            }
        }
        
        else if( $requestMethod == delete_request ) {
            
            if( $entityID == 'common' ) {
                
                echo 'Success';
                return;
            }
        }
    }
    
    function sendBodyMessage( $message ) {
        
        echo $message;
        return;
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