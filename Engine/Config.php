<?php
namespace Engine;

class Config
{
    private $configFile = 'Engine/config.json';
    private $configData = [];

    public function __construct()
    {
        $this->loadConfiguration();
    }

    private function loadConfiguration()
    {
        if (file_exists($this->configFile)) {
            $json = file_get_contents($this->configFile);
            $this->configData = json_decode($json, true);
        }
    }

    public function getAll()
    {
        return $this->configData;
    }

    public function get($key, $defaultValue = null)
    {
        // If into the array exists other array with the key
        if (isset($this->configData[$key]) && is_array($this->configData[$key])) {
            return $this->configData[$key];
        } else {
            return $defaultValue;
        }
    }

    public function set($type, $key, $value)
    {
        $this->configData[$type][$key] = $value;
        $this->save();
    }

    private function save()
    {
        $json = json_encode($this->configData, JSON_PRETTY_PRINT);
        file_put_contents($this->configFile, $json);
    }
}

