<?php

namespace RudiBieller\OnkelRudi\Controller;

class FleaMarketDetailAction extends AbstractHttpAction
{
    protected function getData()
    {
        return [$this->service->getFleaMarket($this->args['id'])];
    }
}
