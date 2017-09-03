<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\CacheableInterface;

class AboutAction extends AbstractHttpAction implements CacheableInterface
{
    protected $template = 'about.html';

    protected function getData()
    {
        return array();
    }
}
