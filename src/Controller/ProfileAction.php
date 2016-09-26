<?php

namespace RudiBieller\OnkelRudi\Controller;

class ProfileAction extends AbstractHttpAction implements UserAwareInterface
{
    protected $template = 'profile.html';

    protected function getData()
    {
        $user = $this->userService->getAuthenticationService()->getStorage()->read();

        $myFleamarkets = $this->service->getFleaMarketsByUser($user, 20, 0);

        $this->templateVariables['profileurl'] = $this->app->getContainer()->get('router')->pathFor('login-register');
        $this->templateVariables['createfleamarketurl'] = $this->app->getContainer()->get('router')->pathFor('create-fleamarket');
        $this->templateVariables['fleamarkets'] = $myFleamarkets;

        return $user;
    }
}
