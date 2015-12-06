<?php

namespace RudiBieller\OnkelRudi;

class BuilderFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider createDataProvider
     */
    public function testCreateReturnsDesiredBuilder($builder, $expectedType)
    {
        $factory = new BuilderFactory();

        $builder = $factory->create($builder);

        $this->assertEquals($expectedType, get_class($builder));
    }

    public function createDataProvider()
    {
        return array(
            array('RudiBieller\OnkelRudi\FleaMarket\Builder', 'RudiBieller\OnkelRudi\FleaMarket\Builder')
        );
    }
}