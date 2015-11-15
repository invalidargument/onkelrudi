<?php
namespace RudiBieller\OnkelRudi\Query;

abstract class AbstractInsertQuery extends AbstractQuery
{
    protected function mapResult()
    {
        return true;
    }
}