<?php

namespace RudiBieller\OnkelRudi\User;

interface UserServiceInterface
{
    public function createUser($identifier, $password);

    public function login($identifier, $password);

    public function getAuthenticationService(UserInterface $user);
}
