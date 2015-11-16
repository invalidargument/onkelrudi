<?php
namespace RudiBieller\OnkelRudi\Query;

abstract class AbstractInsertQuery extends AbstractQuery
{
    protected function mapResult($result)
    {
        return true;
    }
}