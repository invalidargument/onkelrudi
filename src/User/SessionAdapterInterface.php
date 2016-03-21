<?php

namespace RudiBieller\OnkelRudi\User;

interface SessionAdapterInterface
{
    public function __construct(SessionManagerInterface $manager);

    public function startSession();

    public function terminateSession();

    public function getSessionValue($name);

    public function setSessionValue($name, $value);

    public function flush();

    public function getSession();
}