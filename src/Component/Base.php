<?php

namespace Aliaksei\Test\Component;

use Aliaksei\Test\Config;
use Aliaksei\Test\Localization\Message;
use Aliaksei\Test\Helpers\ClassManegment\Search;
use Aliaksei\Test\Helpers\Interfaces\Renderable;

class Base implements Renderable
{
    private static ?array $Config = null;

    protected string $name;

    protected string $componentDir;
    
    protected string $template;

    protected function __construct(
        string $name,
        string $componentDir,
        string $template
    ) {
        $this->name = $name;
        $this->componentDir = $componentDir;
        $this->template = $template;
    }

    public function render()
    {
        require $this->componentDir . 'templates/' . $this->template . '/template.php';
    }

    public static function GetComponent(
        string $name,
        string $template = '.default'
    ): Base {
        if (is_null(static::$Config)) {
            static::$Config = Config::Get('view');
        }

        $componentDir = static::$Config['components'] . $name . '/';

        
        if ($controllerInformation = Search::ClassExists(
            $componentDir,
            'Component',
            $name,
            'component'
        )) {
            return new $controllerInformation['className'](
                $name,
                $componentDir,
                $template
            );
        }

        throw new \Exception($controllerInformation['className'] . ' ' . Message::Get('CONTROLLER_NOT_FOUND'));
    }
}