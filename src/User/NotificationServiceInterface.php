<?php

namespace RudiBieller\OnkelRudi\User;

interface NotificationServiceInterface
{
    public function sendOptInNotification($email, $message);

    public function sendFleaMarketCreatedNotification($fleaMarketIdentifier, $email = 'info@onkel-rudi.de');
}
