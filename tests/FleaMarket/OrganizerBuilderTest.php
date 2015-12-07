<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

class OrganizerBuilderTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;

    protected function setUp()
    {
        $this->_sut = new OrganizerBuilder();
    }

    public function testBuilderReturnsConfiguredOrganizer()
    {
        $expected = new Organizer();
        $expected
            ->setCity('cologne')
            ->setId(2)
            ->setName('baz')
            ->setStreet('Venloer')
            ->setStreetNo(23)
            ->setPhone('020 123')
            ->setUrl('http://example.com')
            ->setZipCode('12345');

        $result = $this->_sut
            ->setCity('cologne')
            ->setId(2)
            ->setName('baz')
            ->setStreet('Venloer')
            ->setStreetNo(23)
            ->setPhone('020 123')
            ->setUrl('http://example.com')
            ->setZipCode('12345')
            ->build();

        $this->assertEquals($expected, $result);
    }
}
