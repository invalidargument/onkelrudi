<?php

namespace RudiBieller\OnkelRudi\User;

interface UserServiceInterface
{
    public function createUser($identifier, $password);

    public function createOrganizerUser($identifier, $password);

    public function createAdminUser($identifier, $password);

    public function createOptInToken($identifier);

    public function createTestOptInToken($identifier, $token);

    public function login(UserInterface $user);

    public function getAuthenticationService(UserInterface $user);

    public function optIn($token);

    /**
     * Only for acceptance testing purposes!
     * @param String $identifier
     * @return int
     */
    public function optInTestUser($identifier);
    
    public function isLoggedIn();

    /**
     * @param string $identifier
     * @return UserInterface
     */
    public function getUser($identifier);

    public function changePassword(UserInterface $user, $newPassword);

    public function getOrganizerIdByUserId($userId);
}
