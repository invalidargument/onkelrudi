<?php

namespace RudiBieller\OnkelRudi\Controller;

class FleaMarketAction extends AbstractJsonAction
{
    protected function getData()
    {
        // TODO: if not found, return 404
        return $this->service->getFleaMarket($this->args['id']);
    }
}
