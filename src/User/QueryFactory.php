<?php

namespace RudiBieller\OnkelRudi\User;

class QueryFactory
{
    public function createUserInsertQuery()
    {
        return new InsertQuery();
    }

    public function createUserLoginQuery()
    {
        return new LoginQuery();
    }
}
