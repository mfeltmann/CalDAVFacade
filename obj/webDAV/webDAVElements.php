<?php

class WebDAVElement {
    
    /** Constructor **/
    
    public function __construct() {
        
        $this->document = new DOMDocument();
    }
    
    // 12.1 lockscope XML Element
    public function activeLockElement( $shared = false, $depth = 0, $owner = null, $timeout = null, $token = null ) {
    
        $parentElement = $this->document->createElement( 'activelock' );
        
        $parentElement->appendChild( $this->lockscopeElement( $shared ) );
        $parentElement->appendChild( $this->locktypeElement() );
        $parentElement->appendChild( $this->depthElement( $depth ) );
        
        if( $owner != null ) {
            
            $parentElement->appendChild( $this->ownerElement( $owner ) );
        }
        
        if( $timeout != null ) {
            
            $parentElement->appendChild( $this->timeoutElement( $timeout ) );
        }
        
        if( $token != null ) {
            
            $parentElement->appendChild( $this->locktokenElement( $token ) );
        }
        
        print( "\n\n|:".$this->document->saveXML( $parentElement ).":|\n" );
        
        return $parentElement;
    }
    
    
    /** Privae Stuff **/
    
    private $document;
    

    /** Now proteced functions follow **/
    
    // 12.8 locktype XML Element
    protected function locktypeElement() {
        
        $parentElement = $this->document->createElement( 'locktype' );
        $parentElement->appendChild( $this->locktypeWriteElement() );
        
        return $parentElement;
    }
    
    // 12.7 lockscope XML Element
    protected function lockscopeElement( $isScopeShared ) {
        
        $parentElement = $this->document->createElement( 'lockscope' );
        
        if( $isScopeShared == true ) {
        
            $parentElement->appendChild( $this->lockscopeSharedElement() );
        }
        
        else {
            
            $parentElement->appendChild( $this->lockscopeExclusiveElement() );
        }
        
        return $parentElement;
    }
    
    // 12.1.1   depth XML Element
    protected function depthElement( $depth) {
        
        $parentElement = $this->document->createElement( 'depth' );
        
        switch ( $depth ) {
            
            case '0':
                $parentElement->appendChild( $this->depthZeroElement() );
                break;
        
            case '1':
                $parentElement->appendChild( $this->depthOneElement() );
                break;
            
            default:
                $parentElement->appendChild( $this->depthInfinityElement() );
                break;
        }
        
        return $parentElement;
    }
    
    
    protected function ownerElement( $owner ) {
        
        $ownerElement = $this->document->createElement( 'owner' );
        
        return $ownerElement;
    }
    
    protected function timeoutElement( $timeout ) {
        
        $timeoutElement = $this->document->createElement( 'timeout' );
        
        return $timeoutElement;
    }
    
    protected function locktokenElement( $token ) {
        
        $tokenElement = $this->document->createElement( 'token' );
        
        return $tokenElement;
    }


    /** Subfunctions **/
    
    // 12.8.1   write XML Element
    protected function locktypeWriteElement() {
        
        return new DOMElement( 'write' );
    }
    
    // 12.7.1   exclusive XML Element
    protected function lockscopeExclusiveElement() {
        
        return new DOMElement( 'exclusive' );
    }
    
    // 12.7.2   shared XML Element
    protected function lockscopeSharedElement() {
        
        return new DOMElement( 'shared' );
    }

    //  12.1.1: Values
    protected function depthZeroElement() {
        
        return new DOMText( '0' );
    }
    
    protected function depthOneElement() {
        
        return new DOMText( '1' );
    }
    
    protected function depthInfinityElement() {
        
        return new DOMText( 'infinity' );
    }

}

?>