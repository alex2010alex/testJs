<?php

namespace Aliaksei\Test\Helpers\ClassManegment;

class Search
{
    public static function ClassExists(
        string $path,
        string $prefix,
        string $name,
        bool|string $fileName = false 
    ): mixed {
        $result = false;

        $className = $prefix . implode(
            '', 
            array_map(function($part) {
                return ucfirst($part);
            }, explode('-', $name))
        );

        require $path . ($fileName ? $fileName: $name) . '.php';

        if (class_exists($className)) {
            $result = [
                'className' => $className
            ];
        }

        return $result;
    }
}