<?php

class HttpBody {
    
    function sendBody( $requestMethod, $queryString, $requestHeaders ) {
        
        // Neither HEAD nor OPTIONS require a body.
        
        if( $requestMethod == get_request ) {
            echo self::getBodyForResourceFilteredByHeaders( $queryString, $requestHeaders );
        }
        
    }
    
    function getBodyForResourceFilteredByHeaders( $resource, $requestHeaders ) {
        
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