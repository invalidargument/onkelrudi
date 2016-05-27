<?php

namespace RudiBieller\OnkelRudi\Query;

use Buzz\Listener\BasicAuthListener;
use RudiBieller\OnkelRudi\Config\Config;
use Slim\Container;

abstract class AbstractJsonReadQuery implements QueryInterface
{
    protected $uri;
    protected $browser;
    /**
     * @var \Slim\Container
     */
    protected $diContainer;

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

    public function setDiContainer(Container $diContainer)
    {
        $this->diContainer = $diContainer;
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

        if ($this->needsBasicAuthentication()) {
            $this->addAuthListenerToBrowser();
        }

        return $this->browser;
    }

    protected function addAuthListenerToBrowser()
    {
        $wpConfig = $this->diContainer->config->getWordpressConfiguration();

        $username = $wpConfig['auth-username'];
        $password = $wpConfig['auth-password'];

        $this->browser->addListener(
            new BasicAuthListener($username, $password)
        );
    }

    protected function needsBasicAuthentication()
    {
        return true;
    }
}
