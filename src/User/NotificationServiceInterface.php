<?php

namespace RudiBieller\OnkelRudi\User;

interface NotificationServiceInterface
{
    public function sendOptInNotification($email, $message);
}
