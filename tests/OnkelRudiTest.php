<?php

namespace RudiBieller\OnkelRudi;

class OnkelRudiTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorDoesBasicSetup()
    {
        $onkelSut = new OnkelRudi();

        $this->assertInternalType('array', $onkelSut->getEnvironmentSettings());
        $this->assertInstanceOf('RudiBieller\OnkelRudi\Config\Config', $onkelSut->getConfig());
    }
}
