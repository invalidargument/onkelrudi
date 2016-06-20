<?php

namespace RudiBieller\OnkelRudi\Controller;

class ProfileAction extends AbstractHttpAction implements UserAwareInterface
{
    protected $template = 'profile.html';

    protected function getData()
    {
        $this->templateVariables['profileurl'] = $this->app->getContainer()->get('router')->pathFor('login-register');

        return $this->userService->getAuthenticationService()->getStorage()->read();
    }
}
