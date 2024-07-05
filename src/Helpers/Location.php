<?php

namespace Aliaksei\Test\Helpers;

class Location
{
    public static function Redirect(string $path): void
    {
        ob_end_clean();
        
        header('Location: ' . $path);
        
        die();
    }
}