<?php

namespace RudiBieller\OnkelRudi\Wordpress;

class Category
{
    private $_id;
    private $_count;
    private $_parent;
    private $_name;
    private $_seoName;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param int $id
     * @return Category
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->_count;
    }

    /**
     * @param int $count
     * @return Category
     */
    public function setCount($count)
    {
        $this->_count = $count;
        return $this;
    }

    /**
     * @return int
     */
    public function getParent()
    {
        return $this->_parent;
    }

    /**
     * @param int $parent
     * @return Category
     */
    public function setParent($parent)
    {
        $this->_parent = $parent;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeoName()
    {
        return $this->_seoName;
    }

    /**
     * @param mixed $seoName
     * @return Category
     */
    public function setSeoName($seoName)
    {
        $this->_seoName = $seoName;
        return $this;
    }
}
