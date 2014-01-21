<?php

namespace Providers;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Yaml\Yaml;

class ConfigServiceProvider implements ServiceProviderInterface
{
    private $_filename;
    private $_replacements = array();

    public function __construct($filename, array $replacements = array())
    {
        $this->_filename = $filename;

        if ($replacements) {
            foreach ($replacements as $key => $value) {
                $this->_replacements['%'.$key.'%'] = $value;
            }
        }
    }

    public function register(Application $app)
    {
        $config = $this->readConfig();

        foreach ($config as $name => $value) {
            $app[$name] = $this->doReplacements($value);
        }
    }

    public function boot(Application $app)
    {
    }

    private function doReplacements($value)
    {
        if (!$this->_replacements) {
            return $value;
        }

        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = $this->doReplacements($v);
            }

            return $value;
        }

        if (is_string($value)) {
            return strtr($value, $this->_replacements);
        }

        return $value;
    }

    private function readConfig()
    {
        $config = Yaml::parse($this->_filename);
        return ($config) ? $config : array();

    }
}