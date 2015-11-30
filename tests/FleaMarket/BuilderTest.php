<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;

    protected function setUp()
    {
        $this->_sut = new Builder();
    }

    public function testBuilderReturnsConfiguredFleaMarket()
    {
        $organizer = new Organizer();

        $expected = new FleaMarket();
        $expected
            ->setCity('cologne')
            ->setDescription('foo')
            ->setEnd('2015-12-12 00:00:00')
            ->setStart('2015-12-13 00:00:00')
            ->setId(2)
            ->setLocation('bar')
            ->setName('baz')
            ->setOrganizer($organizer)
            ->setStreet('Venloer')
            ->setStreetNo(23)
            ->setUrl('http://example.com')
            ->setZipCode('12345');

        $result = $this->_sut
            ->setCity('cologne')
            ->setDescription('foo')
            ->setEnd('2015-12-12 00:00:00')
            ->setStart('2015-12-13 00:00:00')
            ->setId(2)
            ->setLocation('bar')
            ->setName('baz')
            ->setOrganizer($organizer)
            ->setStreet('Venloer')
            ->setStreetNo(23)
            ->setUrl('http://example.com')
            ->setZipCode('12345')
            ->build();

        $this->assertEquals($expected, $result);
    }
}
