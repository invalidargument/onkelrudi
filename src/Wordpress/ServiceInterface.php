<?php

namespace RudiBieller\OnkelRudi\Wordpress;

interface ServiceInterface
{
    public function getAllCategories();

    public function getPosts(Category $category, $offset = 0, $limit = 10);

    public function getPost($identifier);
}
