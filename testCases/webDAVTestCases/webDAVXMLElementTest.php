<?php

require_once '../obj/webDAV/webDAVElements.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class webDAVXMLElementTest extends PHPUnit_Framework_TestCase {
    
    public function testActiveLockXMLElementMinimalRepresentation() {
        
        $elementFactory = new WebDAVElement();
        
        $document = new DOMDocument();
        
        $exclusiveElement = new DOMElement( 'exclusive' );
        $lockscopeElement = $document->createElement( 'lockscope' );
        $lockscopeElement->appendChild( $exclusiveElement );
        
        $writeElement = new DOMElement( 'write' );
        $locktypeElement = $document->createElement( 'locktype' );
        $locktypeElement->appendChild( $writeElement );

        $depthElement = $document->createElement( 'depth' );
        $depthElement->appendChild( new DOMText( '0' ) );
        
        $expectedDOM = $document->createElement( 'activelock' );
        $expectedDOM->appendChild( $lockscopeElement );
        $expectedDOM->appendChild( $locktypeElement );
        $expectedDOM->appendChild( $depthElement );
                
        $xml = $elementFactory->activeLockElement();        
        $this->assertEqualXMLStructure( $expectedDOM, $xml );
    }

/** XML Element Definition Test Cases
* 12.1.3	locktoken XML Element
* 12.1.4	timeout XML Element
* 12.2	collection XML Element
* 12.3	href XML Element
* 12.4	link XML Element
* 12.4.1	dst XML Element
* 12.4.2	src XML Element
* 12.5	lockentry XML Element
* 12.6	lockinfo XML Element
* 12.9	multistatus XML Element
* 12.9.1	response XML Element
* 12.9.2	responsedescription XML Element
* 12.10	owner XML Element
* 12.11	prop XML Element
* 12.12	propertybehavior XML Element
* 12.12.1	keepalive XML Element
* 12.12.2	omit XML Element
* 12.13	propertyupdate XML Element
* 12.13.1	remove XML Element
* 12.13.2	set XML Element
* 12.14	propfind XML Element
* 12.14.1	allprop XML Element
* 12.14.2	propname XML Element
*/
}