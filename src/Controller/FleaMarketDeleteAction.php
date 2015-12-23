<?php

namespace RudiBieller\OnkelRudi\Controller;

class FleaMarketDeleteAction extends AbstractAction
{
    protected function getData()
    {
        /**
         * @var Builder
         */
        $builder = $this->builderFactory->create('RudiBieller\OnkelRudi\FleaMarket\Builder');
        $builder->reset();

        if (!$this->_isValidId()) {
            throw new \InvalidArgumentException('Parameter for FleaMarketDeleteAction invalid.');
        }

        $builder->setId($this->args['id']);

        return $this->service->deleteFleaMarket($builder->build());
    }

    private function _isValidId()
    {
        return is_numeric($this->args['id']);
    }
}