<?php

namespace RudiBieller\OnkelRudi\User;

class QueryFactory
{
    public function createUserInsertQuery()
    {
        return new UserInsertQuery();
    }
}