<?php

namespace RudiBieller\OnkelRudi\User;

class QueryFactory
{
    public function createUserInsertQuery()
    {
        return new InsertQuery();
    }

    public function createOptInTokenInsertQuery()
    {
        return new OptInTokenInsertQuery();
    }

    public function createOptInTokenUpdateQuery()
    {
        return new OptInTokenUpdateQuery();
    }
}
