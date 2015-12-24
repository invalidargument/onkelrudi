<?php
namespace RudiBieller\OnkelRudi\Config;

use Symfony\Component\Yaml\Yaml;

class Config
{
    private static $_parsedConfig;

    public function __construct()
    {
        $this->_parseConfig();
    }

    public function getConfiguration()
    {
        return self::$_parsedConfig;
    }

    public function getDatabaseConfiguration()
    {
        return self::$_parsedConfig['Database'];
    }

    public function getSystemConfiguration()
    {
        return self::$_parsedConfig['System'];
    }

    private function _parseConfig()
    {
        if (is_null(self::$_parsedConfig)) {
            $configFile = dirname(__FILE__) . '/../../deployment/settings.yml';
            $yamlParser = new Yaml();
            self::$_parsedConfig = $yamlParser->parse(file_get_contents($configFile));
        }

        return self::$_parsedConfig;
    }
}
