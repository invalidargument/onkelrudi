<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\AbstractJsonAction;

class FleaMarketAction extends AbstractJsonAction
{
    protected function getData()
    {
        // TODO: if not found, return 404
        return $this->service->getFleaMarket($this->args['id']);
    }
}
