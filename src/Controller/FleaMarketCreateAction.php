<?php

namespace RudiBieller\OnkelRudi\Controller;

class FleaMarketCreateAction extends AbstractAction
{
    protected function getData()
    {
        /**
         * @var Builder
         */
        $builder = $this->builderFactory->create('RudiBieller\OnkelRudi\FleaMarket\Builder');
        $builder->reset();

        $data = $this->request->getParsedBody();

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