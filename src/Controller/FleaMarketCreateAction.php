<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\FleaMarket\Organizer;

class FleaMarketCreateAction extends AbstractJsonAction
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
        }

        // if incomplete, return error

        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($builder, $method)) {
                $builder->$method($value);
            }
        }

        return $this->service->createFleaMarket($builder->build());
    }
}
