<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\User\Organizer;

class ProfileAction extends AbstractHttpAction implements UserAwareInterface
{
    protected $template = 'profile.html';

    protected function getData()
    {
        $user = $this->userService->getAuthenticationService()->getStorage()->read();

        $myFleamarkets = $this->service->getFleaMarketsByUser($user, 20, 0);

        $organizer = null;
        if (count($myFleamarkets) > 0 && ($user instanceof Organizer)) {
            $organizer = $this->organizerService->getOrganizerByUserId($user->getIdentifier());
        }

        $this->templateVariables['profileurl'] = $this->app->getContainer()->get('router')->pathFor('login-register');
        $this->templateVariables['createfleamarketurl'] = $this->app->getContainer()->get('router')->pathFor('create-fleamarket');
        $this->templateVariables['fleamarkets'] = $myFleamarkets;
        $this->templateVariables['organizer'] = $organizer;
        $this->templateVariables['profileurl'] = $this->app->getContainer()->get('router')->pathFor('profile');

        return $user;
    }
}
