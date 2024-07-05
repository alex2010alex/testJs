<?php

namespace Aliaksei\Test\Messages;

use Aliaksei\Test\Helpers\Session;

class Message
{
    public static function Add(string $message, string $namespace = 'globalMessages')
    {
        if (!Session::Get($namespace)) {
            Session::Set($namespace, []);
        }
        
        Session::Add($namespace, $message);
    }

    public static function Clear(string $namespace = 'globalMessages') {
        Session::Remove($namespace);
    }
}