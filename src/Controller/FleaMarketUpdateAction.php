<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\FleaMarket\Builder;

class FleaMarketUpdateAction extends AbstractAction
{
    protected function getData()
    {
        /**
         * @var Builder
         */
        $builder = $this->builderFactory->create('RudiBieller\OnkelRudi\FleaMarket\Builder');
        $builder->reset();

        $data = json_decode($this->args['data']);

        foreach ($data->data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($builder, $method)) {
                $builder->$method($value);
            }
        }

        return $this->service->updateFleaMarket($builder->build());
    }
}