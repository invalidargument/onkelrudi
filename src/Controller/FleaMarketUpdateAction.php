<?php

namespace RudiBieller\OnkelRudi\Controller;

class FleaMarketUpdateAction extends AbstractAction
{
    protected function getData()
    {
        $builder = $this->builderFactory->create('RudiBieller\OnkelRudi\FleaMarket\Builder');

        $fleaMarket = $builder->setName('Der erste Flohmarkt von Rudi')
            ->setDescription('Ein toller Flohmarkt')
            ->setCity('Cologne')
            ->setZipCode('5000')
            ->setStreet('Venloer')
            ->setStreetNo('20000')
            ->setStart('2015-12-12 00:00:12')
            ->setEnd('2015-12-12 00:00:33')
            ->setLocation('Daheim')
            ->setUrl('http://www.example.com/foo')
            ->build();

        return $this->service->updateFleaMarket($fleaMarket);
    }
}