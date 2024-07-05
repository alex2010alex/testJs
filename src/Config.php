<?php

namespace Aliaksei\Test;

use Aliaksei\Test\Localization\Message;

class Config
{
    public static function Get(string $configName): array
    {
        $configName = $configName . '.php';
        $configPath = $_SERVER['DOCUMENT_ROOT'] . '/config/' . $configName;
        
        require $configPath;

        if (!isset($config)) {
            throw new \Exception(Message::Get('EMPTY_CONFIG') . ' ' . $configName);
        }

        return $config;
    }
}