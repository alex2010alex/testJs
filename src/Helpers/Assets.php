<?php

namespace Aliaksei\Test\Helpers;

use Aliaksei\Test\Config;

class Assets
{
    private static ?array $Config = null;

    protected static array $AssetsTable = [
        'css',
        'js'
    ];

    public static function IsAsset(string $name): bool
    {
        $explodedName = explode('.', $name);

        return sizeof($explodedName) > 1 && in_array($explodedName[1], static::$AssetsTable) ?:false;
    }

    public static function GetAsset(string $name): BasePage
    {
        if (is_null(static::$Config)) {
            static::$Config = Config::Get('assets');
        }

        $headers = getallheaders();
        
        header('Content-Type: ' . $headers['Accept']);

        require static::$Config['standart'] . $name;

        die();
    }
}
