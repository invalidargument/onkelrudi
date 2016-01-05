<?php

namespace RudiBieller\OnkelRudi\Controller;

class FleaMarketsAction extends AbstractJsonAction
{
    protected function getData()
    {
        return $this->service->getAllFleaMarkets();
    }
}
