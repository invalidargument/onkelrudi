<?php

namespace RudiBieller\OnkelRudi\Wordpress;

class Post
{
    private $_postId;
    private $_date;
    private $_dateModified;
    private $_title;
    private $_content;
    private $_excerpt;
    private $_slug;

    /**
     * @return int
     */
    public function getPostId()
    {
        return $this->_postId;
    }

    /**
     * @param int $id
     * @return Post
     */
    public function setPostId($postId)
    {
        $this->_postId = $postId;
        return $this;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->_date;
    }

    /**
     * @param string $date
     * @return Post
     */
    public function setDate($date)
    {
        $this->_date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateModified()
    {
        return $this->_dateModified;
    }

    /**
     * @param string $dateModified
     * @return Post
     */
    public function setDateModified($dateModified)
    {
        $this->_dateModified = $dateModified;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * @param string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->_title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * @param string $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->_content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getExcerpt()
    {
        return $this->_excerpt;
    }

    /**
     * @param string $excerpt
     * @return Post
     */
    public function setExcerpt($excerpt)
    {
        $this->_excerpt = $excerpt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->_slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->_slug = $slug;
    }
}
