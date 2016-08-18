<?php

namespace RudiBieller\OnkelRudi\Wordpress;

use RudiBieller\OnkelRudi\CacheableInterface;
use RudiBieller\OnkelRudi\Query\AbstractJsonReadQuery;

class PostReadQuery extends AbstractJsonReadQuery implements CacheableInterface
{
    private $_id;

    protected function getUri()
    {
        $wpConfig = $this->diContainer->get('config')->getWordpressConfiguration();
        $systemConfig = $this->diContainer->get('config')->getSystemConfiguration();

        return $systemConfig['protocol'] . $wpConfig['api-domain'] .
        $wpConfig['api-base-url'] . $wpConfig['api-get-post'] . $this->getId();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param int $id
     * @return PostReadQuery
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    protected function mapResult($result)
    {
        $post = json_decode($result);

        if (count($post) === 0) {
            return array();
        }

        $item = new Post();
        $item->setId($post->id)
            ->setDate($post->date) //gmt???
            ->setDateModified($post->modified) //gmt???
            ->setTitle($post->title->rendered)
            ->setExcerpt($post->excerpt->rendered)
            ->setContent($post->content->rendered)
            ->setSlug($post->slug);

        return $item;
    }
}
