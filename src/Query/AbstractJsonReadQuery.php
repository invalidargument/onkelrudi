<?php

namespace RudiBieller\OnkelRudi\Query;

abstract class AbstractJsonReadQuery implements QueryInterface
{
    protected $uri;
    protected $browser;

    abstract protected function mapResult($result);

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    public function run()
    {
        return $this->mapResult($this->runQuery());
    }

    protected function runQuery()
    {
        $curl = new \Buzz\Client\Curl();
        $curl->setOption(CURLOPT_FOLLOWLOCATION, false);
        $this->browser = new \Buzz\Browser($curl);

        $url = $this->getUri();
        $headers = array('Content-Type: application/json');
        $body = '';

        return $this->browser->get($url, $headers, $body)->getContent();
    }
}