<?php

namespace RudiBieller\OnkelRudi\Controller;

class FleaMarketDetailAction extends AbstractJsonAction
{
    protected function getData()
    {
        return $this->service->getFleaMarket($this->args['id']);
    }
}