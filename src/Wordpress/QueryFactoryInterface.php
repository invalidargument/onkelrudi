<?php

namespace RudiBieller\OnkelRudi\Wordpress;

interface QueryFactoryInterface
{
    function createCategoryReadListQuery();

    function createPostReadListQuery();
}