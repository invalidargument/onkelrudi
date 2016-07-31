<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\AbstractJsonAction;
use RudiBieller\OnkelRudi\Controller\UserAwareInterface;
use RudiBieller\OnkelRudi\FleaMarket\Builder;

class FleaMarketDeleteAction extends AbstractJsonAction implements UserAwareInterface
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
