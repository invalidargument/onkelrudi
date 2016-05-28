<?php

namespace RudiBieller\OnkelRudi\Controller;

class ProfileAction extends AbstractHttpAction implements UserAwareInterface
{
    protected $template = 'profile.html';

    protected function getData()
    {
        return $this->userService->getAuthenticationService()->getStorage()->read();
    }
}
