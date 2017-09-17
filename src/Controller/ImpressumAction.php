<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\CacheableInterface;

/**
 * @codeCoverageIgnore
 */
class ImpressumAction extends AbstractHttpAction implements CacheableInterface
{
    protected $template = 'impressum.html';

    protected function getData()
    {
        return array();
    }
}
