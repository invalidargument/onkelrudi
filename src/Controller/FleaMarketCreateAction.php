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

        $data = json_decode($this->args['data']);

        if (!$this->_isValidJson()) {
            throw new \InvalidArgumentException('Parameters for FleaMarketCreateAction results in invalid json.');
        }

        foreach ($data->data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($builder, $method)) {
                $builder->$method($value);
            }
        }

        return $this->service->createFleaMarket($builder->build());
    }

    private function _isValidJson()
    {
        return (json_last_error() === JSON_ERROR_NONE);
    }
}