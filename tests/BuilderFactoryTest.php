<?php

namespace RudiBieller\OnkelRudi;

class BuilderFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;

    protected function setUp()
    {
        $this->_sut = new BuilderFactory();
    }

    /**
     * @dataProvider createDataProvider
     */
    public function testCreateReturnsDesiredBuilder($builder, $expectedType)
    {
        $builder = $this->_sut->create($builder);

        $this->assertEquals($expectedType, get_class($builder));
    }

    public function createDataProvider()
    {
        return array(
            array('RudiBieller\OnkelRudi\FleaMarket\Builder', 'RudiBieller\OnkelRudi\FleaMarket\Builder'),
            array('RudiBieller\OnkelRudi\FleaMarket\OrganizerBuilder', 'RudiBieller\OnkelRudi\FleaMarket\OrganizerBuilder')
        );
    }

    public function testCreateReturnsAlreadyCreatedInstances()
    {
        $createdAction = $this->_sut->create('RudiBieller\OnkelRudi\FleaMarket\Builder');
        $cachedAction = $this->_sut->create('RudiBieller\OnkelRudi\FleaMarket\Builder');

        $this->assertSame($createdAction, $cachedAction);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFactoryThrowsInvalidArgumentExceptionWhenBuilderNotFound()
    {
        $builder = $this->_sut->create('FooBuilder');
    }
}