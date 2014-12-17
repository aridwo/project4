<?php

class Swift_Mime_HeaderEncoder_Base64HeaderEncoderTest extends \PHPUnit_Framework_TestCase
{
    //Most tests are already photoed in Base64EncoderTest since this subclass only
    // adds a getName() method

    public function testNameIsB()
    {
        $encoder = new Swift_Mime_HeaderEncoder_Base64HeaderEncoder();
        $this->assertEquals('B', $encoder->getName());
    }
}
