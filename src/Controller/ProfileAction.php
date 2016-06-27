<?php

namespace RudiBieller\OnkelRudi\Controller;

class ProfileAction extends AbstractHttpAction implements UserAwareInterface
{
    protected $template = 'profile.html';

    protected function getData()
    {
        $this->templateVariables['profileurl'] = $this->app->getContainer()->get('router')->pathFor('login-register');
        $this->templateVariables['createfleamarketurl'] = $this->app->getContainer()->get('router')->pathFor('create-fleamarket');

        return $this->userService->getAuthenticationService()->getStorage()->read();
    }
}
