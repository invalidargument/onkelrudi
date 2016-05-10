<?php

namespace RudiBieller\OnkelRudi\User;

interface UserServiceInterface
{
    public function createUser($identifier, $password);

    public function createOptInToken($identifier);

    public function login(UserInterface $user);

    public function getAuthenticationService(UserInterface $user);

    public function optIn($token);
}
