<?php
namespace RudiBieller\OnkelRudi\Config;

use Symfony\Component\Yaml\Yaml;

class Config
{
    private static $_parsedConfig;
    private $_settingsFilename = 'settings.yml';

    public function __construct($settingsFilename = null)
    {
        if (!is_null($settingsFilename)) {
            $this->_settingsFilename = $settingsFilename;
        }

        $this->_parseConfig();
    }

    public function getConfiguration()
    {
        return self::$_parsedConfig;
    }

    public function getWordpressConfiguration()
    {
        return self::$_parsedConfig['Wordpress'];
    }

    public function getDatabaseConfiguration()
    {
        return self::$_parsedConfig['Database'];
    }

    public function getSystemConfiguration()
    {
        return self::$_parsedConfig['System'];
    }

    public function getMailConfiguration()
    {
        return self::$_parsedConfig['Mail'];
    }

    private function _parseConfig()
    {
        if (is_null(self::$_parsedConfig)) {
            $configFile = dirname(__FILE__) . '/../../deployment/' . $this->_getSettingsFilename();
            $yamlParser = new Yaml();
            self::$_parsedConfig = $yamlParser->parse(file_get_contents($configFile));
        }

        return self::$_parsedConfig;
    }

    private function _getSettingsFilename()
    {
        return $this->_settingsFilename;
    }
}
