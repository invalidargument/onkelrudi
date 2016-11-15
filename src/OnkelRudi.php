<?php

namespace RudiBieller\OnkelRudi;

use RudiBieller\OnkelRudi\Config\Config;

class OnkelRudi
{
    private $_config;
    private $_environmentSettings;

    public function __construct()
    {
        $this->_setUpConfig();

        if ($this->_config->getSystemConfiguration()['environment'] === 'live') {
            error_reporting(0);
        }

        $this->_buildEnvironmentSettings();
    }

    private function _setUpConfig()
    {
        $this->_config = new Config();
    }

    private function _buildEnvironmentSettings()
    {
        $this->_environmentSettings = [
            'displayErrorDetails' => false,
            'cache' => 'templates/cache'
        ];

        if ($this->_config->getSystemConfiguration()['environment'] === 'dev') {
            $this->_environmentSettings['displayErrorDetails'] = true;
            $this->_environmentSettings['cache'] = false;
        }
    }

    public function getConfig()
    {
        return $this->_config;
    }

    public function getEnvironmentSettings()
    {
        return $this->_environmentSettings;
    }
}