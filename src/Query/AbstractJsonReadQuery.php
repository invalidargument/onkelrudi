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
    protected function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    protected function setUri($uri)
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
        $url = $this->getUri();
        $headers = array('Content-Type: application/json');
        $body = '';

        return $this->getBrowser()
            ->get($url, $headers, $body)
            ->getContent();
    }

    public function setBrowser($browser)
    {
        $this->browser = $browser;
    }

    public function getBrowser()
    {
        if (is_null($this->browser)) {
            $curl = new \Buzz\Client\Curl();
            $curl->setOption(CURLOPT_FOLLOWLOCATION, false);
            $this->browser = new \Buzz\Browser($curl);
        }

        return $this->browser;
    }
}