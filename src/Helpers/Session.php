<?php

namespace Aliaksei\Test\Helpers;

class Session
{
    public static function Get(string $name): mixed
    {
        //session_start();

        $result = isset($_SESSION[$name]) ? $_SESSION[$name]: false;

        //session_write_close();
        
        return $result;
    }

    public static function Set(string $name, mixed $value): void
    {
        //session_start();

        $_SESSION[$name] = $value;

        //session_write_close();
    }

    public static function Add(string $name, mixed $value): void
    {
        if (!isset($_SESSION[$name])) {
            static::Set($name, $value);
        } else if (is_array($_SESSION[$name])) {
            //session_start();
            
            $_SESSION[$name][] = $value;

            //session_write_close();
        }
    }

    public static function Remove(string $name): void
    {
        //session_start();

        unset($_SESSION[$name]);

        //session_write_close();
    }
}
