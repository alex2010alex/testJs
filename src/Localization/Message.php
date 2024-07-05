<?php

namespace Aliaksei\Test\Localization;

class Message
{
    private static ?array $Messages = null;

    public static function Get(string $name, string $locale = 'en'): string
    {
        if (is_null(static::$Messages)) {
            static::LoadMessages($locale);
        }

        return static::$Messages[$name];
    }

    private static function LoadMessages($locale)
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/locals/' . $locale . '/strings.php';

        static::$Messages = isset($MESS) ? $MESS: [];
    }
}
