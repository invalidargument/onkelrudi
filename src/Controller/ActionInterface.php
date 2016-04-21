<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\BuilderFactoryInterface;
use RudiBieller\OnkelRudi\FleaMarket\OrganizerServiceInterface;
use RudiBieller\OnkelRudi\ServiceInterface;
use RudiBieller\OnkelRudi\User\NotificationServiceInterface;
use RudiBieller\OnkelRudi\User\UserServiceInterface;

interface ActionInterface
{
    public function setApp(\Slim\App $app);

    public function setService(ServiceInterface $service);

    public function setOrganizerService(OrganizerServiceInterface $service);

    public function setUserService(UserServiceInterface $service);

    public function setNotificationService(NotificationServiceInterface $service);

    public function setBuilderFactory(BuilderFactoryInterface $factory);
}
