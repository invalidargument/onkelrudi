<?php

namespace RudiBieller\OnkelRudi\Wordpress;

interface QueryFactoryInterface
{
    public function createCategoryReadListQuery();

    public function createPostReadListQuery();
}
