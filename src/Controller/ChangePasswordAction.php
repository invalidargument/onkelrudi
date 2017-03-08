<?php

namespace RudiBieller\OnkelRudi\Controller;

class ChangePasswordAction extends AbstractHttpAction implements UserAwareInterface
{
    protected $template = 'password.html';

    protected function getData()
    {
        return array();
    }
}
