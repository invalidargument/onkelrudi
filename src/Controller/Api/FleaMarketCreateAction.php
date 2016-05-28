<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\AbstractJsonAction;
use RudiBieller\OnkelRudi\Controller\UserAwareInterface;
use RudiBieller\OnkelRudi\FleaMarket\Builder;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;

class FleaMarketCreateAction extends AbstractJsonAction implements UserAwareInterface
{
    protected function getData()
    {
        /**
         * @var Builder
         */
        $builder = $this->builderFactory->create('RudiBieller\OnkelRudi\FleaMarket\Builder');
        $builder->reset();

        $data = $this->request->getParsedBody();

        if (array_key_exists('organizerId', $data)) {
            $organizer = new Organizer();
            $organizer->setId($data['organizerId']);
            $data['organizer'] = $organizer;
            unset($data['organizerId']);
        }

        $data['dates'] = $this->_mapDates($data['dates']);

        // TODO if incomplete, return error

        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($builder, $method)) {
                $builder->$method($value);
            }
        }

        return $this->service->createFleaMarket($builder->build());
    }

    private function _mapDates(array $dates)
    {
        $map = array();

        foreach ($dates as $date) {
            $map[] = new FleaMarketDate($date['start'], $date['end']);
        }

        return $map;
    }
}
